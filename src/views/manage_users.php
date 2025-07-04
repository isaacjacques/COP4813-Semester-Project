<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Manage Project Users</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <?php include 'navbar.php'; ?>
  <section class="py-5">
    <div class="container">
      <h2 class="fw-bold mb-4">Manage Project Users</h2>

      <form method="GET" action="/admin/users" class="mb-4">
        <div class="mb-3">
          <label for="projectSelect" class="form-label">Select Project</label>
          <select id="projectSelect" name="project_id" class="form-select" onchange="this.form.submit()">
            <?php foreach ($projects as $project): ?>
              <option value="<?= $project['project_id'] ?>" <?= $project['project_id'] == $selectedProjectId ? 'selected' : '' ?>>
                <?= htmlspecialchars($project['title']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
      </form>

      <h5>Assigned Users</h5>
      <ul class="list-group mb-4">
        <?php foreach ($assignedUsers as $au): ?>
          <li class="list-group-item"><?= htmlspecialchars($au['username']) ?> (ID: <?= $au['user_id'] ?>)</li>
        <?php endforeach; ?>
      </ul>

      <h5>Add User to Project</h5>
      <form method="POST" action="/admin/assignUser">
        <input type="hidden" name="project_id" value="<?= $selectedProjectId ?>">
        <div class="mb-3">
          <label for="userSelect" class="form-label">User</label>
          <select id="userSelect" name="user_id" class="form-select">
            <?php
              $assignedIds = array_column($assignedUsers, 'user_id');
              foreach ($users as $user):
                if (in_array($user['user_id'], $assignedIds)) continue;
            ?>
              <option value="<?= $user['user_id'] ?>"><?= htmlspecialchars($user['username']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <button type="submit" class="btn btn-primary">Add User</button>
      </form>
    </div>
  </section>
</body>
</html>
