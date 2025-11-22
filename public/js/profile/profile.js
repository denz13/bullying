// Function to show notification toast (if not already defined)
if (typeof window.showNotificationToast === 'undefined') {
    window.showNotificationToast = function(type, title, message) {
        const toastContainer = document.getElementById('toast-container') || (() => {
            const container = document.createElement('div');
            container.id = 'toast-container';
            container.className = 'fixed top-6 right-6 z-[10001] space-y-4 max-w-md';
            document.body.appendChild(container);
            return container;
        })();
        
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
        
        setTimeout(() => {
            toastElement.classList.remove('opacity-0', 'translate-x-full');
            toastElement.classList.add('opacity-100', 'translate-x-0');
        }, 10);
        
        const closeBtn = toastElement.querySelector('.close-toast');
        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                toastElement.classList.remove('opacity-100', 'translate-x-0');
                toastElement.classList.add('opacity-0', 'translate-x-full');
                setTimeout(() => {
                    if (toastElement.parentNode) {
                        toastElement.parentNode.removeChild(toastElement);
                    }
                }, 300);
            });
        }
        
        setTimeout(() => {
            toastElement.classList.remove('opacity-100', 'translate-x-0');
            toastElement.classList.add('opacity-0', 'translate-x-full');
            setTimeout(() => {
                if (toastElement.parentNode) {
                    toastElement.parentNode.removeChild(toastElement);
                }
            }, 300);
        }, 5000);
    };
}

document.addEventListener('alpine:init', () => {
    Alpine.data('profileForm', () => ({
        submitting: false,
        init() {
            // Handle profile image preview
            const profileImageInput = document.getElementById('profile_image_input');
            if (profileImageInput) {
                profileImageInput.addEventListener('change', (e) => {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = (event) => {
                            const previewContainer = profileImageInput.closest('.relative');
                            if (previewContainer) {
                                const existingImg = previewContainer.querySelector('.profile-image-preview');
                                const avatarDiv = previewContainer.querySelector('.profile-avatar-placeholder');
                                
                                if (existingImg) {
                                    existingImg.src = event.target.result;
                                } else if (avatarDiv) {
                                    // Replace avatar div with image
                                    const newImg = document.createElement('img');
                                    newImg.src = event.target.result;
                                    newImg.alt = 'Profile';
                                    newImg.className = 'profile-image-preview h-20 w-20 sm:h-24 sm:w-24 rounded-full object-cover border-2 border-indigo-500';
                                    avatarDiv.replaceWith(newImg);
                                } else {
                                    // Create new image if neither exists
                                    const newImg = document.createElement('img');
                                    newImg.src = event.target.result;
                                    newImg.alt = 'Profile';
                                    newImg.className = 'profile-image-preview h-20 w-20 sm:h-24 sm:w-24 rounded-full object-cover border-2 border-indigo-500';
                                    const label = previewContainer.querySelector('label');
                                    if (label) {
                                        label.before(newImg);
                                    }
                                }
                            }
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }

            // Handle form submission
            const form = document.getElementById('profileForm');
            if (form) {
                form.addEventListener('submit', async (e) => {
                    e.preventDefault();
                    this.submitting = true;

                    const formData = new FormData(form);

                    try {
                        const response = await fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                                'X-Requested-With': 'XMLHttpRequest',
                            },
                            body: formData,
                        });

                        const data = await response.json();

                        if (response.ok && data.success) {
                            if (window.showNotificationToast) {
                                window.showNotificationToast('success', 'Profile Updated', data.message || 'Your profile has been updated successfully.');
                            }
                            
                            // Reload page after 1 second to reflect changes
                            setTimeout(() => {
                                window.location.reload();
                            }, 1000);
                        } else {
                            if (window.showNotificationToast) {
                                window.showNotificationToast('danger', 'Error', data.message || 'Failed to update profile. Please try again.');
                            }
                            
                            // Display validation errors if any
                            if (data.errors) {
                                Object.keys(data.errors).forEach(field => {
                                    const input = form.querySelector(`[name="${field}"]`);
                                    if (input) {
                                        input.classList.add('border-red-500');
                                        const errorMsg = document.createElement('p');
                                        errorMsg.className = 'mt-1 text-xs text-red-600 dark:text-red-400';
                                        errorMsg.textContent = data.errors[field][0];
                                        input.parentNode.appendChild(errorMsg);
                                    }
                                });
                            }
                        }
                    } catch (error) {
                        console.error('Error updating profile:', error);
                        if (window.showNotificationToast) {
                            window.showNotificationToast('danger', 'Error', 'An error occurred while updating your profile. Please try again.');
                        }
                    } finally {
                        this.submitting = false;
                    }
                });
            }
        }
    }));
});

