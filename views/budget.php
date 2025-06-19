<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Project Wizard – Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

  <?php include 'navbar.php'; ?>

  <main>
    <div class="container my-5">
        <h3 class="mb-4">Project Budget</h3>
        <canvas id="projectSpendingChart"></canvas>
    </div>
    <div class="container mt-5">
      <h4>Spending by Project Stage</h4>
      <div id="stage-donuts" class="row"></div>
    </div>
  </main>
  
<script>
  const ctx = document.getElementById('projectSpendingChart').getContext('2d');
  new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: [
        'Requirement Gathering',
        'Project Proposal',
        'Design',
        'Development',
        'Integration Testing',
        'Client Handoff',
        'Remaining Budget'
      ],
      datasets: [{
        label: 'Project Spending',
        data: [10000, 20000, 30000, 50000, 20000, 10000, 30000],
        backgroundColor: [
          '#b6e6b0', // Requirement Gathering
          '#a8f0de', // Project Proposal
          '#b5d1ff', // Design
          '#e7c6fa', // Development
          '#ffddcc', // Integration Testing
          '#dcd6f7', // Client Handoff
          '#cccccc'  // Remaining Budget
        ],
        hoverOffset: 8
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'top'
        },
        title: {
          display: false
        }
      }
    }
  });

  document.addEventListener('DOMContentLoaded', function() {
  const stages = [
    { name: 'Requirement Gathering', allocated: 6500, used: 6250 },
    { name: 'Project Proposal',      allocated: 6500, used: 6250 },
    { name: 'Design',                allocated: 27777, used: 25000 },
    { name: 'Development',           allocated: 50000, used: 55000 },
    { name: 'Integration Testing',   allocated: 25000, used: 15000 },
    { name: 'Client Handoff',        allocated: 2500,  used: 1250 }
  ];

  // match these to your main chart’s segment colors (in same order)
  const stageColors = [
    '#A7F3D0',  // Requirement Gathering (light green)
    '#5EEAD4',  // Project Proposal (teal)
    '#BFDBFE',  // Design (light blue)
    '#E9D5FF',  // Development (light purple)
    '#FECACA',  // Integration Testing (light pink)
    '#DDD6FE'   // Client Handoff (light lilac)
  ];

  const container = document.getElementById('stage-donuts');

  stages.forEach((stage, idx) => {
    const rem = Math.max(stage.allocated - stage.used, 0);
    const cardCol = document.createElement('div');
    cardCol.className = 'col-sm-6 col-md-4 mb-4';
    cardCol.innerHTML = `
      <div class="card h-100 text-center p-3">
        <h5 class="card-title">${stage.name}</h5>
        <canvas id="donut-${idx}"></canvas>
        <div class="mt-2 small">
          <span class="me-3">
            <span class="badge" style="background:${stageColors[idx]};">&nbsp;</span>
            Used: ${stage.used.toLocaleString()}
          </span>
          <span>
            <span class="badge bg-secondary">&nbsp;</span>
            Rem: ${rem.toLocaleString()}
          </span>
        </div>
      </div>
    `;
    container.appendChild(cardCol);

    const ctx = document.getElementById(`donut-${idx}`).getContext('2d');
    new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: ['Used', 'Remaining'],
        datasets: [{
          data: [stage.used, rem],
          backgroundColor: [
            stageColors[idx],   // same as project chart
            '#e9ecef'           // light gray for remaining
          ],
          borderWidth: 0
        }]
      },
      options: {
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
});
</script>
</body>
</html>