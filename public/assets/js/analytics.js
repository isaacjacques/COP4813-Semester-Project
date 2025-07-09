document.addEventListener('DOMContentLoaded', function() {
    const regCtx    = document.getElementById('regTrendsChart').getContext('2d');
    const activeCtx = document.getElementById('activeInactiveChart').getContext('2d');
    const pageCtx   = document.getElementById('pageUsageChart').getContext('2d');

    const regChart = new Chart(regCtx, {
        type: 'line',
        data: { labels: [], datasets: [{ label: 'New Registrations', data: [] }] },
        options: { responsive: true }
    });

    const activeChart = new Chart(activeCtx, {
        type: 'doughnut',
        data: { labels: [], datasets: [{ data: [] }] },
        options: { responsive: true }
    });

    const pageChart = new Chart(pageCtx, {
        type: 'bar',
        data: { labels: [], datasets: [{ label: 'Page Views', data: [] }] },
        options: { responsive: true }
    });

    function loadData(from, to, interval, role) {
        fetch('/admin/analytics/data', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ from, to, interval, role})
        })
        .then(res => res.json())
        .then(data => {
            // Summary
            document.getElementById('total-users').textContent   = data.totalUsers;
            document.getElementById('project-count').textContent = data.projectCount;
            document.getElementById('stage-count').textContent   = data.stageCount;

            // Registrations chart
            regChart.data.labels            = data.regTrends.labels;
            regChart.data.datasets[0].data  = data.regTrends.data;
            regChart.update();

            // Active vs Inactive
            activeChart.data.labels         = data.activeInactive.labels;
            activeChart.data.datasets[0].data = data.activeInactive.data;
            activeChart.update();

            // Page usage
            pageChart.data.labels           = data.pageUsage.labels;
            pageChart.data.datasets[0].data = data.pageUsage.data;
            pageChart.update();
        });
    }

    // Default date range (last 30 days)
    const toDate   = new Date().toISOString().slice(0,10);
    const fromDate = new Date(Date.now() - 30*24*60*60*1000).toISOString().slice(0,10);

    document.getElementById('date-range').value = `${fromDate} - ${toDate}`;

    document.getElementById('apply-filters').addEventListener('click', () => {
        const [from, to] = document.getElementById('date-range').value.split(' - ');
        const role       = document.getElementById('role-filter').value;
        loadData(from, to, 'day', role);
    });

    loadData(fromDate, toDate, 'day', '', '');
});
