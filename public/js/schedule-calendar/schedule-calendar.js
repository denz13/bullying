document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    
    if (!calendarEl) {
        return;
    }

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
        height: 'auto',
        events: '/schedule-calendar/events',
        eventClick: function(info) {
            const event = info.event;
            const extendedProps = event.extendedProps;
            
            // Format the details content
            const detailsHtml = `
                <div class="space-y-3">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Student Name</label>
                            <p class="mt-1 text-sm font-semibold text-gray-900 dark:text-white">${extendedProps.fullname || 'Anonymous'}</p>
                        </div>
                        <div>
                            <label class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Grade & Section</label>
                            <p class="mt-1 text-sm text-gray-700 dark:text-gray-300">${extendedProps.grade_section || 'N/A'}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Status</label>
                            <p class="mt-1">
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold ${
                                    extendedProps.status === 'approved' 
                                        ? 'bg-blue-100 text-blue-700 dark:bg-blue-500/20 dark:text-blue-300' 
                                        : 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-300'
                                }">
                                    ${extendedProps.status.charAt(0).toUpperCase() + extendedProps.status.slice(1)}
                                </span>
                            </p>
                        </div>
                        <div>
                            <label class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Urgent Level</label>
                            <p class="mt-1 text-sm text-gray-700 dark:text-gray-300">${extendedProps.urgent_level || 'N/A'}</p>
                        </div>
                    </div>
                    ${extendedProps.contact_details ? `
                    <div>
                        <label class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Contact Details</label>
                        <p class="mt-1 text-sm text-gray-700 dark:text-gray-300">${extendedProps.contact_details}</p>
                    </div>
                    ` : ''}
                    ${extendedProps.support_method ? `
                    <div>
                        <label class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Support Method</label>
                        <p class="mt-1 text-sm text-gray-700 dark:text-gray-300">${extendedProps.support_method}</p>
                    </div>
                    ` : ''}
                    <div>
                        <label class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Content</label>
                        <div class="mt-1 max-h-40 overflow-y-auto rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 p-3">
                            <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap break-words">${extendedProps.content || 'N/A'}</p>
                        </div>
                    </div>
                    ${extendedProps.remarks ? `
                    <div>
                        <label class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Remarks</label>
                        <div class="mt-1 max-h-40 overflow-y-auto rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 p-3">
                            <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap break-words">${extendedProps.remarks}</p>
                        </div>
                    </div>
                    ` : ''}
                    <div>
                        <label class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Date</label>
                        <p class="mt-1 text-sm text-gray-700 dark:text-gray-300">${event.start.toLocaleDateString('en-US', { 
                            year: 'numeric', 
                            month: 'long', 
                            day: 'numeric' 
                        })}</p>
                    </div>
                </div>
            `;
            
            // Populate modal content
            document.getElementById('eventDetailsContent').innerHTML = detailsHtml;
            
            // Open modal
            window.dispatchEvent(new CustomEvent('open-modal', {
                detail: 'event-details-modal'
            }));
        },
        eventDisplay: 'block',
        dayMaxEvents: 3,
        moreLinkClick: 'popover',
        eventTimeFormat: {
            hour: 'numeric',
            minute: '2-digit',
            meridiem: 'short'
        },
        // Customize event rendering
        eventDidMount: function(info) {
            // Add tooltip
            info.el.setAttribute('title', `${info.event.extendedProps.fullname} - ${info.event.extendedProps.status}`);
        }
    });

    calendar.render();
});

