document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('resolveCasesSearch');
    const rows = document.querySelectorAll('[data-resolve-row]');
    const emptyState = document.getElementById('resolveCasesEmptyState');
    
    if (searchInput && rows.length > 0) {
        const filterRows = () => {
            const term = searchInput.value.trim().toLowerCase();
            let visibleCount = 0;

            rows.forEach((row) => {
                const haystack = row.dataset.search ?? '';
                const matches = haystack.includes(term);
                row.style.display = matches ? '' : 'none';
                if (matches) {
                    visibleCount += 1;
                }
            });

            if (emptyState) {
                emptyState.classList.toggle('hidden', visibleCount !== 0);
            }
        };

        searchInput.addEventListener('input', filterRows);
    }
});

