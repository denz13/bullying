document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('requestSearch');
    const rows = document.querySelectorAll('[data-request-row]');
    const emptyState = document.getElementById('requestEmptyState');
    let selectedStatus = 'pending'; // Default to pending
    let dateFrom = '';
    let dateTo = '';
    
    // Store dates globally for print function access
    window.requestCounselingDateFrom = dateFrom;
    window.requestCounselingDateTo = dateTo;
    
    // Print button handler function
    const handlePrint = function(e) {
        if (e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        const searchInputEl = document.getElementById('requestSearch');
        const searchTerm = searchInputEl ? searchInputEl.value.trim() : '';
        
        // Get current selected status from active filter button or use the variable
        const activeFilterButton = document.querySelector('.status-filter-option.bg-indigo-50, .status-filter-option.dark\\:bg-indigo-500\\/20');
        let currentStatus = selectedStatus || '';
        if (activeFilterButton) {
            const statusFromButton = activeFilterButton.getAttribute('data-status');
            if (statusFromButton !== null) {
                currentStatus = statusFromButton;
            }
        }
        
        // Build query parameters
        const params = new URLSearchParams();
        if (currentStatus) {
            params.append('status', currentStatus);
        }
        if (dateFrom) {
            params.append('date_from', dateFrom);
        }
        if (dateTo) {
            params.append('date_to', dateTo);
        }
        if (searchTerm) {
            params.append('search', searchTerm);
        }
        
        // Open PDF in new window
        const url = `/request-counseling/print?${params.toString()}`;
        window.open(url, '_blank');
    };
    
    // Attach print button handler
    const printBtn = document.getElementById('printBtn');
    if (printBtn) {
        printBtn.addEventListener('click', handlePrint);
    } else {
        // Retry after a short delay if button not found
        setTimeout(() => {
            const retryPrintBtn = document.getElementById('printBtn');
            if (retryPrintBtn) {
                retryPrintBtn.addEventListener('click', handlePrint);
            }
        }, 100);
    }

    const filterRows = () => {
        const term = searchInput ? searchInput.value.trim().toLowerCase() : '';
        let visibleCount = 0;

        rows.forEach((row) => {
            const haystack = row.dataset.search ?? '';
            const searchMatches = !term || haystack.includes(term);
            
            // Check status filter - if selectedStatus is empty, show all (All Status)
            let statusMatches = true;
            if (selectedStatus) {
                const rowStatus = row.dataset.status?.toLowerCase() || '';
                statusMatches = rowStatus === selectedStatus.toLowerCase();
            }

            // Check date range filter
            const rowDate = row.dataset.dateCreated || '';
            let dateMatches = true;
            if (dateFrom || dateTo) {
                if (dateFrom && dateTo) {
                    dateMatches = rowDate >= dateFrom && rowDate <= dateTo;
                } else if (dateFrom) {
                    dateMatches = rowDate >= dateFrom;
                } else if (dateTo) {
                    dateMatches = rowDate <= dateTo;
                }
            }

            const matches = searchMatches && statusMatches && dateMatches;
            row.style.display = matches ? '' : 'none';
            if (matches) {
                visibleCount += 1;
            }
        });

        if (emptyState) {
            emptyState.classList.toggle('hidden', visibleCount !== 0);
        }
    };

    // Search input listener
    if (searchInput) {
        searchInput.addEventListener('input', filterRows);
    }

    // Set default filter to "Pending" on page load
    const statusFilterButtons = document.querySelectorAll('.status-filter-option');
    const pendingButton = Array.from(statusFilterButtons).find(btn => btn.dataset.status === 'pending');
    if (pendingButton) {
        // Remove active class from "All Status"
        const allStatusButton = Array.from(statusFilterButtons).find(btn => btn.dataset.status === '');
        if (allStatusButton) {
            allStatusButton.classList.remove('bg-indigo-50', 'text-indigo-700', 'dark:bg-indigo-500/20', 'dark:text-indigo-300');
            allStatusButton.classList.add('text-gray-700', 'dark:text-gray-200');
        }
        // Add active class to "Pending"
        pendingButton.classList.remove('text-gray-700', 'dark:text-gray-200');
        pendingButton.classList.add('bg-indigo-50', 'text-indigo-700', 'dark:bg-indigo-500/20', 'dark:text-indigo-300');
        
        // Update filter button text
        const filterBtn = document.getElementById('statusFilterBtn');
        if (filterBtn) {
            const filterBtnText = filterBtn.querySelector('span');
            if (filterBtnText) {
                filterBtnText.textContent = 'Pending';
            }
        }
    }

    // Apply initial filter
    filterRows();

    // Status filter buttons
    statusFilterButtons.forEach((button) => {
        button.addEventListener('click', (e) => {
            e.stopPropagation();
            
            // Remove active class from all buttons
            statusFilterButtons.forEach((btn) => {
                btn.classList.remove('bg-indigo-50', 'text-indigo-700', 'dark:bg-indigo-500/20', 'dark:text-indigo-300');
                btn.classList.add('text-gray-700', 'dark:text-gray-200');
            });

            // Add active class to clicked button
            button.classList.remove('text-gray-700', 'dark:text-gray-200');
            button.classList.add('bg-indigo-50', 'text-indigo-700', 'dark:bg-indigo-500/20', 'dark:text-indigo-300');

            // Update selected status
            selectedStatus = button.dataset.status || '';
            
            // Update filter button text
            const filterBtn = document.getElementById('statusFilterBtn');
            if (filterBtn) {
                const filterText = button.textContent.trim();
                const filterBtnText = filterBtn.querySelector('span');
                if (filterBtnText) {
                    filterBtnText.textContent = selectedStatus ? filterText : 'All Status';
                }
            }

            // Close dropdown (if using Alpine.js)
            setTimeout(() => {
                const dropdown = button.closest('[x-data]');
                if (dropdown && dropdown.__x) {
                    dropdown.__x.$data.filterOpen = false;
                }
            }, 150);

            // Apply filters
            filterRows();
        });
    });

    // Date range filter with Flatpickr
    const dateRangeInput = document.getElementById('dateRangePicker');
    const dateRangeContainer = document.getElementById('dateRangePickerContainer');
    const clearDateFilterBtn = document.getElementById('clearDateFilter');
    let flatpickrInstance = null;

    if (dateRangeInput && dateRangeContainer && typeof flatpickr !== 'undefined') {
        // Find the dropdown container
        const dropdownContainer = dateRangeInput.closest('[x-data]');
        
        flatpickrInstance = flatpickr(dateRangeInput, {
            mode: "range",
            dateFormat: "Y-m-d",
            inline: true,
            appendTo: dateRangeContainer,
            onChange: function(selectedDates, dateStr, instance) {
                if (selectedDates.length === 2) {
                    dateFrom = selectedDates[0].toISOString().split('T')[0];
                    dateTo = selectedDates[1].toISOString().split('T')[0];
                    window.requestCounselingDateFrom = dateFrom;
                    window.requestCounselingDateTo = dateTo;
                    
                    // Update filter button tooltip text
                    const dateFilterBtn = document.getElementById('dateFilterBtn');
                    if (dateFilterBtn) {
                        const dateFilterText = dateFilterBtn.querySelector('#dateFilterText');
                        if (dateFilterText) {
                            const fromDate = selectedDates[0].toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                            const toDate = selectedDates[1].toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                            dateFilterText.textContent = `${fromDate} - ${toDate}`;
                            dateFilterBtn.setAttribute('title', `${fromDate} - ${toDate}`);
                        }
                    }

                    // Close dropdown after a short delay
                    setTimeout(() => {
                        if (dropdownContainer && dropdownContainer.__x) {
                            dropdownContainer.__x.$data.dateFilterOpen = false;
                        }
                    }, 500);

                    // Apply filters
                    filterRows();
                } else if (selectedDates.length === 1) {
                    // User is still selecting, don't filter yet
                    dateFrom = selectedDates[0].toISOString().split('T')[0];
                    dateTo = '';
                    window.requestCounselingDateFrom = dateFrom;
                    window.requestCounselingDateTo = dateTo;
                } else {
                    dateFrom = '';
                    dateTo = '';
                    window.requestCounselingDateFrom = '';
                    window.requestCounselingDateTo = '';
                }
            }
        });
    }

    if (clearDateFilterBtn) {
        clearDateFilterBtn.addEventListener('click', () => {
            if (flatpickrInstance) {
                flatpickrInstance.clear();
            }
            dateFrom = '';
            dateTo = '';
            window.requestCounselingDateFrom = '';
            window.requestCounselingDateTo = '';
            
            // Reset filter button tooltip text
            const dateFilterBtn = document.getElementById('dateFilterBtn');
            if (dateFilterBtn) {
                const dateFilterText = dateFilterBtn.querySelector('#dateFilterText');
                if (dateFilterText) {
                    dateFilterText.textContent = 'Date Range';
                    dateFilterBtn.setAttribute('title', 'Date Range');
                }
            }

            // Close dropdown
            setTimeout(() => {
                const dropdown = clearDateFilterBtn?.closest('[x-data]');
                if (dropdown && dropdown.__x) {
                    dropdown.__x.$data.dateFilterOpen = false;
                }
            }, 150);

            // Apply filters
            filterRows();
        });
    }
});

// Function to show notification toast
window.showNotificationToast = function(type, title, message) {
    const toastContainer = document.getElementById('toast-container') || createToastContainer();
    
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
};

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

function createToastContainer() {
    const container = document.createElement('div');
    container.id = 'toast-container';
    container.className = 'fixed top-6 right-6 z-50 space-y-4 max-w-md';
    document.body.appendChild(container);
    return container;
}
