@extends('layouts.master')

@section('content')
<section class="w-full px-3 sm:px-4 md:px-6 lg:px-10 py-4 sm:py-6 md:py-8 lg:py-10">
    <div class="rounded-2xl md:rounded-3xl border border-gray-200/60 dark:border-gray-800 bg-white dark:bg-gray-900 p-4 sm:p-5 md:p-6 space-y-4 md:space-y-6 shadow-[0_20px_45px_rgba(15,23,42,0.08)]">
        <div class="flex flex-col gap-3 sm:gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h2 class="text-xl sm:text-2xl font-semibold text-gray-900 dark:text-white">Schedule Calendar</h2>
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">View approved and completed counseling requests by date.</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                    <span class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Approved</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
                    <span class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Completed</span>
                </div>
            </div>
        </div>

        <div id="calendar" class="bg-white dark:bg-gray-900 rounded-xl sm:rounded-2xl border border-gray-200 dark:border-gray-800 p-4"></div>
    </div>

    <!-- Event Details Modal -->
    <x-modal id="event-details-modal" title="Counseling Request Details" size="lg">
        <div id="eventDetailsContent" class="space-y-4 text-sm">
            <!-- Content will be populated by JavaScript -->
        </div>
        <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 justify-end pt-4">
            <button
                type="button"
                class="inline-flex items-center justify-center rounded-full border border-gray-200 dark:border-gray-700 px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 transition"
                @click="window.dispatchEvent(new CustomEvent('close-modal', { detail: 'event-details-modal' }))"
            >
                Close
            </button>
        </div>
    </x-modal>
</section>
@endsection

@push('head')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet">
    <style>
        /* FullCalendar Dark Mode Support */
        .dark .fc {
            color: #e5e7eb;
        }
        
        .dark .fc-theme-standard td,
        .dark .fc-theme-standard th {
            border-color: #374151;
        }
        
        .dark .fc-theme-standard .fc-scrollgrid {
            border-color: #374151;
        }
        
        .dark .fc-col-header-cell {
            background-color: #1f2937;
            color: #9ca3af;
        }
        
        .dark .fc-daygrid-day {
            background-color: #111827;
        }
        
        .dark .fc-daygrid-day.fc-day-today {
            background-color: #1e3a8a;
        }
        
        .dark .fc-button-primary {
            background-color: #4f46e5;
            border-color: #4f46e5;
        }
        
        .dark .fc-button-primary:hover {
            background-color: #4338ca;
            border-color: #4338ca;
        }
        
        .dark .fc-button-primary:not(:disabled):active,
        .dark .fc-button-primary:not(:disabled).fc-button-active {
            background-color: #4338ca;
            border-color: #4338ca;
        }
        
        .dark .fc-daygrid-day-number {
            color: #e5e7eb;
        }
        
        .dark .fc-toolbar-title {
            color: #f9fafb;
        }
        
        .dark .fc-button {
            color: #f9fafb;
        }
        
        .fc-event {
            cursor: pointer;
        }
        
        .fc-event:hover {
            opacity: 0.8;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
    <script src="{{ asset('js/schedule-calendar/schedule-calendar.js') }}" defer></script>
@endpush
