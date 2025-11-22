document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('incidentSearch');
    const rows = document.querySelectorAll('[data-incident-row]');
    const emptyState = document.getElementById('incidentEmptyState');
    let selectedStatus = ''; // Default to all statuses
    let dateFrom = '';
    let dateTo = '';

    const filterRows = () => {
        const term = searchInput ? searchInput.value.trim().toLowerCase() : '';
        let visibleCount = 0;

        rows.forEach((row) => {
            const haystack = row.dataset.search ?? '';
            const searchMatches = !term || haystack.includes(term);
            
            // Check status filter
            const rowStatus = row.dataset.status?.toLowerCase() || '';
            const statusMatches = !selectedStatus || rowStatus === selectedStatus.toLowerCase();

            // Check date range filter
            const rowDate = row.dataset.dateReported || '';
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

    // Status filter buttons
    const statusFilterButtons = document.querySelectorAll('.status-filter-option');
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
                const filterBtnText = filterBtn.querySelector('#statusFilterText');
                if (filterBtnText) {
                    filterBtnText.textContent = selectedStatus ? filterText : 'All Status';
                }
            }

            // Close dropdown (if using Alpine.js)
            setTimeout(() => {
                const dropdown = button.closest('[x-data]');
                if (dropdown && dropdown.__x) {
                    dropdown.__x.$data.statusFilterOpen = false;
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
                } else {
                    dateFrom = '';
                    dateTo = '';
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
                const dropdown = dateFilterBtn?.closest('[x-data]');
                if (dropdown && dropdown.__x) {
                    dropdown.__x.$data.dateFilterOpen = false;
                }
            }, 150);

            // Apply filters
            filterRows();
        });
    }

    // Apply initial filter
    filterRows();

    // Print button handler
    const printBtn = document.getElementById('printBtn');
    if (printBtn) {
        printBtn.addEventListener('click', () => {
            const searchTerm = searchInput ? searchInput.value.trim() : '';
            
            // Build query parameters
            const params = new URLSearchParams();
            if (selectedStatus) {
                params.append('status', selectedStatus);
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
            const url = `/incident/print?${params.toString()}`;
            window.open(url, '_blank');
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

// Alpine.js component for incident actions
document.addEventListener('alpine:init', () => {
    Alpine.data('incidentActions', () => ({
        openAddModal() {
            window.dispatchEvent(new CustomEvent('open-modal', {
                detail: 'add-incident-modal'
            }));
        },
        closeModal() {
            window.dispatchEvent(new CustomEvent('close-modal', {
                detail: 'add-incident-modal'
            }));
        },
        async submitForm(event) {
            event.preventDefault();
            
            const form = event.target;
            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());

            try {
                const response = await fetch('/incident', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                    },
                    body: JSON.stringify(data),
                });

                const result = await response.json();

                if (response.ok && result.success) {
                    // Show success toast
                    if (window.showNotificationToast) {
                        window.showNotificationToast('success', 'Success', result.message || 'Incident added successfully.');
                    }

                    // Close modal
                    this.closeModal();

                    // Reset form
                    form.reset();

                    // Reload page after 1 second to show new incident
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    // Show error toast
                    if (window.showNotificationToast) {
                        window.showNotificationToast('danger', 'Error', result.message || 'Failed to add incident. Please try again.');
                    }
                }
            } catch (error) {
                console.error('Error adding incident:', error);
                if (window.showNotificationToast) {
                    window.showNotificationToast('danger', 'Error', 'An error occurred while adding the incident. Please try again.');
                }
            }
        }
    }));
});

// Function to open edit modal
window.openEditModal = function(id, student, incidentType, dateReported, status, priority) {
    document.getElementById('editIncidentId').value = id;
    document.getElementById('editStudent').value = student;
    document.getElementById('editIncidentType').value = incidentType;
    
    // Format date to YYYY-MM-DD for HTML date input
    let formattedDate = dateReported;
    if (dateReported) {
        // If date includes time, extract just the date part
        if (dateReported.includes(' ')) {
            formattedDate = dateReported.split(' ')[0];
        }
        // Ensure format is YYYY-MM-DD
        const dateObj = new Date(formattedDate);
        if (!isNaN(dateObj.getTime())) {
            formattedDate = dateObj.toISOString().split('T')[0];
        }
    }
    document.getElementById('editDateReported').value = formattedDate;
    
    document.getElementById('editStatus').value = status;
    document.getElementById('editPriority').value = priority;
    
    window.dispatchEvent(new CustomEvent('open-modal', {
        detail: 'edit-incident-modal'
    }));
};

// Function to open delete modal
window.openDeleteModal = function(id, student) {
    document.getElementById('deleteStudentName').textContent = student;
    const deleteBtn = document.getElementById('confirmDeleteBtn');
    
    // Remove existing event listeners by cloning the button
    const newDeleteBtn = deleteBtn.cloneNode(true);
    deleteBtn.parentNode.replaceChild(newDeleteBtn, deleteBtn);
    
    // Add new event listener
    newDeleteBtn.addEventListener('click', async () => {
        try {
            const response = await fetch(`/incident/${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                },
            });

            const result = await response.json();

            if (response.ok && result.success) {
                // Show success toast
                if (window.showNotificationToast) {
                    window.showNotificationToast('success', 'Success', result.message || 'Incident deleted successfully.');
                }

                // Close modal
                window.dispatchEvent(new CustomEvent('close-modal', {
                    detail: 'delete-incident-modal'
                }));

                // Reload page after 1 second to reflect changes
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                // Show error toast
                if (window.showNotificationToast) {
                    window.showNotificationToast('danger', 'Error', result.message || 'Failed to delete incident. Please try again.');
                }
            }
        } catch (error) {
            console.error('Error deleting incident:', error);
            if (window.showNotificationToast) {
                window.showNotificationToast('danger', 'Error', 'An error occurred while deleting the incident. Please try again.');
            }
        }
    });
    
    window.dispatchEvent(new CustomEvent('open-modal', {
        detail: 'delete-incident-modal'
    }));
};

// Handle edit and delete button clicks
document.addEventListener('DOMContentLoaded', () => {
    // Edit buttons
    document.querySelectorAll('.edit-incident-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const student = this.getAttribute('data-student');
            const incidentType = this.getAttribute('data-incident-type');
            const dateReported = this.getAttribute('data-date-reported');
            const status = this.getAttribute('data-status');
            const priority = this.getAttribute('data-priority');
            
            openEditModal(id, student, incidentType, dateReported, status, priority);
        });
    });

    // Delete buttons
    document.querySelectorAll('.delete-incident-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const student = this.getAttribute('data-student');
            
            openDeleteModal(id, student);
        });
    });
});

// Handle form submission
document.addEventListener('DOMContentLoaded', () => {
    // Add incident form
    const addForm = document.getElementById('addIncidentForm');
    if (addForm) {
        addForm.addEventListener('submit', async (event) => {
            event.preventDefault();
            
            const formData = new FormData(addForm);
            const data = Object.fromEntries(formData.entries());

            try {
                const response = await fetch('/incident', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                    },
                    body: JSON.stringify(data),
                });

                const result = await response.json();

                if (response.ok && result.success) {
                    // Show success toast
                    if (window.showNotificationToast) {
                        window.showNotificationToast('success', 'Success', result.message || 'Incident added successfully.');
                    }

                    // Close modal
                    window.dispatchEvent(new CustomEvent('close-modal', {
                        detail: 'add-incident-modal'
                    }));

                    // Reset form
                    addForm.reset();

                    // Reload page after 1 second to show new incident
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    // Show error toast
                    if (window.showNotificationToast) {
                        window.showNotificationToast('danger', 'Error', result.message || 'Failed to add incident. Please try again.');
                    }
                }
            } catch (error) {
                console.error('Error adding incident:', error);
                if (window.showNotificationToast) {
                    window.showNotificationToast('danger', 'Error', 'An error occurred while adding the incident. Please try again.');
                }
            }
        });
    }

    // Edit incident form
    const editForm = document.getElementById('editIncidentForm');
    if (editForm) {
        editForm.addEventListener('submit', async (event) => {
            event.preventDefault();
            
            const formData = new FormData(editForm);
            const data = Object.fromEntries(formData.entries());
            const id = data.id;

            try {
                const response = await fetch(`/incident/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                    },
                    body: JSON.stringify(data),
                });

                const result = await response.json();

                if (response.ok && result.success) {
                    // Show success toast
                    if (window.showNotificationToast) {
                        window.showNotificationToast('success', 'Success', result.message || 'Incident updated successfully.');
                    }

                    // Close modal
                    window.dispatchEvent(new CustomEvent('close-modal', {
                        detail: 'edit-incident-modal'
                    }));

                    // Reload page after 1 second to reflect changes
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    // Show error toast
                    if (window.showNotificationToast) {
                        window.showNotificationToast('danger', 'Error', result.message || 'Failed to update incident. Please try again.');
                    }
                }
            } catch (error) {
                console.error('Error updating incident:', error);
                if (window.showNotificationToast) {
                    window.showNotificationToast('danger', 'Error', 'An error occurred while updating the incident. Please try again.');
                }
            }
        });
    }
});

