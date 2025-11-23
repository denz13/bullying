@extends('layouts.master')

@section('content')
@php
    use Illuminate\Support\Facades\Storage;
    
    // Convert profile images to base64 for all users
    $usersWithBase64Images = $users->map(function($user) {
        if ($user->profile_image) {
            $imagePath = storage_path('app/public/' . $user->profile_image);
            if (file_exists($imagePath)) {
                $imageData = file_get_contents($imagePath);
                $imageInfo = getimagesize($imagePath);
                $mimeType = $imageInfo['mime'] ?? 'image/png';
                $base64 = base64_encode($imageData);
                $user->profile_image_base64 = 'data:' . $mimeType . ';base64,' . $base64;
            }
        }
        return $user;
    });
@endphp
<div id="toast-container" class="fixed top-6 right-6 z-50 space-y-4 max-w-md"></div>

<section class="w-full px-3 sm:px-4 md:px-6 lg:px-10 py-4 sm:py-6 md:py-8 lg:py-10 space-y-6 md:space-y-8">
    <div class="rounded-2xl md:rounded-3xl border border-gray-200/60 dark:border-gray-800 bg-white dark:bg-gray-900 p-4 sm:p-5 md:p-6 space-y-4 md:space-y-6">
        <div class="flex flex-col gap-3 sm:gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h2 class="text-xl sm:text-2xl font-semibold text-gray-900 dark:text-white">User Management</h2>
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Manage system users and their access.</p>
            </div>
            <div class="flex items-center gap-2 w-full lg:w-auto">
                <div class="relative flex-1 lg:max-w-xs">
                    <input
                        type="search"
                        id="userSearch"
                        placeholder="Search users..."
                        class="w-full rounded-xl sm:rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 px-4 py-2 text-sm text-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500"
                    >
                    <svg class="absolute right-3 sm:right-4 top-2.5 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m21 21-4.35-4.35M16.5 10.5a6 6 0 1 1-12 0 6 6 0 0 1 12 0Z" />
                    </svg>
                </div>
                <button
                    type="button"
                    class="inline-flex items-center justify-center gap-2 rounded-xl sm:rounded-2xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500 transition"
                    @click="window.dispatchEvent(new CustomEvent('open-modal', { detail: 'add-user-modal' }))"
                >
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Add User</span>
                </button>
            </div>
        </div>

        <div class="border border-gray-100 dark:border-gray-800 rounded-xl sm:rounded-2xl overflow-hidden">
            <div class="overflow-x-auto -mx-4 sm:mx-0">
                <div class="inline-block min-w-full align-middle">
                    <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-800 text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-900/60 text-gray-500 dark:text-gray-400 uppercase text-xs tracking-wide">
                            <tr>
                                <th class="px-3 sm:px-4 py-2 sm:py-3 text-left min-w-[80px]">No.</th>
                                <th class="px-3 sm:px-4 py-2 sm:py-3 text-left min-w-[150px]">User</th>
                                <th class="px-3 sm:px-4 py-2 sm:py-3 text-left min-w-[200px] hidden md:table-cell">Email</th>
                                <th class="px-3 sm:px-4 py-2 sm:py-3 text-left min-w-[100px] hidden md:table-cell">Role</th>
                                <th class="px-3 sm:px-4 py-2 sm:py-3 text-left min-w-[120px] hidden lg:table-cell">Created At</th>
                                <th class="px-3 sm:px-4 py-2 sm:py-3 text-left min-w-[100px]">Status</th>
                                <th class="px-3 sm:px-4 py-2 sm:py-3 text-left min-w-[100px]">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800 text-gray-700 dark:text-gray-200">
                            @forelse ($users as $index => $user)
                                <tr
                                    class="hover:bg-gray-50/70 dark:hover:bg-gray-800/60 transition"
                                    data-user-row
                                    data-search="{{ strtolower($user->name . ' ' . $user->email) }}"
                                >
                                    <td class="px-3 sm:px-4 py-3 sm:py-4 text-sm text-gray-500 dark:text-gray-400">
                                        {{ ($users->currentPage() - 1) * $users->perPage() + $index + 1 }}
                                    </td>
                                    <td class="px-3 sm:px-4 py-3 sm:py-4">
                                        <div class="flex items-center gap-3">
                                            @php
                                                $profileImageBase64 = null;
                                                if ($user->profile_image) {
                                                    $imagePath = storage_path('app/public/' . $user->profile_image);
                                                    if (file_exists($imagePath)) {
                                                        $imageData = file_get_contents($imagePath);
                                                        $imageInfo = getimagesize($imagePath);
                                                        $mimeType = $imageInfo['mime'] ?? 'image/png';
                                                        $base64 = base64_encode($imageData);
                                                        $profileImageBase64 = 'data:' . $mimeType . ';base64,' . $base64;
                                                    }
                                                }
                                            @endphp
                                            @if($profileImageBase64)
                                                <img 
                                                    src="{{ $profileImageBase64 }}" 
                                                    alt="{{ $user->name }}"
                                                    class="h-10 w-10 rounded-full object-cover border-2 border-gray-200 dark:border-gray-700"
                                                >
                                            @else
                                                <div class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 text-white text-sm font-semibold">
                                                    {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                                                </div>
                                            @endif
                                            <div>
                                                <p class="font-semibold text-sm sm:text-base text-gray-900 dark:text-white break-words">{{ $user->name }}</p>
                                                <div class="mt-1 md:hidden">
                                                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ $user->email }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 sm:px-4 py-3 sm:py-4 hidden md:table-cell">
                                        <span class="text-sm text-gray-700 dark:text-gray-300 break-words">{{ $user->email }}</span>
                                    </td>
                                    <td class="px-3 sm:px-4 py-3 sm:py-4 hidden md:table-cell">
                                        @php
                                            $roleColors = [
                                                'admin' => 'bg-purple-100 text-purple-700 dark:bg-purple-500/20 dark:text-purple-300',
                                                'user' => 'bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-300',
                                            ];
                                            $roleColor = $roleColors[strtolower($user->role ?? 'user')] ?? 'bg-gray-100 text-gray-700 dark:bg-gray-500/20 dark:text-gray-300';
                                        @endphp
                                        <span class="inline-flex rounded-full px-2 sm:px-3 py-1 text-xs font-bold {{ $roleColor }}">
                                            {{ ucfirst($user->role ?? 'user') }}
                                        </span>
                                    </td>
                                    <td class="px-3 sm:px-4 py-3 sm:py-4 hidden lg:table-cell text-sm text-gray-600 dark:text-gray-400">
                                        {{ \Carbon\Carbon::parse($user->created_at)->format('M d, Y') }}
                                    </td>
                                    <td class="px-3 sm:px-4 py-3 sm:py-4">
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input
                                                type="checkbox"
                                                class="sr-only peer status-toggle"
                                                data-user-id="{{ $user->id }}"
                                                {{ ($user->status ?? 'active') === 'active' ? 'checked' : '' }}
                                            >
                                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 dark:peer-focus:ring-indigo-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-indigo-600"></div>
                                            <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300 status-label">
                                                {{ ($user->status ?? 'active') === 'active' ? 'Active' : 'Inactive' }}
                                            </span>
                                        </label>
                                    </td>
                                    <td class="px-3 sm:px-4 py-3 sm:py-4">
                                        <div class="flex items-center gap-2">
                                            <button
                                                type="button"
                                                class="edit-user-btn inline-flex items-center justify-center h-8 w-8 rounded-lg border border-indigo-200 dark:border-indigo-800 bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-100 dark:hover:bg-indigo-500/20 transition"
                                                data-id="{{ $user->id }}"
                                                data-name="{{ $user->name }}"
                                                data-email="{{ $user->email }}"
                                                data-role="{{ $user->role ?? 'user' }}"
                                                data-profile-image="{{ $user->profile_image }}"
                                                title="Edit"
                                            >
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                            <button
                                                type="button"
                                                class="delete-user-btn inline-flex items-center justify-center h-8 w-8 rounded-lg border border-rose-200 dark:border-rose-800 bg-rose-50 dark:bg-rose-500/10 text-rose-600 dark:text-rose-400 hover:bg-rose-100 dark:hover:bg-rose-500/20 transition"
                                                data-id="{{ $user->id }}"
                                                data-name="{{ $user->name }}"
                                                title="Delete"
                                            >
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
                                        No users found.
                                    </td>
                                </tr>
                            @endforelse
                            @if ($users->count() > 0)
                                <tr id="userEmptyState" class="hidden">
                                    <td colspan="7" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
                                        No matches for that search.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @if ($users instanceof \Illuminate\Contracts\Pagination\Paginator)
            <x-pagination :paginator="$users" />
        @endif
    </div>

    <x-modal id="add-user-modal" title="Add New User" size="lg">
        <form id="addUserForm" class="space-y-4" enctype="multipart/form-data">
            <div class="grid gap-4 sm:grid-cols-2">
                <label class="block text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">
                    Full Name <span class="text-red-500">*</span>
                    <input
                        type="text"
                        name="name"
                        required
                        class="mt-2 w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="Enter full name"
                    >
                </label>
                <label class="block text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">
                    Email Address <span class="text-red-500">*</span>
                    <input
                        type="email"
                        name="email"
                        required
                        class="mt-2 w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="Enter email address"
                    >
                </label>
            </div>
            <label class="block text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">
                Password <span class="text-red-500">*</span>
                <input
                    type="password"
                    name="password"
                    required
                    minlength="8"
                    class="mt-2 w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="Enter password (min. 8 characters)"
                >
            </label>
            <label class="block text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">
                Role <span class="text-red-500">*</span>
                <select
                    name="role"
                    required
                    class="mt-2 w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                >
                    <option value="">Select role</option>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </label>
            <label class="block text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">
                Profile Image (Optional)
                <input
                    type="file"
                    name="profile_image"
                    accept="image/jpeg,image/png,image/jpg,image/gif"
                    class="mt-2 w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                >
            </label>
            <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 justify-end pt-4">
                <button
                    type="button"
                    class="inline-flex items-center justify-center rounded-full border border-gray-200 dark:border-gray-700 px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 transition"
                    @click="window.dispatchEvent(new CustomEvent('close-modal', { detail: 'add-user-modal' }))"
                >
                    Cancel
                </button>
                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-full bg-indigo-600 px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold text-white hover:bg-indigo-500 transition"
                >
                    Add User
                </button>
            </div>
        </form>
    </x-modal>

    <x-modal id="edit-user-modal" title="Edit User" size="lg">
        <form id="editUserForm" class="space-y-4" enctype="multipart/form-data">
            <input type="hidden" id="editUserId" name="id">
            <div class="grid gap-4 sm:grid-cols-2">
                <label class="block text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">
                    Full Name <span class="text-red-500">*</span>
                    <input
                        type="text"
                        id="editName"
                        name="name"
                        required
                        class="mt-2 w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="Enter full name"
                    >
                </label>
                <label class="block text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">
                    Email Address <span class="text-red-500">*</span>
                    <input
                        type="email"
                        id="editEmail"
                        name="email"
                        required
                        class="mt-2 w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="Enter email address"
                    >
                </label>
            </div>
            <label class="block text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">
                Password (Leave blank to keep current password)
                <input
                    type="password"
                    id="editPassword"
                    name="password"
                    minlength="8"
                    class="mt-2 w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="Enter new password (min. 8 characters)"
                >
            </label>
            <label class="block text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">
                Role <span class="text-red-500">*</span>
                <select
                    id="editRole"
                    name="role"
                    required
                    class="mt-2 w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                >
                    <option value="">Select role</option>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </label>
            <label class="block text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">
                Profile Image (Optional)
                <div class="mt-2 space-y-2">
                    <div id="currentProfileImage" class="flex items-center gap-3">
                        <img id="currentProfileImagePreview" src="" alt="Current profile" class="h-16 w-16 rounded-full object-cover border-2 border-gray-200 dark:border-gray-700 hidden">
                        <span id="currentProfileImageText" class="text-sm text-gray-500 dark:text-gray-400"></span>
                    </div>
                    <input
                        type="file"
                        id="editProfileImage"
                        name="profile_image"
                        accept="image/jpeg,image/png,image/jpg,image/gif"
                        class="w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                    >
                </div>
            </label>
            <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 justify-end pt-4">
                <button
                    type="button"
                    class="inline-flex items-center justify-center rounded-full border border-gray-200 dark:border-gray-700 px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 transition"
                    @click="window.dispatchEvent(new CustomEvent('close-modal', { detail: 'edit-user-modal' }))"
                >
                    Cancel
                </button>
                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-full bg-indigo-600 px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold text-white hover:bg-indigo-500 transition"
                >
                    Update User
                </button>
            </div>
        </form>
    </x-modal>

    <x-modal id="delete-user-modal" title="Delete User" size="sm">
        <div class="space-y-4 text-sm text-gray-600 dark:text-gray-300">
            <p>
                Are you sure you want to delete the user
                <span class="font-semibold text-gray-900 dark:text-gray-100" id="deleteUserName"></span>?
                This action cannot be undone.
            </p>
            <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 justify-end pt-4">
                <button
                    type="button"
                    class="inline-flex items-center justify-center rounded-full border border-gray-200 dark:border-gray-700 px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 transition"
                    @click="window.dispatchEvent(new CustomEvent('close-modal', { detail: 'delete-user-modal' }))"
                >
                    Cancel
                </button>
                <button
                    type="button"
                    id="confirmDeleteBtn"
                    class="inline-flex items-center justify-center rounded-full bg-rose-600 px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold text-white hover:bg-rose-500 transition"
                >
                    Delete
                </button>
            </div>
        </div>
    </x-modal>
</section>
@endsection

@push('scripts')
    <script src="{{ asset('js/user-management/user-management.js') }}"></script>
    <script>
        // Fallback: If external JS fails to load, provide critical functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Wait a bit to see if external script loaded
            setTimeout(function() {
                if (typeof showNotificationToast === 'undefined') {
                    console.warn('user-management.js not loaded, using inline fallback...');
                    
                    // Critical: Add User Form Handler (inline fallback)
                    const addUserForm = document.getElementById('addUserForm');
                    if (addUserForm && !addUserForm.hasAttribute('data-handler-attached')) {
                        addUserForm.setAttribute('data-handler-attached', 'true');
                        addUserForm.addEventListener('submit', async function(e) {
                            e.preventDefault();
                            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
                            const formData = new FormData(this);
                            const submitBtn = this.querySelector('button[type="submit"]');
                            const originalText = submitBtn.textContent;
                            
                            submitBtn.disabled = true;
                            submitBtn.textContent = 'Adding...';
                            
                            try {
                                const response = await fetch('/user-management', {
                                    method: 'POST',
                                    headers: { 'X-CSRF-TOKEN': csrfToken },
                                    body: formData,
                                });
                                
                                const data = await response.json();
                                
                                if (data.success) {
                                    alert('User added successfully!');
                                    window.dispatchEvent(new CustomEvent('close-modal', { detail: 'add-user-modal' }));
                                    setTimeout(() => window.location.reload(), 1000);
                                } else {
                                    alert('Error: ' + (data.message || 'Failed to add user.'));
                                }
                            } catch (error) {
                                console.error('Error:', error);
                                alert('An error occurred while adding user.');
                            } finally {
                                submitBtn.disabled = false;
                                submitBtn.textContent = originalText;
                            }
                        });
                    }
                }
            }, 500);
        });
    </script>
@endpush
