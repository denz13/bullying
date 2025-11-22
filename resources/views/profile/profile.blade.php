@extends('layouts.master')

@section('content')
<section class="w-full px-3 sm:px-4 md:px-6 lg:px-10 py-4 sm:py-6 md:py-8 lg:py-10 space-y-6 md:space-y-8">
    <div class="rounded-2xl md:rounded-3xl border border-gray-200/60 dark:border-gray-800 bg-white dark:bg-gray-900 p-4 sm:p-5 md:p-6 space-y-4 md:space-y-6">
        <div class="flex flex-col gap-3 sm:gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h2 class="text-xl sm:text-2xl font-semibold text-gray-900 dark:text-white">Profile Information</h2>
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">View and manage your account information</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Profile Card -->
            <div class="lg:col-span-1">
                <div class="rounded-xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 p-6 text-center">
                    <div class="relative inline-block mb-4">
                        @if($user->profile_image)
                            <img 
                                src="{{ asset('storage/' . $user->profile_image) }}" 
                                alt="{{ $user->name }}"
                                class="profile-image-preview h-20 w-20 sm:h-24 sm:w-24 rounded-full object-cover border-2 border-indigo-500"
                            >
                        @else
                            <div class="profile-avatar-placeholder inline-flex h-20 w-20 sm:h-24 sm:w-24 items-center justify-center rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 text-white text-2xl sm:text-3xl font-semibold">
                                {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                            </div>
                        @endif
                        <label for="profile_image_input" class="absolute bottom-0 right-0 inline-flex h-8 w-8 items-center justify-center rounded-full bg-indigo-600 text-white cursor-pointer hover:bg-indigo-500 transition shadow-lg">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 0 1 2-2h.93a2 2 0 0 0 1.664-.89l.812-1.22A2 2 0 0 1 10.07 4h3.86a2 2 0 0 1 1.664.89l.812 1.22A2 2 0 0 0 18.07 7H19a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                            <input type="file" id="profile_image_input" name="profile_image" accept="image/*" class="hidden" form="profileForm">
                        </label>
                    </div>
                    <h3 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-white mb-1">
                        {{ $user->name ?? 'User' }}
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                        {{ $user->email ?? 'No email' }}
                    </p>
                    @if($user->email_verified_at)
                        <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-300 px-3 py-1 text-xs font-semibold">
                            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Verified
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 rounded-full bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-300 px-3 py-1 text-xs font-semibold">
                            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                            Not Verified
                        </span>
                    @endif
                </div>
            </div>

            <!-- Information Details -->
            <div class="lg:col-span-2">
                <form id="profileForm" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" x-data="profileForm()">
                    @csrf
                    @method('PUT')
                    
                    <div class="rounded-xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 p-4 sm:p-6 space-y-6">
                        <div>
                            <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white mb-4">Account Details</h3>
                            <div class="space-y-4">
                                <div>
                                    <label for="name" class="block text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400 mb-2">
                                        Full Name <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        id="name"
                                        name="name"
                                        value="{{ old('name', $user->name) }}"
                                        required
                                        class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-3 text-sm text-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500"
                                        placeholder="Enter your full name"
                                    >
                                    @error('name')
                                        <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="email" class="block text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400 mb-2">
                                        Email Address <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="email"
                                        id="email"
                                        name="email"
                                        value="{{ old('email', $user->email) }}"
                                        required
                                        class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-3 text-sm text-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500"
                                        placeholder="Enter your email address"
                                    >
                                    @error('email')
                                        <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="password" class="block text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400 mb-2">
                                        New Password
                                    </label>
                                    <input
                                        type="password"
                                        id="password"
                                        name="password"
                                        class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-3 text-sm text-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500"
                                        placeholder="Leave blank to keep current password"
                                    >
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Leave blank if you don't want to change your password</p>
                                    @error('password')
                                        <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="password_confirmation" class="block text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400 mb-2">
                                        Confirm New Password
                                    </label>
                                    <input
                                        type="password"
                                        id="password_confirmation"
                                        name="password_confirmation"
                                        class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-3 text-sm text-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500"
                                        placeholder="Confirm your new password"
                                    >
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                                    <div>
                                        <label class="block text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400 mb-2">
                                            Member Since
                                        </label>
                                        <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 px-4 py-3">
                                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $user->created_at ? $user->created_at->format('M d, Y') : 'N/A' }}
                                            </p>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400 mb-2">
                                            Last Updated
                                        </label>
                                        <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 px-4 py-3">
                                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $user->updated_at ? $user->updated_at->format('M d, Y') : 'N/A' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                @if($user->email_verified_at)
                                    <div>
                                        <label class="block text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400 mb-2">
                                            Email Verified At
                                        </label>
                                        <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 px-4 py-3">
                                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $user->email_verified_at->format('M d, Y • h:i A') }}
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-3 justify-end pt-4 border-t border-gray-200 dark:border-gray-800">
                            <button
                                type="button"
                                class="inline-flex items-center justify-center rounded-full border border-gray-200 dark:border-gray-700 px-4 py-2.5 text-sm font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 transition"
                                onclick="document.getElementById('profileForm').reset();"
                            >
                                Reset
                            </button>
                            <button
                                type="submit"
                                class="inline-flex items-center justify-center rounded-full bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-indigo-500 transition"
                                :disabled="submitting"
                            >
                                <span x-show="!submitting">Update Profile</span>
                                <span x-show="submitting" class="flex items-center gap-2">
                                    <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Updating...
                                </span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@push('head')
<script>
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
</script>
@endpush
