
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Project Budget</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
  <?php include 'navbar.php'; ?>

  <div class="container mt-4">
    <div class="row mb-4">
      <div class="col-12">
        <h3>Project Budget</h3>
        <div class="chart-wrapper" style="height:350px;">
          <canvas id="mainChart"></canvas>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <h4>Spending by Project Stage</h4>
        <div id="stage-donuts" class="row gy-3"></div>
      </div>
    </div>
  </div>

  <script>
    // Bring PHP data into JS
    const stages         = <?php echo $stagesJson; ?>;
    const totalBudget    = <?php echo $totalBudgetJson; ?>;
    const usedTotal      = <?php echo $usedTotalJson; ?>;
    const remainingBudget= <?php echo $remainingJson; ?>;

    const labels           = stages.map(s => s.name).concat('Remaining Budget');
    const mainData         = stages.map(s => s.allocated).concat(remainingBudget);
    const backgroundColors = stages.map(s => s.color).concat('#e9ecef');

    const mainCtx = document.getElementById('mainChart').getContext('2d');
    new Chart(mainCtx, {
      type: 'doughnut',
      data: {
        labels: labels,
        datasets: [{
          data: mainData,
          backgroundColor: backgroundColors,
          borderWidth: 0
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '60%',
        plugins: {
          legend: { position: 'top' }
        }
      }
    });

    const container = document.getElementById('stage-donuts');

    stages.forEach((stage, idx) => {
      const rem = Math.max(stage.allocated - stage.used, 0);

      const col = document.createElement('div');
      col.className = 'col-sm-6 col-md-4';
      col.innerHTML = `
        <div class="card h-100 text-center p-3">
          <h5 class="card-title">${stage.name}</h5>
          <div style="height:150px;">
            <canvas id="donut-${idx}"></canvas>
          </div>
          <div class="mt-2 small">
            <span class="me-3">
              <span class="badge" style="background:${stage.color};">&nbsp;</span>
              Used: ${stage.used.toLocaleString()}
            </span>
            <span>
              <span class="badge bg-secondary">&nbsp;</span>
              Rem: ${rem.toLocaleString()}
            </span>
          </div>
        </div>
      `;

      container.appendChild(col);

      const ctx = document.getElementById(`donut-${idx}`).getContext('2d');
      new Chart(ctx, {
        type: 'doughnut',
        data: {
          labels: ['Used','Remaining'],
          datasets: [{
            data: [stage.used, rem],
            backgroundColor: [stage.color, '#e9ecef'],
            borderWidth: 0
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          cutout: '70%',
          plugins: {
            legend: { display: false },
            tooltip: {
              callbacks: {
                label: ctx => `${ctx.label}: ${ctx.parsed.toLocaleString()}`
              }
            }
          }
        }
      });
    });
  </script>
</body>
</html>