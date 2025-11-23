@extends('layouts.master')

@section('content')
    <section class="w-full px-3 sm:px-4 md:px-6 lg:px-10 py-4 sm:py-6 md:py-8 lg:py-10" x-data="sharedExperienceModalActions()">
        <div class="rounded-2xl md:rounded-3xl border border-gray-200/60 dark:border-gray-800 bg-white dark:bg-gray-900 p-4 sm:p-5 md:p-6 space-y-4 md:space-y-6 shadow-[0_20px_45px_rgba(15,23,42,0.08)]">
            <div class="flex flex-col gap-3 sm:gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h2 class="text-xl sm:text-2xl font-semibold text-gray-900 dark:text-white">Shared experiences</h2>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Stories submitted by students to inspire courage and empathy.</p>
                </div>
                <div class="flex items-center gap-2 w-full lg:w-auto">
                    <div class="relative flex-1 lg:max-w-xs">
                        <input
                            type="search"
                            id="sharedExperienceSearch"
                            placeholder="Search stories..."
                            class="w-full rounded-xl sm:rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 px-4 py-2 text-sm text-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500"
                        >
                        <svg class="absolute right-3 sm:right-4 top-2.5 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m21 21-4.35-4.35M16.5 10.5a6 6 0 1 1-12 0 6 6 0 0 1 12 0Z" />
                        </svg>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="relative" x-data="{ typeFilterOpen: false }" @click.outside="typeFilterOpen = false">
                            <button
                                type="button"
                                id="typeFilterBtn"
                                class="inline-flex items-center gap-2 rounded-xl sm:rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-3 sm:px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 transition"
                                @click="typeFilterOpen = !typeFilterOpen">
                                <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" />
                                </svg>
                                <span class="hidden sm:inline" id="typeFilterText">All Types</span>
                            </button>
                            <div
                                x-cloak
                                x-show="typeFilterOpen"
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
                                        class="type-filter-option w-full text-left px-3 py-2 text-sm rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition text-gray-700 dark:text-gray-200"
                                        data-type="">
                                        All Types
                                    </button>
                                    @foreach ($experienceTypes ?? [] as $type)
                                    <button
                                        type="button"
                                        class="type-filter-option w-full text-left px-3 py-2 text-sm rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition text-gray-700 dark:text-gray-200"
                                        data-type="{{ $type }}">
                                        {{ $type }}
                                    </button>
                                    @endforeach
                                </div>
                            </div>
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
            </div>

            <div class="border border-gray-100 dark:border-gray-800 rounded-xl sm:rounded-2xl overflow-hidden">
                <div class="overflow-x-auto -mx-4 sm:mx-0">
                    <div class="inline-block min-w-full align-middle">
                        <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-800 text-sm" id="sharedExperienceTable">
                    <thead class="bg-gray-50 dark:bg-gray-900/60 text-gray-500 dark:text-gray-400 uppercase text-xs tracking-wide">
                        <tr>
                            <th class="px-3 sm:px-4 py-2 sm:py-3 text-left min-w-[140px]">Student</th>
                            <th class="px-3 sm:px-4 py-2 sm:py-3 text-left min-w-[150px] hidden md:table-cell">Experience type</th>
                            <th class="px-3 sm:px-4 py-2 sm:py-3 text-left min-w-[200px]">What happened</th>
                            <th class="px-3 sm:px-4 py-2 sm:py-3 text-left min-w-[200px] hidden lg:table-cell">Most helpful to you</th>
                            <th class="px-3 sm:px-4 py-2 sm:py-3 text-left min-w-[100px]">Status</th>
                            <th class="px-3 sm:px-4 py-2 sm:py-3 text-right min-w-[100px]">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800 text-gray-700 dark:text-gray-200">
                    @forelse ($stories as $experience)
                            <tr
                                class="hover:bg-gray-50/70 dark:hover:bg-gray-800/60 transition"
                                data-experience-row
                                data-type="{{ strtolower($experience->type_experience ?? '') }}"
                                data-date-created="{{ \Carbon\Carbon::parse($experience->created_at)->format('Y-m-d') }}"
                                data-search="{{ strtolower(($experience->is_anonymously ? 'anonymous' : 'student') . ' ' . ($experience->type_experience ?? '') . ' ' . ($experience->content ?? '') . ' ' . ($experience->type_of_support ?? '')) }}"
                            >
                                <td class="px-3 sm:px-4 py-3 sm:py-4">
                                    <p class="font-semibold text-sm sm:text-base text-gray-900 dark:text-white break-words">{{ $experience->is_anonymously ? 'Anonymous' : 'Student' }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">—</p>
                                    <div class="mt-2 md:hidden space-y-1">
                                        <div>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">Type: </span>
                                            <span class="inline-flex items-center gap-1 rounded-full border border-indigo-100 dark:border-indigo-900 px-2 py-0.5 text-xs font-semibold text-indigo-700 dark:text-indigo-300">
                                                {{ $experience->type_experience ?? '—' }}
                                            </span>
                                        </div>
                                        <div>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">Support: </span>
                                            <span class="text-xs italic text-gray-500 dark:text-gray-400">{{ \Illuminate\Support\Str::words($experience->type_of_support ?? '—', 10) }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-3 sm:px-4 py-3 sm:py-4 hidden md:table-cell">
                                    <span class="inline-flex items-center gap-1 sm:gap-2 rounded-full border border-indigo-100 dark:border-indigo-900 px-2 sm:px-3 py-1 text-xs font-semibold text-indigo-700 dark:text-indigo-300 break-words">
                                        <i class="fa-solid fa-comments hidden sm:inline"></i>
                                        <span class="line-clamp-2">{{ $experience->type_experience ?? '—' }}</span>
                                    </span>
                                </td>
                                <td class="px-3 sm:px-4 py-3 sm:py-4 text-xs sm:text-sm leading-relaxed text-gray-600 dark:text-gray-300 break-words">
                                    {{ \Illuminate\Support\Str::words($experience->content ?? '', 20) }}
                                </td>
                                <td class="px-3 sm:px-4 py-3 sm:py-4 text-xs sm:text-sm italic text-gray-500 dark:text-gray-400 hidden lg:table-cell break-words">
                                    {{ $experience->type_of_support ?? '—' }}
                                </td>
                                <td class="px-3 sm:px-4 py-3 sm:py-4">
                                    @php
                                        $status = $experience->status ?? 'unread';
                                        $statusClass = $status === 'read' 
                                            ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300 border-emerald-200 dark:border-emerald-500/30' 
                                            : 'bg-amber-50 text-amber-700 dark:bg-amber-500/10 dark:text-amber-300 border-amber-200 dark:border-amber-500/30';
                                    @endphp
                                    <span class="inline-flex items-center gap-1 rounded-full border px-2 sm:px-3 py-1 text-xs font-semibold {{ $statusClass }}">
                                        @if($status === 'read')
                                            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        @else
                                            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        @endif
                                        <span>{{ ucfirst($status) }}</span>
                                    </span>
                                    <div class="mt-2 lg:hidden">
                                        <span class="text-xs text-gray-500 dark:text-gray-400">Status: </span>
                                        <span class="inline-flex items-center gap-1 rounded-full border px-2 py-0.5 text-xs font-semibold {{ $statusClass }}">
                                            @if($status === 'read')
                                                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            @else
                                                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            @endif
                                            <span>{{ ucfirst($status) }}</span>
                                        </span>
                                    </div>
                                </td>
                                <td class="px-3 sm:px-4 py-3 sm:py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <button
                                            type="button"
                                            class="inline-flex h-9 w-9 sm:h-10 sm:w-10 items-center justify-center rounded-lg border border-blue-200 dark:border-blue-700 bg-blue-100 dark:bg-blue-500/20 text-blue-700 dark:text-blue-300 hover:bg-blue-200 dark:hover:bg-blue-500/30 transition shadow-sm"
                                            title="View details"
                                            x-on:click.prevent="openModal('view', @js($experience))"
                                        >
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7Z" />
                                            </svg>
                                        </button>
                                        @if(($experience->status ?? 'unread') !== 'read')
                                        <button
                                            type="button"
                                            class="inline-flex h-9 w-9 sm:h-10 sm:w-10 items-center justify-center rounded-lg border border-emerald-200 dark:border-emerald-700 bg-emerald-100 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-300 hover:bg-emerald-200 dark:hover:bg-emerald-500/30 transition shadow-sm"
                                            title="Mark as read"
                                            x-on:click.prevent="markAsRead({{ $experience->id }}, $el)"
                                            data-experience-id="{{ $experience->id }}"
                                        >
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                            </svg>
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
                                No shared stories yet.
                            </td>
                        </tr>
                    @endforelse
                    @if ($stories->count() > 0)
                        <tr id="sharedExperienceEmpty" class="hidden">
                            <td colspan="6" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
                                No stories match your search.
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                    </div>
                </div>
            </div>
            @if ($stories instanceof \Illuminate\Contracts\Pagination\Paginator)
                <x-pagination :paginator="$stories" />
            @endif
        </div>

        <x-modal id="view-shared-experience-modal" title="Shared Experience Details" size="lg">
            <div class="space-y-4 text-sm text-gray-600 dark:text-gray-300">
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Student</p>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white" x-text="$store.sharedExperienceModal.current?.is_anonymously ? 'Anonymous' : 'Student'"></p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Experience Type</p>
                        <p class="text-base text-indigo-600 dark:text-indigo-300" x-text="$store.sharedExperienceModal.current?.type_experience ?? '—'"></p>
                    </div>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">What Happened</p>
                    <p class="mt-2 whitespace-pre-line break-words text-sm leading-relaxed text-gray-700 dark:text-gray-200 max-h-60 overflow-y-auto text-justify">
                        <span x-text="$store.sharedExperienceModal.current?.content ?? 'N/A'"></span>
                    </p>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Most Helpful to You</p>
                    <div class="mt-2 rounded-2xl bg-gray-50 dark:bg-gray-800/60 p-4 text-sm text-gray-700 dark:text-gray-200">
                        <p class="whitespace-pre-line break-words" x-text="$store.sharedExperienceModal.current?.type_of_support ?? 'No information provided'"></p>
                    </div>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">Submitted Date</p>
                    <p class="text-base text-gray-900 dark:text-white" x-text="$store.sharedExperienceModal.current?.created_at ? new Date($store.sharedExperienceModal.current.created_at).toLocaleString() : '—'"></p>
                </div>
                <div class="flex justify-end">
                    <button type="button" class="inline-flex items-center rounded-full border border-gray-200 dark:border-gray-700 px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 transition" x-on:click="closeModal('view')">
                        Close
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
    <script src="{{ asset('js/shared-experience/shared-experience.js') }}" defer></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('sharedExperienceModal', { current: null });
            Alpine.data('sharedExperienceModalActions', () => ({
                openModal(type, experience) {
                    Alpine.store('sharedExperienceModal').current = experience;
                    window.dispatchEvent(new CustomEvent('open-modal', { detail: `${type}-shared-experience-modal` }));
                },
                closeModal(type) {
                    window.dispatchEvent(new CustomEvent('close-modal', { detail: `${type}-shared-experience-modal` }));
                },
                markAsRead(experienceId, button) {
                    if (button.dataset.processing === 'true') {
                        return;
                    }
                    button.dataset.processing = 'true';
                    
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
                    
                    fetch(`/shared-experience/${experienceId}/mark-as-read`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Fade out and remove button
                            button.style.opacity = '0.5';
                            button.style.transition = 'opacity 0.3s';
                            setTimeout(() => {
                                button.remove();
                            }, 300);
                            
                            // Show success toast
                            if (window.showNotificationToast) {
                                window.showNotificationToast('success', 'Marked as Read', 'Experience has been marked as read.');
                            }
                        } else {
                            button.dataset.processing = 'false';
                            if (window.showNotificationToast) {
                                window.showNotificationToast('danger', 'Error', data.message || 'Failed to mark as read. Please try again.');
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error marking experience as read:', error);
                        button.dataset.processing = 'false';
                        if (window.showNotificationToast) {
                            window.showNotificationToast('danger', 'Error', 'An error occurred. Please try again.');
                        }
                    });
                },
            }));
        });

        // Global mark as read function for fallback
        window.markAsRead = function(experienceId, button) {
            if (button.dataset.processing === 'true') {
                return;
            }
            button.dataset.processing = 'true';
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            
            fetch(`/shared-experience/${experienceId}/mark-as-read`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Fade out and remove button
                    button.style.opacity = '0.5';
                    button.style.transition = 'opacity 0.3s';
                    setTimeout(() => {
                        button.remove();
                    }, 300);
                    
                    // Show success toast
                    if (window.showNotificationToast) {
                        window.showNotificationToast('success', 'Marked as Read', 'Experience has been marked as read.');
                    }
                } else {
                    button.dataset.processing = 'false';
                    if (window.showNotificationToast) {
                        window.showNotificationToast('danger', 'Error', data.message || 'Failed to mark as read. Please try again.');
                    }
                }
            })
            .catch(error => {
                console.error('Error marking experience as read:', error);
                button.dataset.processing = 'false';
                if (window.showNotificationToast) {
                    window.showNotificationToast('danger', 'Error', 'An error occurred. Please try again.');
                }
            });
        }
    </script>
@endpush
