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

  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center" href="home">
        <img src="assets/images/logo.svg" alt="Wizard" width="30" height="30" class="me-2">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
              aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="mainNav">
        <ul class="navbar-nav ms-3">
          <li class="nav-item">
            <a class="nav-link active" href="home">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="budget">Budget</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="stages">Stages</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="invoices">Invoices</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="admin">Admin</a>
          </li>
        </ul>
        <div class="ms-auto">
          <a href="logout" class="btn btn-logout">Log Out</a>
        </div>
      </div>
    </div>
  </nav>

  <main>
    <div class="container my-5">
        <h3 class="mb-4">Project Budget</h3>
        <canvas id="projectSpendingChart"></canvas>
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
</script>
</body>
</html>