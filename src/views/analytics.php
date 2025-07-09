<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Analytics Panel - Project Wizard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
  <?php include 'navbar.php'; ?>
  <section class="py-5 bg-light">
    <div class="container">
      <h2 class="text-center fw-bold mb-4">Admin Panel</h2>
      <div class="row">
        <div class="col-md-4">
          <div class="list-group">
            <a href="#" class="list-group-item list-group-item-action" aria-current="true">
              Dashboard
            </a>
            <a href="/admin/users" class="list-group-item list-group-item-action">Manage Users</a>
            <a href="/admin/project_overview" class="list-group-item list-group-item-action">Project Oversight</a>
            <a href="/admin/analytics" class="list-group-item list-group-item-action active">Analytics</a>
          </div>
        </div>

        <div class="col-md-8">
          <div class="card p-4">
            <h3 class="card-title mb-4">Analytics</h3>
            <div class="container my-4">
                <div class="card p-3 mb-4">
                    <div class="row">
                    <div class="col-md-3">
                        <label>Start Date</label>
                        <input id="start-date" type="date" class="form-control" />
                    </div>
                    <div class="col-md-3">
                        <label>End Date</label>
                        <input id="end-date" type="date" class="form-control" />
                    </div>
                    <div class="col-md-3">
                        <label>User role</label>
                        <select id="role-filter" class="form-control">
                        <option value="">All</option>
                        <option value="admin">Admin</option>
                        <option value="nonadmin">NonAdmin</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button id="apply-filters" class="btn btn-primary">Apply</button>
                    </div>
                    </div>
                </div>
            </div>

            <div class="row text-center mb-4">
                <div class="col-sm-3">
                <div class="card p-3"><h5>Total Users</h5><h2 id="total-users"><?= $totalUsers ?></h2></div>
                </div>
                <div class="col-sm-3">
                <div class="card p-3"><h5>Projects</h5><h2 id="project-count"><?= $projectCount ?></h2></div>
                </div>
                <div class="col-sm-3">
                <div class="card p-3"><h5>Stages</h5><h2 id="stage-count"><?= $stageCount ?></h2></div>
                </div>
                <div class="col-sm-3">
                <div class="card p-3"><h5>Invoices</h5><h2 id="invoice-count"><?= $invoiceCount ?></h2></div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                <div class="card p-3">
                    <h6>New Registrations</h6>
                    <canvas id="regTrendsChart"></canvas>
                </div>
                </div>
                <div class="col-md-6 mb-4">
                <div class="card p-3">
                    <h6>Top Pages</h6>
                    <canvas id="pageUsageChart"></canvas>
                </div>
                </div>
                <div class="col-md-6 mb-4">
                <div class="card p-3">
                    <h6>Active vs Inactive</h6>
                    <canvas id="activeInactiveChart"></canvas>
                </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="/assets/js/analytics.js"></script>
</body>
</html>