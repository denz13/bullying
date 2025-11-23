// Function to show notification toast
window.showNotificationToast = function(type, title, message) {
    const toastContainer = document.getElementById('toast-container') || createToastContainer();
    
    const toastId = 'toast-' + Date.now();
    const colors = {
        'success': 'bg-emerald-50 text-emerald-800 border-emerald-100 dark:bg-emerald-500/10 dark:text-emerald-200 dark:border-emerald-500/30',
        'info': 'bg-blue-50 text-blue-800 border-blue-100 dark:bg-blue-500/10 dark:text-blue-200 dark:border-blue-500/30',
        'warning': 'bg-amber-50 text-amber-800 border-amber-100 dark:bg-amber-500/10 dark:text-amber-200 dark:border-amber-500/30',
        'danger': 'bg-rose-50 text-rose-800 border-rose-100 dark:bg-rose-500/10 dark:text-rose-200 dark:border-rose-500/30',
    };
    
    const colorClasses = colors[type] || colors['info'];
    
    const toastElement = document.createElement('div');
    toastElement.id = toastId;
    toastElement.className = 'mb-4 opacity-0 translate-x-full transition-all duration-300';
    
    toastElement.innerHTML = `
        <div class="${colorClasses} rounded-2xl border px-5 py-4 text-sm shadow-lg shadow-black/5">
            <div class="flex justify-between gap-4">
                <div class="space-y-1">
                    <p class="text-base font-semibold">${title}</p>
                    <p>${message}</p>
                </div>
                <button
                    type="button"
                    class="inline-flex h-8 w-8 items-center justify-center rounded-full text-current/70 hover:text-current close-toast"
                    data-toast-id="${toastId}"
                >
                    <span class="sr-only">Close</span>
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    `;
    
    toastContainer.appendChild(toastElement);
    
    // Animate in
    setTimeout(() => {
        toastElement.classList.remove('opacity-0', 'translate-x-full');
        toastElement.classList.add('opacity-100', 'translate-x-0');
    }, 10);
    
    // Close button handler
    const closeBtn = toastElement.querySelector('.close-toast');
    if (closeBtn) {
        closeBtn.addEventListener('click', () => {
            removeToast(toastElement);
        });
    }
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        removeToast(toastElement);
    }, 5000);
};

function removeToast(toastElement) {
    if (toastElement && toastElement.parentNode) {
        toastElement.classList.remove('opacity-100', 'translate-x-0');
        toastElement.classList.add('opacity-0', 'translate-x-full');
        setTimeout(() => {
            if (toastElement.parentNode) {
                toastElement.parentNode.removeChild(toastElement);
            }
        }, 300);
    }
}

function createToastContainer() {
    const container = document.createElement('div');
    container.id = 'toast-container';
    container.className = 'fixed top-6 right-6 z-[10001] space-y-4 max-w-md';
    document.body.appendChild(container);
    return container;
}

document.addEventListener('alpine:init', () => {
    Alpine.data('actionCenterActions', () => ({
        approveRequest(request) {
            if (!request || !request.id) {
                console.error('No request selected');
                return;
            }

            // Store request data globally
            window.approveRequestData = request;
            
            // Open modal (Action Center version)
            window.dispatchEvent(new CustomEvent('open-modal', {
                detail: 'action-center-approve-request-modal'
            }));
        },
        rejectRequest(request) {
            if (!request || !request.id) {
                console.error('No request selected');
                return;
            }

            // Store request data globally
            window.rejectRequestData = request;
            
            // Clear previous reason
            const reasonInput = document.getElementById('actionCenterRejectReason');
            if (reasonInput) {
                reasonInput.value = '';
            }
            
            // Open modal (Action Center version)
            window.dispatchEvent(new CustomEvent('open-modal', {
                detail: 'action-center-reject-request-modal'
            }));
        }
    }));
});

// Handle approve confirmation
document.addEventListener('DOMContentLoaded', () => {
    const confirmApproveBtn = document.getElementById('confirmApproveBtn');
    if (confirmApproveBtn) {
        // Remove existing listeners
        const newBtn = confirmApproveBtn.cloneNode(true);
        confirmApproveBtn.parentNode.replaceChild(newBtn, confirmApproveBtn);
        
        newBtn.addEventListener('click', async () => {
            const request = window.approveRequestData;
            if (!request || !request.id) {
                return;
            }

            try {
                const response = await fetch(`/request-counseling/${request.id}/approve`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                    },
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    if (window.showNotificationToast) {
                        window.showNotificationToast('success', 'Request Approved', data.message || 'Counseling request has been approved successfully.');
                    }
                    
                    // Close modal (Action Center version)
                    window.dispatchEvent(new CustomEvent('close-modal', {
                        detail: 'action-center-approve-request-modal'
                    }));
                    
                    // Reload page after 1 second to reflect changes
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    if (window.showNotificationToast) {
                        window.showNotificationToast('danger', 'Error', data.message || 'Failed to approve the request. Please try again.');
                    }
                }
            } catch (error) {
                console.error('Error approving request:', error);
                if (window.showNotificationToast) {
                    window.showNotificationToast('danger', 'Error', 'An error occurred while approving the request. Please try again.');
                }
            }
        });
    }

    // Handle reject confirmation
    const confirmRejectBtn = document.getElementById('confirmRejectBtn');
    if (confirmRejectBtn) {
        // Remove existing listeners
        const newBtn = confirmRejectBtn.cloneNode(true);
        confirmRejectBtn.parentNode.replaceChild(newBtn, confirmRejectBtn);
        
        newBtn.addEventListener('click', async () => {
            const request = window.rejectRequestData;
            if (!request || !request.id) {
                return;
            }

            const reasonInput = document.getElementById('actionCenterRejectReason');
            const reason = reasonInput ? reasonInput.value.trim() : '';

            if (!reason) {
                if (window.showNotificationToast) {
                    window.showNotificationToast('warning', 'Reason Required', 'Please provide a reason for rejection.');
                }
                if (reasonInput) {
                    reasonInput.focus();
                }
                return;
            }

            try {
                const response = await fetch(`/request-counseling/${request.id}/reject`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                    },
                    body: JSON.stringify({ note: reason }),
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    if (window.showNotificationToast) {
                        window.showNotificationToast('success', 'Request Rejected', data.message || 'Counseling request has been rejected.');
                    }
                    
                    // Close modal (Action Center version)
                    window.dispatchEvent(new CustomEvent('close-modal', {
                        detail: 'action-center-reject-request-modal'
                    }));
                    
                    // Reload page after 1 second to reflect changes
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    if (window.showNotificationToast) {
                        window.showNotificationToast('danger', 'Error', data.message || 'Failed to reject the request. Please try again.');
                    }
                }
            } catch (error) {
                console.error('Error rejecting request:', error);
                if (window.showNotificationToast) {
                    window.showNotificationToast('danger', 'Error', 'An error occurred while rejecting the request. Please try again.');
                }
            }
        });
    }
});

