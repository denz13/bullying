@extends('layouts.master')

@section('content')
<div id="toast-container" class="fixed top-6 right-6 z-50 space-y-4 max-w-md"></div>

    <section class="w-full px-3 sm:px-4 md:px-6 lg:px-10 py-4 sm:py-6 md:py-8 lg:py-10 space-y-6 md:space-y-8" x-data="resolveCasesModalActions()">
        <div class="rounded-2xl md:rounded-3xl border border-gray-200/60 dark:border-gray-800 bg-white dark:bg-gray-900 p-4 sm:p-5 md:p-6 space-y-4 md:space-y-6">
            <div class="flex flex-col gap-3 sm:gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h3 class="text-base sm:text-lg font-semibold">Resolved cases</h3>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">View completed counseling requests and their resolution details</p>
                </div>
                <div class="flex items-center gap-2 w-full lg:w-auto">
                    <div class="relative flex-1 lg:max-w-xs">
                        <input
                            type="search"
                            id="resolveCasesSearch"
                            placeholder="Search resolved cases..."
                            class="w-full rounded-xl sm:rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 px-4 py-2 text-sm text-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500"
                        >
                        <svg class="absolute right-3 sm:right-4 top-2.5 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m21 21-4.35-4.35M16.5 10.5a6 6 0 1 1-12 0 6 6 0 0 1 12 0Z" />
                        </svg>
                    </div>
                    <div class="relative" x-data="{ dateFilterOpen: false }" @click.outside="dateFilterOpen = false">
                        <button
                            type="button"
                            id="dateFilterBtn"
                            class="relative inline-flex items-center justify-center h-10 w-10 rounded-xl sm:rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 transition group"
                            @click="dateFilterOpen = !dateFilterOpen"
                            title="Date Range">
                            <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                            </svg>
                            <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 text-xs font-medium text-white bg-gray-900 dark:bg-gray-700 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap z-50" id="dateFilterTooltip">
                                <span id="dateFilterText">Date Range</span>
                            </span>
                        </button>
                        <div
                            x-cloak
                            x-show="dateFilterOpen"
                            x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-2"
                            class="absolute right-0 mt-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 shadow-lg z-10"
                            @click.stop>
                            <div class="p-4">
                                <input
                                    type="text"
                                    id="dateRangePicker"
                                    placeholder="Select date range..."
                                    class="hidden"
                                >
                                <div id="dateRangePickerContainer"></div>
                                <div class="mt-3 flex gap-2">
                                    <button
                                        type="button"
                                        id="clearDateFilter"
                                        class="flex-1 rounded-lg border border-gray-200 dark:border-gray-700 px-3 py-2 text-xs font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 transition"
                                    >
                                        Clear
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button
                        type="button"
                        id="printBtn"
                        onclick="handleResolveCasesPrint(event)"
                        class="relative inline-flex items-center justify-center h-10 w-10 rounded-xl sm:rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 transition group"
                        title="Print">
                        <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                        </svg>
                        <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 text-xs font-medium text-white bg-gray-900 dark:bg-gray-700 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none whitespace-nowrap z-50">
                            Print
                        </span>
                    </button>
                </div>
            </div>
            <div class="border border-gray-100 dark:border-gray-800 rounded-xl sm:rounded-2xl overflow-hidden">
                <div class="overflow-x-auto -mx-4 sm:mx-0">
                    <div class="inline-block min-w-full align-middle">
                        <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-800 text-sm" id="resolveCasesTable">
                            <thead class="bg-gray-50 dark:bg-gray-900/60 text-gray-500 dark:text-gray-400 uppercase text-xs tracking-wide">
                                <tr>
                                    <th class="px-3 sm:px-4 py-2 sm:py-3 text-left w-12 sm:w-16">No.</th>
                                    <th class="px-3 sm:px-4 py-2 sm:py-3 text-left min-w-[140px]">Student</th>
                                    <th class="px-3 sm:px-4 py-2 sm:py-3 text-left min-w-[150px] hidden md:table-cell">Preferred Support</th>
                                    <th class="px-3 sm:px-4 py-2 sm:py-3 text-left min-w-[120px] hidden lg:table-cell">Urgency</th>
                                    <th class="px-3 sm:px-4 py-2 sm:py-3 text-left min-w-[140px] hidden xl:table-cell">Completed Date</th>
                                    <th class="px-3 sm:px-4 py-2 sm:py-3 text-left min-w-[200px]">Remarks</th>
                                    <th class="px-3 sm:px-4 py-2 sm:py-3 text-right min-w-[100px]">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-800 text-gray-700 dark:text-gray-200">
                                @forelse ($requests as $request)
                                    <tr
                                        class="hover:bg-gray-50/70 dark:hover:bg-gray-800/60 transition"
                                        data-resolve-row
                                        data-date-completed="{{ \Carbon\Carbon::parse($request->updated_at)->format('Y-m-d') }}"
                                        data-search="{{ strtolower(($request->fullname ?? 'anonymous') . ' ' . ($request->grade_section ?? '') . ' ' . ($request->urgent_level ?? '') . ' ' . ($request->remarks ?? '')) }}"
                                    >
                                        <td class="px-3 sm:px-4 py-3 sm:py-4 text-xs sm:text-sm text-gray-500 dark:text-gray-400">
                                            {{ ($requests->currentPage() - 1) * $requests->perPage() + $loop->iteration }}
                                        </td>
                                        <td class="px-3 sm:px-4 py-3 sm:py-4">
                                            <p class="font-semibold text-sm sm:text-base break-words">{{ $request->fullname ?? 'Anonymous Student' }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $request->grade_section ?? '—' }}</p>
                                            @if ($request->contact_details)
                                                <p class="text-xs text-gray-400 mt-1 break-all">{{ $request->contact_details }}</p>
                                            @endif
                                            <div class="mt-2 md:hidden space-y-1">
                                                <div>
                                                    <span class="text-xs text-gray-500 dark:text-gray-400">Support: </span>
                                                    <span class="inline-flex items-center gap-1 rounded-full border border-indigo-100 dark:border-indigo-900 px-2 py-0.5 text-xs font-semibold text-indigo-700 dark:text-indigo-300">
                                                        {{ $request->support_method ? ucfirst($request->support_method) : 'No preference' }}
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="text-xs text-gray-500 dark:text-gray-400">Date: </span>
                                                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ optional($request->updated_at)->format('M d, Y') }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-3 sm:px-4 py-3 sm:py-4 hidden md:table-cell">
                                            <span class="inline-flex items-center gap-1 sm:gap-2 rounded-full border border-indigo-100 dark:border-indigo-900 px-2 sm:px-3 py-1 text-xs font-semibold text-indigo-700 dark:text-indigo-300 break-words">
                                                <i class="fa-solid fa-hands-praying hidden sm:inline"></i>
                                                <span class="line-clamp-2">{{ $request->support_method ? ucfirst($request->support_method) : 'No preference' }}</span>
                                            </span>
                                        </td>
                                        <td class="px-3 sm:px-4 py-3 sm:py-4 text-xs sm:text-sm text-gray-600 dark:text-gray-300 hidden lg:table-cell break-words">
                                            {{ $request->urgent_level }}
                                        </td>
                                        <td class="px-3 sm:px-4 py-3 sm:py-4 text-xs sm:text-sm text-gray-500 dark:text-gray-400 hidden xl:table-cell whitespace-nowrap">
                                            {{ optional($request->updated_at)->format('M d, Y • h:i A') }}
                                        </td>
                                        <td class="px-3 sm:px-4 py-3 sm:py-4 text-xs sm:text-sm leading-relaxed text-gray-600 dark:text-gray-300 break-words">
                                            {{ \Illuminate\Support\Str::words($request->remarks ?? 'No remarks provided', 15) }}
                                        </td>
                                        <td class="px-3 sm:px-4 py-3 sm:py-4">
                                            <div class="flex items-center justify-end gap-2">
                                                <button
                                                    type="button"
                                                    class="inline-flex h-9 w-9 sm:h-10 sm:w-10 items-center justify-center rounded-lg border border-blue-200 dark:border-blue-700 bg-blue-100 dark:bg-blue-500/20 text-blue-700 dark:text-blue-300 hover:bg-blue-200 dark:hover:bg-blue-500/30 transition shadow-sm"
                                                    title="View details"
                                                    x-on:click.prevent="openModal('view', @js($request))"
                                                >
                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7Z" />
                                                    </svg>
                                                </button>
                                                <button
                                                    type="button"
                                                    class="inline-flex h-9 w-9 sm:h-10 sm:w-10 items-center justify-center rounded-lg border border-indigo-200 dark:border-indigo-700 bg-indigo-100 dark:bg-indigo-500/20 text-indigo-700 dark:text-indigo-300 hover:bg-indigo-200 dark:hover:bg-indigo-500/30 transition shadow-sm"
                                                    title="Edit remarks"
                                                    x-on:click.prevent="openModal('edit', @js($request))"
                                                >
                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr id="resolveCasesEmptyState">
                                        <td colspan="7" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
                                            No resolved cases yet.
                                        </td>
                                    </tr>
                                @endforelse
                                @if ($requests->count() > 0)
                                    <tr id="resolveCasesEmptyState" class="hidden">
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
            <x-pagination :paginator="$requests" />
        </div>

        <x-modal id="view-resolve-modal" title="Resolved case details" size="lg">
            <div class="space-y-4 text-sm text-gray-600 dark:text-gray-300">
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Student</p>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white" x-text="$store.resolveModal.current?.fullname ?? 'Anonymous Student'"></p>
                        <p class="text-xs text-gray-500 dark:text-gray-400" x-text="$store.resolveModal.current?.grade_section ?? '—'"></p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Urgency level</p>
                        <p class="text-base text-indigo-600 dark:text-indigo-300" x-text="$store.resolveModal.current?.urgent_level ?? '—'"></p>
                    </div>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Preferred support</p>
                    <p class="text-base text-gray-900 dark:text-white" x-text="$store.resolveModal.current?.support_method ?? 'No preference'"></p>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Details</p>
                    <p class="mt-2 whitespace-pre-line break-words text-sm leading-relaxed text-gray-700 dark:text-gray-200 max-h-60 overflow-y-auto text-justify">
                        <span x-text="$store.resolveModal.current?.content ?? 'N/A'"></span>
                    </p>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Remarks</p>
                    <div class="mt-2 rounded-2xl bg-gray-50 dark:bg-gray-800/60 p-4 text-sm text-gray-700 dark:text-gray-200">
                        <p class="whitespace-pre-line break-words" x-text="$store.resolveModal.current?.remarks ?? 'No remarks provided'"></p>
                    </div>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Completed date</p>
                    <p class="text-base text-gray-900 dark:text-white" x-text="$store.resolveModal.current?.updated_at ? new Date($store.resolveModal.current.updated_at).toLocaleString() : '—'"></p>
                </div>
                <div class="flex justify-end">
                    <button type="button" class="inline-flex items-center rounded-full border border-gray-200 dark:border-gray-700 px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 transition" x-on:click="closeModal('view')">
                        Close
                    </button>
                </div>
            </div>
        </x-modal>

        <x-modal id="edit-resolve-modal" title="Edit Remarks" size="lg">
            <div class="space-y-4 text-sm text-gray-600 dark:text-gray-300">
                <p>
                    Edit remarks for
                    <span class="font-semibold text-gray-900 dark:text-gray-100" x-text="$store.resolveModal.current?.fullname ?? 'the student'"></span>.
                </p>
                <label class="block text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">
                    Remarks <span class="text-red-500">*</span>
                    <textarea
                        id="editRemarks"
                        class="mt-2 w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                        rows="6"
                        placeholder="Enter remarks about the resolution of this counseling request..."
                        required
                    ></textarea>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Please provide details about how the counseling was completed.</p>
                </label>
                <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 justify-end">
                    <button type="button" class="inline-flex items-center justify-center rounded-full border border-gray-200 dark:border-gray-700 px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 transition" x-on:click="closeModal('edit')">
                        Cancel
                    </button>
                    <button type="button" class="inline-flex items-center justify-center rounded-full bg-indigo-600 px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold text-white hover:bg-indigo-500 transition" x-on:click="updateRemarks()">
                        Update Remarks
                    </button>
                </div>
            </div>
        </x-modal>
    </section>
@endsection

@push('head')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        // Global print handler function
        function handleResolveCasesPrint(e) {
            if (e) {
                e.preventDefault();
                e.stopPropagation();
            }
            
            const searchInput = document.getElementById('resolveCasesSearch');
            const searchTerm = searchInput ? searchInput.value.trim() : '';
            
            // Get date range from global variables
            const dateFrom = window.resolveCasesDateFrom || '';
            const dateTo = window.resolveCasesDateTo || '';
            
            // Build query parameters
            const params = new URLSearchParams();
            if (searchTerm) {
                params.append('search', searchTerm);
            }
            if (dateFrom) {
                params.append('date_from', dateFrom);
            }
            if (dateTo) {
                params.append('date_to', dateTo);
            }
            
            // Open PDF in new window
            const url = `/resolve-cases/print?${params.toString()}`;
            window.open(url, '_blank');
        }
    </script>
    <script src="{{ asset('js/resolve-cases/resolve-cases.js') }}" defer></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('resolveModal', { current: null });
            Alpine.data('resolveCasesModalActions', () => ({
                openModal(type, request) {
                    Alpine.store('resolveModal').current = request;
                    
                    // Load remarks into textarea when opening edit modal
                    if (type === 'edit') {
                        setTimeout(() => {
                            const remarksInput = document.getElementById('editRemarks');
                            if (remarksInput) {
                                remarksInput.value = request.remarks || '';
                            }
                        }, 100);
                    }
                    
                    window.dispatchEvent(new CustomEvent('open-modal', { detail: `${type}-resolve-modal` }));
                },
                closeModal(type) {
                    window.dispatchEvent(new CustomEvent('close-modal', { detail: `${type}-resolve-modal` }));
                },
                async updateRemarks() {
                    const request = Alpine.store('resolveModal').current;
                    if (!request || !request.id) {
                        console.error('No request selected');
                        return;
                    }

                    const remarksInput = document.getElementById('editRemarks');
                    const remarks = remarksInput ? remarksInput.value.trim() : '';

                    if (!remarks) {
                        if (window.showNotificationToast) {
                            window.showNotificationToast('warning', 'Remarks Required', 'Please provide remarks before updating.');
                        }
                        if (remarksInput) {
                            remarksInput.focus();
                        }
                        return;
                    }

                    try {
                        const response = await fetch(`/request-counseling/${request.id}/update-remarks`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                            },
                            body: JSON.stringify({ remarks: remarks }),
                        });

                        const data = await response.json();

                        if (response.ok && data.success) {
                            // Show success toast
                            if (window.showNotificationToast) {
                                window.showNotificationToast('success', 'Remarks Updated', data.message || 'Remarks have been updated successfully.');
                            }

                            this.closeModal('edit');

                            // Reload page after 1 second to reflect changes
                            setTimeout(() => {
                                window.location.reload();
                            }, 1000);
                        } else {
                            // Show error toast
                            if (window.showNotificationToast) {
                                window.showNotificationToast('danger', 'Error', data.message || 'Failed to update remarks. Please try again.');
                            }
                        }
                    } catch (error) {
                        console.error('Error updating remarks:', error);
                        if (window.showNotificationToast) {
                            window.showNotificationToast('danger', 'Error', 'An error occurred while updating remarks. Please try again.');
                        }
                    }
                },
            }));
        });
    </script>
@endpush
