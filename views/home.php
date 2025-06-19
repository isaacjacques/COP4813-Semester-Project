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

  <main class="container my-5">
    <div class="container my-5">
      <h3 class="mb-4">Project Timeline</h3>
      <div id='project-timeline'></div>
    </div>

    <div class="container my-5">
      <h3 class="mb-4">Project Spending</h3>
      <canvas id="projectSpendingChart"></canvas>
    </div>
  </main>
  

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('project-timeline');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      height: 'auto',
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth'
      },
      //Place holder events for protype
      //TODO: Load from database
      events: [   
        {
          title: 'Requirement Gathering',
          start: '2025-05-01',
          end: '2025-06-01',
          color: '#b6e6b0'
        },
        {
          title: 'Project Proposal',
          start: '2025-06-01',
          end: '2025-07-01',
          color: '#a8f0de'
        },
        {
          title: 'Design',
          start: '2025-07-01',
          end: '2025-08-01',
          color: '#b5d1ff'
        },
        {
          title: 'Development',
          start: '2025-08-01',
          end: '2025-10-01',
          color: '#e7c6fa'
        },
        {
          title: 'Integration Testing',
          start: '2025-10-01',
          end: '2025-11-01',
          color: '#ffddcc'
        },
        {
          title: 'Client Handoff',
          start: '2025-11-01',
          end: '2025-12-15',
          color: '#dcd6f7'
        }
      ]
    });
    calendar.render();
  });

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