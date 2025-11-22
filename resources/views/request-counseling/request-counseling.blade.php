@extends('layouts.master')

@section('content')
<div id="toast-container" class="fixed top-6 right-6 z-50 space-y-4 max-w-md"></div>

<section class="w-full px-3 sm:px-4 md:px-6 lg:px-10 py-4 sm:py-6 md:py-8 lg:py-10 space-y-6 md:space-y-8" x-data="requestModalActions()">

    <div class="rounded-2xl md:rounded-3xl border border-gray-200/60 dark:border-gray-800 bg-white dark:bg-gray-900 p-4 sm:p-5 md:p-6 space-y-4 md:space-y-6">
        <div class="flex flex-col gap-3 sm:gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h3 class="text-base sm:text-lg font-semibold">Counseling requests</h3>
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Filter and review individual submissions</p>
            </div>
            <div class="flex items-center gap-2 w-full lg:w-auto">
                <div class="relative flex-1 lg:max-w-xs">
                    <input
                        type="search"
                        id="requestSearch"
                        placeholder="Search requests..."
                        class="w-full rounded-xl sm:rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 px-4 py-2 text-sm text-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500">
                    <svg class="absolute right-3 sm:right-4 top-2.5 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m21 21-4.35-4.35M16.5 10.5a6 6 0 1 1-12 0 6 6 0 0 1 12 0Z" />
                    </svg>
                </div>
                <div class="relative" x-data="{ filterOpen: false }" @click.outside="filterOpen = false">
                    <button
                        type="button"
                        id="statusFilterBtn"
                        class="inline-flex items-center gap-2 rounded-xl sm:rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-3 sm:px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 transition"
                        @click="filterOpen = !filterOpen">
                        <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" />
                        </svg>
                        <span class="hidden sm:inline">Pending</span>
                    </button>
                    <div
                        x-cloak
                        x-show="filterOpen"
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-2"
                        class="absolute right-0 mt-2 w-48 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 shadow-lg z-10"
                        @click.stop>
                        <div class="p-2 space-y-1">
                            <button
                                type="button"
                                class="status-filter-option w-full text-left px-3 py-2 text-sm rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition text-gray-700 dark:text-gray-200"
                                data-status="">
                                All Status
                            </button>
                            @foreach ($statuses ?? [] as $status)
                            <button
                                type="button"
                                class="status-filter-option w-full text-left px-3 py-2 text-sm rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition {{ strtolower($status) === 'pending' ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-500/20 dark:text-indigo-300' : 'text-gray-700 dark:text-gray-200' }}"
                                data-status="{{ strtolower($status) }}">
                                {{ $status }}
                            </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="border border-gray-100 dark:border-gray-800 rounded-xl sm:rounded-2xl overflow-hidden">
            <div class="overflow-x-auto -mx-4 sm:mx-0">
                <div class="inline-block min-w-full align-middle">
                    <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-800 text-sm" id="requestTable">
                        <thead class="bg-gray-50 dark:bg-gray-900/60 text-gray-500 dark:text-gray-400 uppercase text-xs tracking-wide">
                            <tr>
                                <th class="px-3 sm:px-4 py-2 sm:py-3 text-left w-12 sm:w-16">No.</th>
                                <th class="px-3 sm:px-4 py-2 sm:py-3 text-left min-w-[140px]">Student</th>
                                <th class="px-3 sm:px-4 py-2 sm:py-3 text-left min-w-[150px] hidden md:table-cell">Preferred Support</th>
                                <th class="px-3 sm:px-4 py-2 sm:py-3 text-left min-w-[120px] hidden lg:table-cell">Urgency</th>
                                <th class="px-3 sm:px-4 py-2 sm:py-3 text-left min-w-[100px]">Status</th>
                                <th class="px-3 sm:px-4 py-2 sm:py-3 text-left min-w-[140px] hidden xl:table-cell">Submitted</th>
                                <th class="px-3 sm:px-4 py-2 sm:py-3 text-right min-w-[140px]">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800 text-gray-700 dark:text-gray-200">
                            @forelse ($requests as $request)
                            <tr
                                class="hover:bg-gray-50/70 dark:hover:bg-gray-800/60 transition"
                                data-request-row
                                data-request-id="{{ $request->id }}"
                                data-status="{{ strtolower($request->status ?? 'pending') }}"
                                data-search="{{ strtolower(($request->fullname ?? 'anonymous') . ' ' . ($request->grade_section ?? '') . ' ' . ($request->urgent_level ?? '') . ' ' . ($request->status ?? '') . ' ' . ($request->content ?? '')) }}">
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
                                            <span class="text-xs text-gray-500 dark:text-gray-400">Urgency: </span>
                                            <span class="text-xs text-gray-600 dark:text-gray-300">{{ $request->urgent_level }}</span>
                                        </div>
                                        <div>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">Date: </span>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ optional($request->created_at)->format('M d, Y') }}</span>
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
                                <td class="px-3 sm:px-4 py-3 sm:py-4" data-status-cell>
                                    @php
                                    $statusColors = [
                                    'Pending' => 'bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-300',
                                    'In review' => 'bg-indigo-100 text-indigo-700 dark:bg-indigo-500/20 dark:text-indigo-300',
                                    'Scheduled' => 'bg-sky-100 text-sky-700 dark:bg-sky-500/20 dark:text-sky-300',
                                    'Completed' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-300',
                                    'pending' => 'bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-300',
                                    'approved' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-300',
                                    'completed' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-300',
                                    'rejected' => 'bg-rose-100 text-rose-700 dark:bg-rose-500/20 dark:text-rose-300',
                                    ];
                                    @endphp
                                    <span class="inline-flex rounded-full px-2 sm:px-3 py-1 text-xs font-semibold {{ $statusColors[$request->status] ?? 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-300' }}">
                                        {{ ucfirst($request->status ?? 'pending') }}
                                    </span>
                                </td>
                                <td class="px-3 sm:px-4 py-3 sm:py-4 text-xs sm:text-sm text-gray-500 dark:text-gray-400 hidden xl:table-cell whitespace-nowrap">
                                    {{ optional($request->created_at)->format('M d, Y • h:i A') }}
                                </td>
                                <td class="px-3 sm:px-4 py-3 sm:py-4">
                                    <div class="flex items-center justify-end gap-1 sm:gap-2 flex-wrap">
                                        <button
                                            type="button"
                                            class="inline-flex h-8 w-8 sm:h-9 sm:w-9 items-center justify-center rounded-full bg-blue-50 text-blue-600 hover:bg-blue-100 dark:bg-blue-500/10 dark:text-blue-300 transition"
                                            title="View details"
                                            x-on:click.prevent="openModal('view', @js($request))">
                                            <svg class="h-3.5 w-3.5 sm:h-4 sm:w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7Z" />
                                            </svg>
                                        </button>
                                        @if (strtolower($request->status ?? 'pending') !== 'approved' && strtolower($request->status ?? 'pending') !== 'completed')
                                            <button
                                                type="button"
                                                class="inline-flex h-8 w-8 sm:h-9 sm:w-9 items-center justify-center rounded-full bg-emerald-50 text-emerald-600 hover:bg-emerald-100 dark:bg-emerald-500/10 dark:text-emerald-300 transition"
                                                title="Approve"
                                                x-on:click.prevent="openModal('approve', @js($request))">
                                                <svg class="h-3.5 w-3.5 sm:h-4 sm:w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m5 13 4 4L19 7" />
                                                </svg>
                                            </button>
                                            <button
                                                type="button"
                                                class="inline-flex h-8 w-8 sm:h-9 sm:w-9 items-center justify-center rounded-full bg-amber-50 text-amber-600 hover:bg-amber-100 dark:bg-amber-500/10 dark:text-amber-300 transition"
                                                title="Reject"
                                                x-on:click.prevent="openModal('reject', @js($request))">
                                                <svg class="h-3.5 w-3.5 sm:h-4 sm:w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18 18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                            <button
                                                type="button"
                                                class="inline-flex h-8 w-8 sm:h-9 sm:w-9 items-center justify-center rounded-full bg-rose-50 text-rose-600 hover:bg-rose-100 dark:bg-rose-500/10 dark:text-rose-300 transition"
                                                title="Delete"
                                                x-on:click.prevent="openModal('delete', @js($request))">
                                                <svg class="h-3.5 w-3.5 sm:h-4 sm:w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 7h12m-9 4v6m6-6v6M9 7l1-2h4l1 2" />
                                                </svg>
                                            </button>
                                        @endif
                                        @if (strtolower($request->status ?? 'pending') === 'approved')
                                            <button
                                                type="button"
                                                class="inline-flex h-8 w-8 sm:h-9 sm:w-9 items-center justify-center rounded-full bg-indigo-600 text-white hover:bg-indigo-500 dark:bg-indigo-500 dark:hover:bg-indigo-400 transition"
                                                title="Mark As Completed"
                                                x-on:click.prevent="openModal('complete', @js($request))">
                                                <svg class="h-3.5 w-3.5 sm:h-4 sm:w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr id="requestEmptyState">
                                <td colspan="7" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
                                    No counseling requests yet. You're all caught up!
                                </td>
                            </tr>
                            @endforelse
                            @if ($requests->count() > 0)
                            <tr id="requestEmptyState" class="hidden">
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

    <x-modal id="view-request-modal" title="Counseling request details" size="lg">
        <div class="space-y-4 text-sm text-gray-600 dark:text-gray-300">
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Student</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white" x-text="$store.requestModal.current?.fullname ?? 'Anonymous Student'"></p>
                    <p class="text-xs text-gray-500 dark:text-gray-400" x-text="$store.requestModal.current?.grade_section ?? '—'"></p>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Urgency level</p>
                    <p class="text-base text-indigo-600 dark:text-indigo-300" x-text="$store.requestModal.current?.urgent_level ?? '—'"></p>
                </div>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Preferred support</p>
                <p class="text-base text-gray-900 dark:text-white" x-text="$store.requestModal.current?.support_method ?? 'No preference'"></p>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Details</p>
                <p class="mt-2 whitespace-pre-line break-words text-sm leading-relaxed text-gray-700 dark:text-gray-200 max-h-60 overflow-y-auto text-justify">
                    <span x-text="$store.requestModal.current?.content ?? 'N/A'"></span>
                </p>
            </div>
            <div x-show="$store.requestModal.current?.remarks" class="space-y-2">
                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Remarks</p>
                <div class="rounded-2xl bg-gray-50 dark:bg-gray-800/60 p-4 text-xs text-gray-600 dark:text-gray-300">
                    <p class="whitespace-pre-line break-words" x-text="$store.requestModal.current?.remarks ?? 'N/A'"></p>
                </div>
            </div>
            <div class="flex justify-end">
                <button type="button" class="inline-flex items-center rounded-full border border-gray-200 dark:border-gray-700 px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 transition" x-on:click="closeModal('view')">
                    Close
                </button>
            </div>
        </div>
    </x-modal>

    <x-modal id="approve-request-modal" title="Approve counseling request">
        <div class="space-y-4 text-sm text-gray-600 dark:text-gray-300">
            <p>
                Confirm approval for
                <span class="font-semibold text-gray-900 dark:text-gray-100" x-text="$store.requestModal.current?.fullname ?? 'the student'"></span>.
            </p>
            <div class="rounded-2xl bg-gray-50 dark:bg-gray-800/60 p-4 text-xs text-gray-500 dark:text-gray-400 space-y-1">
                <p class="font-semibold text-gray-700 dark:text-gray-200">Details</p>
                <p class="whitespace-pre-line break-words max-h-40 overflow-y-auto" x-text="$store.requestModal.current?.content ?? 'N/A'"></p>
            </div>
            <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 justify-end">
                <button type="button" class="inline-flex items-center justify-center rounded-full border border-gray-200 dark:border-gray-700 px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 transition" x-on:click="closeModal('approve')">
                    Cancel
                </button>
                <button type="button" class="inline-flex items-center justify-center rounded-full bg-emerald-600 px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold text-white hover:bg-emerald-500 transition" x-on:click="confirmAction('approve')">
                    Approve
                </button>
            </div>
        </div>
    </x-modal>

    <x-modal id="reject-request-modal" title="Reject counseling request" size="lg">
        <div class="space-y-4 text-sm text-gray-600 dark:text-gray-300">
            <p>
                Are you sure you want to reject the request from
                <span class="font-semibold text-gray-900 dark:text-gray-100" x-text="$store.requestModal.current?.fullname ?? 'the student'"></span>?
            </p>
            <label class="block text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">
                Provide a note (optional)
                <textarea class="mt-2 w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-3 text-sm focus:border-amber-500 focus:ring-amber-500" rows="4" placeholder="Let the student know why this was rejected"></textarea>
            </label>
            <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 justify-end">
                <button type="button" class="inline-flex items-center justify-center rounded-full border border-gray-200 dark:border-gray-700 px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 transition" x-on:click="closeModal('reject')">
                    Cancel
                </button>
                <button type="button" class="inline-flex items-center justify-center rounded-full bg-amber-600 px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold text-white hover:bg-amber-500 transition" x-on:click="confirmAction('reject')">
                    Reject request
                </button>
            </div>
        </div>
    </x-modal>

    <x-modal id="delete-request-modal" title="Delete counseling request" size="sm">
        <div class="space-y-4 text-sm text-gray-600 dark:text-gray-300">
            <p>
                This action will permanently delete the entry for
                <span class="font-semibold text-gray-900 dark:text-gray-100" x-text="$store.requestModal.current?.fullname ?? 'student'"></span>.
                Please confirm before proceeding.
            </p>
            <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 justify-end">
                <button type="button" class="inline-flex items-center justify-center rounded-full border border-gray-200 dark:border-gray-700 px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 transition" x-on:click="closeModal('delete')">
                    Cancel
                </button>
                <button type="button" class="inline-flex items-center justify-center rounded-full bg-rose-600 px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold text-white hover:bg-rose-500 transition" x-on:click="confirmAction('delete')">
                    Delete
                </button>
            </div>
        </div>
    </x-modal>

    <x-modal id="complete-request-modal" title="Mark as Completed" size="lg">
        <div class="space-y-4 text-sm text-gray-600 dark:text-gray-300">
            <p>
                Mark the request from
                <span class="font-semibold text-gray-900 dark:text-gray-100" x-text="$store.requestModal.current?.fullname ?? 'the student'"></span>
                as completed.
            </p>
            <label class="block text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">
                Remarks <span class="text-red-500">*</span>
                <textarea
                    id="completeRemarks"
                    class="mt-2 w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                    rows="4"
                    placeholder="Provide remarks about the completion of this counseling request..."
                    required
                ></textarea>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Please provide details about how the counseling was completed.</p>
            </label>
            <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 justify-end">
                <button type="button" class="inline-flex items-center justify-center rounded-full border border-gray-200 dark:border-gray-700 px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 transition" x-on:click="closeModal('complete')">
                    Cancel
                </button>
                <button type="button" class="inline-flex items-center justify-center rounded-full bg-indigo-600 px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold text-white hover:bg-indigo-500 transition" x-on:click="confirmAction('complete')">
                    Mark As Completed
                </button>
            </div>
        </div>
    </x-modal>
</section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js" defer></script>
<script src="{{ asset('js/request-counseling/request-counseling.js') }}" defer></script>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('requestModal', {
            current: null
        });
        Alpine.data('requestModalActions', () => ({
            openModal(type, request) {
                Alpine.store('requestModal').current = request;
                
                // Clear remarks field when opening complete modal
                if (type === 'complete') {
                    setTimeout(() => {
                        const remarksInput = document.getElementById('completeRemarks');
                        if (remarksInput) {
                            remarksInput.value = '';
                        }
                    }, 100);
                }
                
                window.dispatchEvent(new CustomEvent('open-modal', {
                    detail: `${type}-request-modal`
                }));
            },
            closeModal(type) {
                window.dispatchEvent(new CustomEvent('close-modal', {
                    detail: `${type}-request-modal`
                }));
            },
            async confirmAction(type) {
                const request = Alpine.store('requestModal').current;
                if (!request || !request.id) {
                    console.error('No request selected');
                    return;
                }

                if (type === 'approve') {
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
                            // Show success toast
                            if (window.showNotificationToast) {
                                window.showNotificationToast('success', 'Request Approved', data.message || 'Counseling request has been approved successfully.');
                            }

                            // Update the status in the table row
                            const row = document.querySelector(`[data-request-id="${request.id}"]`);
                            if (row) {
                                const statusCell = row.querySelector('[data-status-cell]');
                                if (statusCell) {
                                    statusCell.innerHTML = '<span class="inline-flex rounded-full px-2 sm:px-3 py-1 text-xs font-semibold bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-300">Approved</span>';
                                }

                                // Update search data attribute
                                const searchData = row.getAttribute('data-search') || '';
                                row.setAttribute('data-search', searchData.replace(/\b(pending|Pending)\b/g, 'approved'));
                            }

                            this.closeModal(type);

                            // Reload page after 1 second to reflect changes
                            setTimeout(() => {
                                window.location.reload();
                            }, 1000);
                        } else {
                            // Show error toast
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
                } else if (type === 'complete') {
                    const remarksInput = document.getElementById('completeRemarks');
                    const remarks = remarksInput ? remarksInput.value.trim() : '';

                    if (!remarks) {
                        if (window.showNotificationToast) {
                            window.showNotificationToast('warning', 'Remarks Required', 'Please provide remarks before marking as completed.');
                        }
                        if (remarksInput) {
                            remarksInput.focus();
                        }
                        return;
                    }

                    try {
                        const response = await fetch(`/request-counseling/${request.id}/complete`, {
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
                                window.showNotificationToast('success', 'Request Completed', data.message || 'Counseling request has been marked as completed successfully.');
                            }

                            this.closeModal(type);

                            // Reload page after 1 second to reflect changes
                            setTimeout(() => {
                                window.location.reload();
                            }, 1000);
                        } else {
                            // Show error toast
                            if (window.showNotificationToast) {
                                window.showNotificationToast('danger', 'Error', data.message || 'Failed to mark the request as completed. Please try again.');
                            }
                        }
                    } catch (error) {
                        console.error('Error completing request:', error);
                        if (window.showNotificationToast) {
                            window.showNotificationToast('danger', 'Error', 'An error occurred while marking the request as completed. Please try again.');
                        }
                    }
                } else {
                    console.log(`${type} confirmed`, request);
                    this.closeModal(type);
                }
            },
        }));
    });
</script>
@endpush