@extends('layouts.master')

@section('content')
<div id="toast-container" class="fixed top-6 right-6 z-50 space-y-4 max-w-md"></div>

<section class="w-full px-3 sm:px-4 md:px-6 lg:px-10 py-4 sm:py-6 md:py-8 lg:py-10 space-y-6 md:space-y-8">
    <div class="rounded-2xl md:rounded-3xl border border-gray-200/60 dark:border-gray-800 bg-white dark:bg-gray-900 p-4 sm:p-5 md:p-6 space-y-4 md:space-y-6">
        <div class="flex flex-col gap-3 sm:gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h2 class="text-xl sm:text-2xl font-semibold text-gray-900 dark:text-white">Incidents</h2>
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Manage and track reported incidents.</p>
            </div>
            <div class="flex items-center gap-2 w-full lg:w-auto">
                <div class="relative flex-1 lg:max-w-xs">
                    <input
                        type="search"
                        id="incidentSearch"
                        placeholder="Search incidents..."
                        class="w-full rounded-xl sm:rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 px-4 py-2 text-sm text-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500"
                    >
                    <svg class="absolute right-3 sm:right-4 top-2.5 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m21 21-4.35-4.35M16.5 10.5a6 6 0 1 1-12 0 6 6 0 0 1 12 0Z" />
                    </svg>
                </div>
                <div class="flex items-center gap-2">
                    <div class="relative" x-data="{ statusFilterOpen: false }" @click.outside="statusFilterOpen = false">
                        <button
                            type="button"
                            id="statusFilterBtn"
                            class="inline-flex items-center gap-2 rounded-xl sm:rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-3 sm:px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 transition"
                            @click="statusFilterOpen = !statusFilterOpen">
                            <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" />
                            </svg>
                            <span class="hidden sm:inline" id="statusFilterText">All Status</span>
                        </button>
                    <div
                        x-cloak
                        x-show="statusFilterOpen"
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
                                class="status-filter-option w-full text-left px-3 py-2 text-sm rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition text-gray-700 dark:text-gray-200"
                                data-status="{{ strtolower($status) }}">
                                {{ $status }}
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
                <button
                    type="button"
                    class="inline-flex items-center justify-center gap-2 rounded-xl sm:rounded-2xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500 transition"
                    @click="window.dispatchEvent(new CustomEvent('open-modal', { detail: 'add-incident-modal' }))"
                >
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Add Incident</span>
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
                                <th class="px-3 sm:px-4 py-2 sm:py-3 text-left min-w-[150px]">Student</th>
                                <th class="px-3 sm:px-4 py-2 sm:py-3 text-left min-w-[150px] hidden md:table-cell">Incident Type</th>
                                <th class="px-3 sm:px-4 py-2 sm:py-3 text-left min-w-[120px] hidden lg:table-cell">Date Reported</th>
                                <th class="px-3 sm:px-4 py-2 sm:py-3 text-left min-w-[100px]">Status</th>
                                <th class="px-3 sm:px-4 py-2 sm:py-3 text-left min-w-[100px] hidden sm:table-cell">Priority</th>
                                <th class="px-3 sm:px-4 py-2 sm:py-3 text-left min-w-[100px]">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800 text-gray-700 dark:text-gray-200">
                            @forelse ($incidents as $index => $incident)
                                <tr
                                    class="hover:bg-gray-50/70 dark:hover:bg-gray-800/60 transition"
                                    data-incident-row
                                    data-status="{{ strtolower($incident->status ?? '') }}"
                                    data-date-reported="{{ \Carbon\Carbon::parse($incident->date_reported)->format('Y-m-d') }}"
                                    data-search="{{ strtolower($incident->student . ' ' . ($incident->grade_section ?? '') . ' ' . ($incident->department ?? '') . ' ' . $incident->incident_type . ' ' . $incident->status . ' ' . $incident->priority) }}"
                                >
                                    <td class="px-3 sm:px-4 py-3 sm:py-4 text-sm text-gray-500 dark:text-gray-400">
                                        {{ ($incidents->currentPage() - 1) * $incidents->perPage() + $index + 1 }}
                                    </td>
                                    <td class="px-3 sm:px-4 py-3 sm:py-4">
                                        <div class="flex items-center gap-3">
                                            @if ($incident->student_image)
                                                <img src="{{ $incident->student_image }}" alt="{{ $incident->student }}" class="h-10 w-10 rounded-full object-cover border-2 border-gray-200 dark:border-gray-700">
                                            @else
                                                <div class="h-10 w-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                                    <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                    </svg>
                                                </div>
                                            @endif
                                            <div>
                                                <p class="font-semibold text-sm sm:text-base break-words text-gray-900 dark:text-white">{{ $incident->student }}</p>
                                                @if ($incident->department)
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $incident->department }}</p>
                                                @endif
                                                @if ($incident->grade_section)
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $incident->grade_section }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="mt-2 md:hidden space-y-1">
                                            <div>
                                                <span class="text-xs text-gray-500 dark:text-gray-400">Type: </span>
                                                <span class="text-xs font-semibold text-gray-700 dark:text-gray-300">{{ $incident->incident_type }}</span>
                                            </div>
                                            <div>
                                                <span class="text-xs text-gray-500 dark:text-gray-400">Date: </span>
                                                <span class="text-xs font-semibold text-gray-700 dark:text-gray-300">{{ \Carbon\Carbon::parse($incident->date_reported)->format('M d, Y') }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 sm:px-4 py-3 sm:py-4 hidden md:table-cell">
                                        <span class="text-sm font-bold text-gray-700 dark:text-gray-300 break-words">{{ $incident->incident_type }}</span>
                                    </td>
                                    <td class="px-3 sm:px-4 py-3 sm:py-4 hidden lg:table-cell text-sm font-bold text-gray-600 dark:text-gray-400">
                                        {{ \Carbon\Carbon::parse($incident->date_reported)->format('M d, Y') }}
                                    </td>
                                    <td class="px-3 sm:px-4 py-3 sm:py-4">
                                        @php
                                            $statusColors = [
                                                'pending' => 'bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-300',
                                                'investigating' => 'bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-300',
                                                'resolved' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-300',
                                                'closed' => 'bg-gray-100 text-gray-700 dark:bg-gray-500/20 dark:text-gray-300',
                                            ];
                                            $statusColor = $statusColors[strtolower($incident->status)] ?? 'bg-gray-100 text-gray-700 dark:bg-gray-500/20 dark:text-gray-300';
                                        @endphp
                                        <span class="inline-flex rounded-full px-2 sm:px-3 py-1 text-xs font-bold {{ $statusColor }}">
                                            {{ ucfirst($incident->status) }}
                                        </span>
                                    </td>
                                    <td class="px-3 sm:px-4 py-3 sm:py-4 hidden sm:table-cell">
                                        @php
                                            $priorityColors = [
                                                'low' => 'bg-gray-100 text-gray-700 dark:bg-gray-500/20 dark:text-gray-300',
                                                'medium' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-500/20 dark:text-yellow-300',
                                                'high' => 'bg-orange-100 text-orange-700 dark:bg-orange-500/20 dark:text-orange-300',
                                                'urgent' => 'bg-rose-100 text-rose-700 dark:bg-rose-500/20 dark:text-rose-300',
                                            ];
                                            $priorityColor = $priorityColors[strtolower($incident->priority)] ?? 'bg-gray-100 text-gray-700 dark:bg-gray-500/20 dark:text-gray-300';
                                        @endphp
                                        <span class="inline-flex rounded-full px-2 sm:px-3 py-1 text-xs font-bold {{ $priorityColor }}">
                                            {{ ucfirst($incident->priority) }}
                                        </span>
                                    </td>
                                    <td class="px-3 sm:px-4 py-3 sm:py-4">
                                        <div class="flex items-center gap-2">
                                            <button
                                                type="button"
                                                class="print-incident-btn inline-flex items-center justify-center h-9 w-9 sm:h-10 sm:w-10 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 transition shadow-sm"
                                                data-id="{{ $incident->id }}"
                                                title="Print"
                                            >
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                                                </svg>
                                            </button>
                                            <button
                                                type="button"
                                                class="edit-incident-btn inline-flex items-center justify-center h-9 w-9 sm:h-10 sm:w-10 rounded-lg border border-indigo-200 dark:border-indigo-700 bg-indigo-100 dark:bg-indigo-500/20 text-indigo-700 dark:text-indigo-300 hover:bg-indigo-200 dark:hover:bg-indigo-500/30 transition shadow-sm"
                                                data-id="{{ $incident->id }}"
                                                data-student="{{ $incident->student }}"
                                                data-incident-type="{{ $incident->incident_type }}"
                                                data-date-reported="{{ \Carbon\Carbon::parse($incident->date_reported)->format('Y-m-d') }}"
                                                data-grade-section="{{ $incident->grade_section ?? '' }}"
                                                data-department="{{ $incident->department ?? '' }}"
                                                data-status="{{ $incident->status }}"
                                                data-priority="{{ $incident->priority }}"
                                                data-remarks="{{ $incident->remarks ?? '' }}"
                                                data-student-image="{{ $incident->student_image ?? '' }}"
                                                title="Edit"
                                            >
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                            <button
                                                type="button"
                                                class="delete-incident-btn inline-flex items-center justify-center h-9 w-9 sm:h-10 sm:w-10 rounded-lg border border-rose-200 dark:border-rose-700 bg-rose-100 dark:bg-rose-500/20 text-rose-700 dark:text-rose-300 hover:bg-rose-200 dark:hover:bg-rose-500/30 transition shadow-sm"
                                                data-id="{{ $incident->id }}"
                                                data-student="{{ $incident->student }}"
                                                title="Delete"
                                            >
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
                                        No incidents recorded yet.
                                    </td>
                                </tr>
                            @endforelse
                            @if ($incidents->count() > 0)
                                <tr id="incidentEmptyState" class="hidden">
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
        @if ($incidents instanceof \Illuminate\Contracts\Pagination\Paginator)
            <x-pagination :paginator="$incidents" />
        @endif
    </div>

    <x-modal id="add-incident-modal" title="Add New Incident" size="lg">
        <form id="addIncidentForm" class="space-y-4" enctype="multipart/form-data">
            <div class="grid gap-4 sm:grid-cols-2">
                <label class="block text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">
                    Student Name <span class="text-red-500">*</span>
                    <input
                        type="text"
                        name="student"
                        required
                        class="mt-2 w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="Enter student name"
                    >
                </label>
                <label class="block text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">
                    Date Reported <span class="text-red-500">*</span>
                    <input
                        type="date"
                        name="date_reported"
                        required
                        value="{{ date('Y-m-d') }}"
                        class="mt-2 w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >
                </label>
            </div>
            <div class="grid gap-4 sm:grid-cols-2">
                <label class="block text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">
                    Grade & Section
                    <input
                        type="text"
                        name="grade_section"
                        class="mt-2 w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="e.g., Grade 7 - St. Scholastica"
                    >
                </label>
                <label class="block text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">
                    Department
                    <input
                        type="text"
                        name="department"
                        class="mt-2 w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="e.g., Junior High School"
                    >
                </label>
            </div>
            <label class="block text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">
                Incident Type <span class="text-red-500">*</span>
                <input
                    type="text"
                    name="incident_type"
                    required
                    class="mt-2 w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="e.g., Bullying, Harassment, etc."
                >
            </label>
            <label class="block text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">
                Student Picture
                <input
                    type="file"
                    name="student_image"
                    id="addStudentImage"
                    accept="image/*"
                    class="mt-2 w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-500/20 dark:file:text-indigo-300"
                >
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Accepted formats: JPG, PNG, GIF (Max: 5MB)</p>
                <div id="addImagePreview" class="mt-2 hidden">
                    <img id="addImagePreviewImg" src="" alt="Preview" class="h-24 w-24 object-cover rounded-lg border border-gray-200 dark:border-gray-700">
                </div>
            </label>
            <div class="grid gap-4 sm:grid-cols-2">
                <label class="block text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">
                    Status <span class="text-red-500">*</span>
                    <select
                        name="status"
                        required
                        class="mt-2 w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >
                        <option value="">Select status</option>
                        <option value="pending">Pending</option>
                        <option value="investigating">Investigating</option>
                        <option value="resolved">Resolved</option>
                        <option value="closed">Closed</option>
                    </select>
                </label>
                <label class="block text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">
                    Priority <span class="text-red-500">*</span>
                    <select
                        name="priority"
                        required
                        class="mt-2 w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >
                        <option value="">Select priority</option>
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                        <option value="urgent">Urgent</option>
                    </select>
                </label>
            </div>
            <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 justify-end pt-4">
                <button
                    type="button"
                    class="inline-flex items-center justify-center rounded-full border border-gray-200 dark:border-gray-700 px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 transition"
                    @click="window.dispatchEvent(new CustomEvent('close-modal', { detail: 'add-incident-modal' }))"
                >
                    Cancel
                </button>
                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-full bg-indigo-600 px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold text-white hover:bg-indigo-500 transition"
                >
                    Add Incident
                </button>
            </div>
        </form>
    </x-modal>

    <x-modal id="edit-incident-modal" title="Edit Incident" size="lg">
        <form id="editIncidentForm" class="space-y-4" enctype="multipart/form-data">
            <input type="hidden" id="editIncidentId" name="id">
            <div class="grid gap-4 sm:grid-cols-2">
                <label class="block text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">
                    Student Name <span class="text-red-500">*</span>
                    <input
                        type="text"
                        id="editStudent"
                        name="student"
                        required
                        class="mt-2 w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="Enter student name"
                    >
                </label>
                <label class="block text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">
                    Date Reported <span class="text-red-500">*</span>
                    <input
                        type="date"
                        id="editDateReported"
                        name="date_reported"
                        required
                        class="mt-2 w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >
                </label>
            </div>
            <div class="grid gap-4 sm:grid-cols-2">
                <label class="block text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">
                    Grade & Section
                    <input
                        type="text"
                        id="editGradeSection"
                        name="grade_section"
                        class="mt-2 w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="e.g., Grade 7 - St. Scholastica"
                    >
                </label>
                <label class="block text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">
                    Department
                    <input
                        type="text"
                        id="editDepartment"
                        name="department"
                        class="mt-2 w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="e.g., Junior High School"
                    >
                </label>
            </div>
            <label class="block text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">
                Incident Type <span class="text-red-500">*</span>
                <input
                    type="text"
                    id="editIncidentType"
                    name="incident_type"
                    required
                    class="mt-2 w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="e.g., Bullying, Harassment, etc."
                >
            </label>
            <div class="grid gap-4 sm:grid-cols-2">
                <label class="block text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">
                    Status <span class="text-red-500">*</span>
                    <select
                        id="editStatus"
                        name="status"
                        required
                        class="mt-2 w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >
                        <option value="">Select status</option>
                        <option value="pending">Pending</option>
                        <option value="investigating">Investigating</option>
                        <option value="resolved">Resolved</option>
                        <option value="closed">Closed</option>
                    </select>
                </label>
                <label class="block text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">
                    Priority <span class="text-red-500">*</span>
                    <select
                        id="editPriority"
                        name="priority"
                        required
                        class="mt-2 w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >
                        <option value="">Select priority</option>
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                        <option value="urgent">Urgent</option>
                    </select>
                </label>
            </div>
            <label class="block text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">
                Student Picture
                <input
                    type="file"
                    name="student_image"
                    id="editStudentImage"
                    accept="image/*"
                    class="mt-2 w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-500/20 dark:file:text-indigo-300"
                >
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Accepted formats: JPG, PNG, GIF (Max: 5MB)</p>
                <div id="editImagePreview" class="mt-2">
                    <img id="editImagePreviewImg" src="" alt="Current image" class="h-24 w-24 object-cover rounded-lg border border-gray-200 dark:border-gray-700 hidden">
                    <p id="editImagePreviewText" class="text-xs text-gray-500 dark:text-gray-400 hidden">No image uploaded</p>
                </div>
            </label>
            <label class="block text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">
                Remarks
                <textarea
                    id="editRemarks"
                    name="remarks"
                    rows="4"
                    class="mt-2 w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="Enter any additional remarks or notes..."
                ></textarea>
            </label>
            <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 justify-end pt-4">
                <button
                    type="button"
                    class="inline-flex items-center justify-center rounded-full border border-gray-200 dark:border-gray-700 px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 transition"
                    @click="window.dispatchEvent(new CustomEvent('close-modal', { detail: 'edit-incident-modal' }))"
                >
                    Cancel
                </button>
                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-full bg-indigo-600 px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold text-white hover:bg-indigo-500 transition"
                >
                    Update Incident
                </button>
            </div>
        </form>
    </x-modal>

    <x-modal id="delete-incident-modal" title="Delete Incident" size="sm">
        <div class="space-y-4 text-sm text-gray-600 dark:text-gray-300">
            <p>
                Are you sure you want to delete the incident for
                <span class="font-semibold text-gray-900 dark:text-gray-100" id="deleteStudentName"></span>?
                This action cannot be undone.
            </p>
            <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 justify-end pt-4">
                <button
                    type="button"
                    class="inline-flex items-center justify-center rounded-full border border-gray-200 dark:border-gray-700 px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 transition"
                    @click="window.dispatchEvent(new CustomEvent('close-modal', { detail: 'delete-incident-modal' }))"
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

@push('head')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="{{ asset('js/incident/incident.js') }}" defer></script>
@endpush
