<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit User</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css">
</head>
<body>
  <?php include 'navbar.php'; ?>
  <div class="container mt-4">
    <a href="/admin" class="btn btn-secondary mb-3">
      ← Back to Dashboard
    </a>
    <h3>Edit User</h3>

    <!-- Update Form -->
    <form method="post" action="/admin/user/update">
      <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
      
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" name="username" id="username" class="form-control" value="<?= htmlspecialchars($user['username']) ?>" required>
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
      </div>

      <div class="mb-3">
        <label for="is_admin" class="form-label">Role</label>
        <select name="is_admin" id="is_admin" class="form-select">
          <option value="0" <?= !$user['is_admin'] ? 'selected' : '' ?>>User</option>
          <option value="1" <?= $user['is_admin'] ? 'selected' : '' ?>>Admin</option>
        </select>
      </div>

      <div class="mb-3">
        <label for="is_active" class="form-label">Account Status</label>
        <select name="is_active" id="is_active" class="form-select">
          <option value="1" <?= $user['is_active'] ? 'selected' : '' ?>>Active</option>
          <option value="0" <?= !$user['is_active'] ? 'selected' : '' ?>>Inactive</option>
        </select>
      </div>

      <button type="submit" class="btn btn-primary">Update User</button>
    </form>

    <!-- Delete Form (separate so it submits with a different action) -->
    <form method="post" action="/admin/user/update" class="mt-3" onsubmit="return confirm('Are you sure you want to delete this user?');">
      <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
      <input type="hidden" name="action" value="delete">
      <button type="submit" class="btn btn-danger">Delete User</button>
    </form>
  </div>
</body>
</html>
