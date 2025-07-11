<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
  <?php include 'navbar.php'; ?>

  <div class="container mt-4">
    <h3 class="text-center">Project Timeline</h3>
    <div id="calendar"></div>

    <h3 class="mt-5 text-center">Project Spending</h3>
    <div class="chart-wrapper mx-auto" style="max-width:600px; height:350px;">
      <canvas id="budgetChart"></canvas>
    </div>
  </div>

  <script>
    const labels = <?php echo json_encode(array_column($stages,'name')); ?>.concat('Remaining Budget');
    const data = <?php echo json_encode($allocations); ?>.concat(<?php echo $remaining; ?>);
    const colors = <?php echo json_encode(array_column($stages,'color')); ?>.concat('#e9ecef');

    const ctx = document.getElementById('budgetChart').getContext('2d');
    new Chart(ctx, {
      type: 'doughnut',
      data: { labels, datasets:[{ data, backgroundColor: colors, borderWidth: 0 }] },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '60%',
        plugins:{ legend:{ position:'top' } }
      }
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const calendarEl = document.getElementById('calendar');
      const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        height: 500,
        events: <?= json_encode($stages) ?>
      });
      calendar.render();
    });
  </script>
</body>
</html>
