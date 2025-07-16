<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page - Project Wizard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
  <section class="bg-white py-5">
    <div class="container text-center">
      <img src="assets/images/logo.svg" alt="Project Wizard Logo" class="mb-3" style="max-width: 120px;">
      <h2 class="fw-bold">Project Wizard</h2>
    </div>
  </section>

  <!--Alert after successful registration redirect-->
  <?php if (!empty($_GET['registered']) && $_GET['registered'] == '1'): ?>
    <div class="container mt-3">
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        Registration successful! Please log in.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    </div>
  <?php endif; ?>
  <!--Alert after failed login because of password mismatch-->
  <?php if (!empty($_GET['error']) && $_GET['error'] == '1'): ?>
    <div class="container mt-3">
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Login failed.</strong> Please check your username and password.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    </div>
  <?php endif; ?>
  <!--Alert after failed login because of inactive user-->
  <?php if (!empty($_GET['error']) && $_GET['error'] == '2'): ?>
    <div class="container mt-3">
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Login failed.</strong> Account inactive. Contact admin.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    </div>
  <?php endif; ?>
  <section class="py-5" style="background-color: var(--color-secondary);">
    <div class="container d-flex justify-content-center">
      <div class="w-100" style="max-width: 400px;">
        <form action="login" method="POST">
          <div class="mb-4">
            <label for="username" class="form-label fw-semibold">UserName</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required>
          </div>
          <div class="mb-4">
            <label for="password" class="form-label fw-semibold">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
          </div>
          <div class="d-flex mt-4">
            <a href="/" class="btn btn-outline-secondary btn-md rounded-pill w-25">
              ← Back
            </a>

            <button
              type="submit"
              name="login"
              class="btn btn-dark btn-md rounded-pill flex-grow-1 ms-2"
            >
              Login
            </button>
        </form>
      </div>
    </div>
  </section>
</body>
</html>