<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Manage Project Users</title>
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
            <a href="/admin" class="list-group-item list-group-item-action" aria-current="true">
              Dashboard
            </a>
            <a href="/admin/users" class="list-group-item list-group-item-action">Manage Users</a>
            <a href="/admin/project_overview" class="list-group-item list-group-item-action active">Project Oversight</a>
            <!-- <a href="#" class="list-group-item list-group-item-action">Settings</a> -->
          </div>
        </div>

        <div class="col-md-8">
          <div class="card p-4">
            <div class="card-body">
              <h3 class="card-title mb-4">Project Oversight</h3>

              <?php if (empty($projects)): ?>
                <p class="text-muted">No projects found.</p>
              <?php else: ?>
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Project ID</th>
                      <th>Title</th>
                      <th class="text-end">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($projects as $project): ?>
                    <tr>
                      <td><?= htmlspecialchars($project['project_id']) ?></td>
                      <td><?= htmlspecialchars($project['title']) ?></td>
                      <td class="text-end">
                        <form action="/admin/deleteProject" method="post" class="d-inline">
                          <input type="hidden" name="project_id" value="<?= (int)$project['project_id'] ?>">
                          <button
                            type="submit"
                            class="btn btn-sm btn-danger"
                            onclick="return confirm('Are you sure? Deleting this project will remove all related data.')"
                          >Delete</button>
                        </form>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                  </tbody>
                </table>
              <?php endif; ?>
            </div>
          </div>
      </div>
    </div>
  </section>
</body>
</html>