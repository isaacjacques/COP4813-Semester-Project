<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Panel - Project Wizard</title>
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
            <a href="#" class="list-group-item list-group-item-action active" aria-current="true">
              Dashboard
            </a>
            <a href="#" class="list-group-item list-group-item-action">Manage Users</a>
            <a href="#" class="list-group-item list-group-item-action">Project Oversight</a>
            <a href="#" class="list-group-item list-group-item-action">Settings</a>
          </div>
        </div>

        <div class="col-md-8">
          <div class="card p-4">
            <h3 class="card-title">Welcome, <?= htmlspecialchars($_SESSION['username'] ?? ['Admin']) ?>!</h3>
            <p class="card-text">Use the options on the left to manage your application.</p>
            <!-- Placeholder for future content -->


            <h5>All Users</h5>
            <table border="1" cellpadding="8" cellspacing="0">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= $user['user_id'] ?></td>
                            <td><?= htmlspecialchars($user['username']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= $user['is_admin'] ? 'Admin' : 'User' ?></td>
                            <td>
                            <a href="/admin/user/view?user_id=<?= $user['user_id'] ?>" class="btn btn-sm btn-outline-primary">View/Modify</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <p class="text-muted mt-4">More features coming soon…</p>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>
</html>
