document.addEventListener('DOMContentLoaded', () => {
    const chartEl = document.getElementById('dashboardChart');
    const canvas = document.getElementById('incidentTimelineCanvas');

    if (!chartEl || !canvas) {
        return;
    }

    const labels = JSON.parse(chartEl.dataset.labels || '[]');
    const supportData = JSON.parse(chartEl.dataset.support || '[]');
    const sharedData = JSON.parse(chartEl.dataset.shared || '[]');
    const resolvedData = JSON.parse(chartEl.dataset.resolved || '[]');

    if (!window.Chart || labels.length === 0) {
        chartEl.innerHTML = '<p class="text-sm text-gray-500 dark:text-gray-400">No timeline data available yet.</p>';
        return;
    }

    const ctx = canvas.getContext('2d');
    const gradientSupport = ctx.createLinearGradient(0, 0, 0, 300);
    gradientSupport.addColorStop(0, 'rgba(99, 102, 241, 0.35)');
    gradientSupport.addColorStop(1, 'rgba(99, 102, 241, 0)');

    const gradientShared = ctx.createLinearGradient(0, 0, 0, 300);
    gradientShared.addColorStop(0, 'rgba(129, 140, 248, 0.3)');
    gradientShared.addColorStop(1, 'rgba(129, 140, 248, 0)');

    const gradientResolved = ctx.createLinearGradient(0, 0, 0, 300);
    gradientResolved.addColorStop(0, 'rgba(16, 185, 129, 0.35)');
    gradientResolved.addColorStop(1, 'rgba(16, 185, 129, 0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels,
            datasets: [
                {
                    label: 'Request counseling support',
                    data: supportData,
                    borderColor: '#6366f1',
                    backgroundColor: gradientSupport,
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2,
                },
                {
                    label: 'Shared experiences',
                    data: sharedData,
                    borderColor: '#818cf8',
                    backgroundColor: gradientShared,
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2,
                },
                {
                    label: 'Resolved cases',
                    data: resolvedData,
                    borderColor: '#10b981',
                    backgroundColor: gradientResolved,
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: '#6b7280',
                        usePointStyle: true,
                        pointStyle: 'circle',
                    },
                },
                tooltip: {
                    backgroundColor: '#111827',
                    titleColor: '#fff',
                    bodyColor: '#d1d5db',
                    padding: 12,
                    cornerRadius: 8,
                },
            },
            scales: {
                x: {
                    ticks: {
                        color: '#9ca3af',
                    },
                    grid: {
                        color: 'rgba(156, 163, 175, 0.1)',
                    },
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: '#9ca3af',
                        precision: 0,
                    },
                    grid: {
                        color: 'rgba(156, 163, 175, 0.1)',
                    },
                },
            },
        },
    });
});
