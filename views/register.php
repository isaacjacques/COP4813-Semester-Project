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

  <section class="py-5" style="background-color: var(--color-secondary);">
    <div class="container d-flex justify-content-center">
      <div class="w-100" style="max-width: 400px;">
        <form action="register" method="POST">
            <div class="form-group">
                <label for="username" class="form-label fw-semibold">Username</label>
                <input type="text" name="username" required class="form-control">
            </div>
            <div class="form-group mt-2">
                <label for="email" class="form-label fw-semibold">Email</label>
                <input type="email" name="email" required class="form-control">
            </div>
            <div class="form-group mt-2">
                <label for="password" class="form-label fw-semibold">Password</label>
                <input type="password" name="password" required class="form-control">
            </div>
            <div class="d-grid mt-4">
                <button type="submit" name="register" class="btn btn-dark btn-lg rounded-pill">Register</button>
            </div>
        </form>
      </div>
    </div>
  </section>
</body>
</html>
