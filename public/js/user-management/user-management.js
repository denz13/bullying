document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    
    // Search functionality
    const userSearch = document.getElementById('userSearch');
    if (userSearch) {
        userSearch.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('[data-user-row]');
            let hasVisibleRows = false;
            
            rows.forEach(row => {
                const searchData = row.getAttribute('data-search') || '';
                if (searchData.includes(searchTerm)) {
                    row.style.display = '';
                    hasVisibleRows = true;
                } else {
                    row.style.display = 'none';
                }
            });
            
            const emptyState = document.getElementById('userEmptyState');
            if (emptyState) {
                emptyState.classList.toggle('hidden', hasVisibleRows || !searchTerm);
            }
        });
    }

    // Add User Form
    const addUserForm = document.getElementById('addUserForm');
    if (addUserForm) {
        addUserForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            
            submitBtn.disabled = true;
            submitBtn.textContent = 'Adding...';
            
            try {
                const response = await fetch('/user-management', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: formData,
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showNotificationToast('success', 'User Added', 'User added successfully!');
                    window.dispatchEvent(new CustomEvent('close-modal', { detail: 'add-user-modal' }));
                    setTimeout(() => window.location.reload(), 1000);
                } else {
                    showNotificationToast('danger', 'Add Failed', data.message || 'Failed to add user.');
                }
            } catch (error) {
                console.error('Error:', error);
                showNotificationToast('danger', 'Error', 'An error occurred while adding user.');
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            }
        });
    }

    // Edit User Buttons
    document.querySelectorAll('.edit-user-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            const email = this.getAttribute('data-email');
            const role = this.getAttribute('data-role') || 'user';
            const profileImage = this.getAttribute('data-profile-image');
            
            document.getElementById('editUserId').value = id;
            document.getElementById('editName').value = name;
            document.getElementById('editEmail').value = email;
            document.getElementById('editPassword').value = '';
            document.getElementById('editProfileImage').value = '';
            
            // Set role value - trim and ensure lowercase to match option values
            const roleValue = (role || 'user').trim().toLowerCase();
            const roleSelect = document.getElementById('editRole');
            if (roleSelect) {
                roleSelect.value = roleValue;
            }
            
            // Show current profile image
            const currentImagePreview = document.getElementById('currentProfileImagePreview');
            const currentImageText = document.getElementById('currentProfileImageText');
            
            if (profileImage) {
                // Use asset helper path for profile images
                currentImagePreview.src = `/storage/${profileImage}`;
                currentImagePreview.classList.remove('hidden');
                currentImageText.textContent = 'Current profile image:';
                // Handle image load error
                currentImagePreview.onerror = function() {
                    this.classList.add('hidden');
                    currentImageText.textContent = 'Image not found';
                };
            } else {
                currentImagePreview.classList.add('hidden');
                currentImageText.textContent = 'No profile image';
            }
            
            window.dispatchEvent(new CustomEvent('open-modal', { detail: 'edit-user-modal' }));
            
            // Set role value again after a small delay to ensure modal is fully rendered
            setTimeout(() => {
                const roleSelectAfter = document.getElementById('editRole');
                if (roleSelectAfter) {
                    roleSelectAfter.value = roleValue;
                }
            }, 100);
        });
    });

    // Edit User Form
    const editUserForm = document.getElementById('editUserForm');
    if (editUserForm) {
        editUserForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const userId = document.getElementById('editUserId').value;
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            
            submitBtn.disabled = true;
            submitBtn.textContent = 'Updating...';
            
            try {
                // Add _method for Laravel method spoofing
                formData.append('_method', 'PUT');
                
                const response = await fetch(`/user-management/${userId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: formData,
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showNotificationToast('success', 'User Updated', 'User updated successfully!');
                    window.dispatchEvent(new CustomEvent('close-modal', { detail: 'edit-user-modal' }));
                    setTimeout(() => window.location.reload(), 1000);
                } else {
                    showNotificationToast('danger', 'Update Failed', data.message || 'Failed to update user.');
                }
            } catch (error) {
                console.error('Error:', error);
                showNotificationToast('danger', 'Error', 'An error occurred while updating user.');
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            }
        });
    }

    // Delete User Buttons
    document.querySelectorAll('.delete-user-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            
            document.getElementById('deleteUserName').textContent = name;
            
            const confirmBtn = document.getElementById('confirmDeleteBtn');
            confirmBtn.onclick = async function() {
                confirmBtn.disabled = true;
                confirmBtn.textContent = 'Deleting...';
                
                try {
                    const response = await fetch(`/user-management/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Content-Type': 'application/json',
                        },
                    });
                    
                    const data = await response.json();
                    
                    if (data.success) {
                        showNotificationToast('success', 'User Deleted', 'User deleted successfully!');
                        window.dispatchEvent(new CustomEvent('close-modal', { detail: 'delete-user-modal' }));
                        setTimeout(() => window.location.reload(), 1000);
                    } else {
                        showNotificationToast('danger', 'Delete Failed', data.message || 'Failed to delete user.');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showNotificationToast('danger', 'Error', 'An error occurred while deleting user.');
                } finally {
                    confirmBtn.disabled = false;
                    confirmBtn.textContent = 'Delete';
                }
            };
            
            window.dispatchEvent(new CustomEvent('open-modal', { detail: 'delete-user-modal' }));
        });
    });

    // Status Toggle
    document.querySelectorAll('.status-toggle').forEach(toggle => {
        // Store initial state before any changes
        let previousState = toggle.checked;
        
        toggle.addEventListener('change', async function() {
            const userId = this.getAttribute('data-user-id');
            const isChecked = this.checked;
            const status = isChecked ? 'active' : 'inactive';
            const statusLabel = this.closest('label').querySelector('.status-label');
            const originalState = previousState; // Store previous state before change
            
            // Update previous state for next change
            previousState = isChecked;
            
            // Optimistically update UI
            statusLabel.textContent = status === 'active' ? 'Active' : 'Inactive';
            
            try {
                const formData = new FormData();
                formData.append('status', status);
                formData.append('_method', 'PUT');
                
                const response = await fetch(`/user-management/${userId}/status`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: formData,
                });
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const data = await response.json();
                
                if (data.success) {
                    showNotificationToast('success', 'Status Updated', `User status updated to ${status}.`);
                } else {
                    // Revert on error
                    this.checked = originalState;
                    previousState = originalState;
                    statusLabel.textContent = originalState ? 'Active' : 'Inactive';
                    showNotificationToast('danger', 'Update Failed', data.message || 'Failed to update status.');
                }
            } catch (error) {
                console.error('Error updating status:', error);
                // Revert on error
                this.checked = originalState;
                previousState = originalState;
                statusLabel.textContent = originalState ? 'Active' : 'Inactive';
                showNotificationToast('danger', 'Error', 'An error occurred while updating status.');
            }
        });
    });

    // Toast notification function using notification-toast component
    function showNotificationToast(type, title, message) {
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
                        ${title ? `<p class="text-base font-semibold">${title}</p>` : ''}
                        ${message ? `<p>${message}</p>` : ''}
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
    }
    
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
});

