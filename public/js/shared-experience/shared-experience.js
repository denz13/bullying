document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('sharedExperienceSearch');
    const rows = document.querySelectorAll('[data-experience-row]');

    if (!searchInput || rows.length === 0) {
        return;
    }

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

        const emptyRow = document.getElementById('sharedExperienceEmpty');
        if (emptyRow) {
            emptyRow.classList.toggle('hidden', visibleCount !== 0);
        } else if (visibleCount === 0) {
            const tbody = document.querySelector('#sharedExperienceTable tbody');
            if (tbody && !document.getElementById('sharedExperienceEmpty')) {
                const tr = document.createElement('tr');
                tr.id = 'sharedExperienceEmpty';
                tr.innerHTML = `<td colspan="4" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
                    No stories match your search.
                </td>`;
                tbody.appendChild(tr);
            }
        }
    };

    searchInput.addEventListener('input', filterRows);
});
