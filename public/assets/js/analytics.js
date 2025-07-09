document.addEventListener('DOMContentLoaded', function() {
    const regChart    = new Chart(document.getElementById('regTrendsChart').getContext('2d'), { type: 'line', data: { labels: [], datasets: [{ label: 'New Registrations', data: [] }] }, options: { responsive: true } });
    const activeChart = new Chart(document.getElementById('activeInactiveChart').getContext('2d'), { type: 'doughnut', data: { labels: [], datasets: [{ data: [] }] }, options: { responsive: true } });
    const pageChart   = new Chart(document.getElementById('pageUsageChart').getContext('2d'), { type: 'bar', data: { labels: [], datasets: [{ label: 'Page Views', data: [] }] }, options: { responsive: true } });

    function loadData(from, to, interval, role) {
        fetch('/admin/analytics/data', {
            method: 'POST', headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ from, to, interval, role })
        })
        .then(res => res.json()).then(data => {
            document.getElementById('total-users').textContent   = data.totalUsers;
            document.getElementById('project-count').textContent = data.projectCount;
            document.getElementById('stage-count').textContent   = data.stageCount;

            regChart.data.labels           = data.regTrends.labels;
            regChart.data.datasets[0].data = data.regTrends.data; regChart.update();
            activeChart.data.labels        = data.activeInactive.labels;
            activeChart.data.datasets[0].data = data.activeInactive.data; activeChart.update();
            pageChart.data.labels          = data.pageUsage.labels;
            pageChart.data.datasets[0].data = data.pageUsage.data; pageChart.update();
        });
    }

    const today   = new Date().toISOString().slice(0,10);
    const prior   = new Date(Date.now() - 30*24*60*60*1000).toISOString().slice(0,10);
    document.getElementById('start-date').value = prior;
    document.getElementById('end-date').value   = today;

    document.getElementById('apply-filters').addEventListener('click', () => {
        const from = document.getElementById('start-date').value;
        const to   = document.getElementById('end-date').value;
        const role = document.getElementById('role-filter').value;
        loadData(from, to, 'day', role);
    });

    loadData(prior, today, 'day', '');
});