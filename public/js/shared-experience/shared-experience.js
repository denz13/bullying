document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('sharedExperienceSearch');
    const rows = document.querySelectorAll('[data-experience-row]');
    const emptyState = document.getElementById('sharedExperienceEmpty');
    let selectedType = ''; // Default to all types
    let dateFrom = '';
    let dateTo = '';
    
    // Store dates globally for print function access
    window.sharedExperienceDateFrom = dateFrom;
    window.sharedExperienceDateTo = dateTo;

    const filterRows = () => {
        const term = searchInput ? searchInput.value.trim().toLowerCase() : '';
        let visibleCount = 0;

        rows.forEach((row) => {
            const haystack = row.dataset.search ?? '';
            const searchMatches = !term || haystack.includes(term);
            
            // Check type filter
            const rowType = row.dataset.type?.toLowerCase() || '';
            const typeMatches = !selectedType || rowType === selectedType.toLowerCase();

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

            const matches = searchMatches && typeMatches && dateMatches;
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

    // Type filter buttons
    const typeFilterButtons = document.querySelectorAll('.type-filter-option');
    typeFilterButtons.forEach((button) => {
        button.addEventListener('click', (e) => {
            e.stopPropagation();
            
            // Remove active class from all buttons
            typeFilterButtons.forEach((btn) => {
                btn.classList.remove('bg-indigo-50', 'text-indigo-700', 'dark:bg-indigo-500/20', 'dark:text-indigo-300');
                btn.classList.add('text-gray-700', 'dark:text-gray-200');
            });

            // Add active class to clicked button
            button.classList.remove('text-gray-700', 'dark:text-gray-200');
            button.classList.add('bg-indigo-50', 'text-indigo-700', 'dark:bg-indigo-500/20', 'dark:text-indigo-300');

            // Update selected type
            selectedType = button.dataset.type || '';
            
            // Update filter button text
            const filterBtn = document.getElementById('typeFilterBtn');
            if (filterBtn) {
                const filterText = button.textContent.trim();
                const filterBtnText = filterBtn.querySelector('#typeFilterText');
                if (filterBtnText) {
                    filterBtnText.textContent = selectedType ? filterText : 'All Types';
                }
            }

            // Close dropdown (if using Alpine.js)
            setTimeout(() => {
                const dropdown = button.closest('[x-data]');
                if (dropdown && dropdown.__x) {
                    dropdown.__x.$data.typeFilterOpen = false;
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
                    window.sharedExperienceDateFrom = dateFrom;
                    window.sharedExperienceDateTo = dateTo;
                    
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
                    window.sharedExperienceDateFrom = dateFrom;
                    window.sharedExperienceDateTo = dateTo;
                } else {
                    dateFrom = '';
                    dateTo = '';
                    window.sharedExperienceDateFrom = '';
                    window.sharedExperienceDateTo = '';
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
            window.sharedExperienceDateFrom = '';
            window.sharedExperienceDateTo = '';
            
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

    // Print button
    const printBtn = document.getElementById('printBtn');
    if (printBtn) {
        printBtn.addEventListener('click', () => {
            const params = new URLSearchParams();
            
            // Add search term
            if (searchInput && searchInput.value.trim()) {
                params.append('search', searchInput.value.trim());
            }
            
            // Add type filter only if a specific type is selected (not "All Types")
            if (selectedType && selectedType.trim() !== '') {
                params.append('type', selectedType);
            }
            
            // Add date range
            if (dateFrom) {
                params.append('date_from', dateFrom);
            }
            if (dateTo) {
                params.append('date_to', dateTo);
            }
            
            // Open PDF in new window
            const url = `/shared-experience/print?${params.toString()}`;
            window.open(url, '_blank');
        });
    }
});
