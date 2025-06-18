<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Project Wizard – Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/assets/css/style.css">
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

  <main class="container my-5">
    <section class="mb-5">
      <h2>Project Timeline</h2>
      <div id="timelineChart" class="border rounded p-4" style="height: 300px;">
        <!-- TODO: Render timeline chart here -->
      </div>
    </section>

    <section>
      <h2>Project Spending</h2>
      <div id="spendingChart" class="border rounded p-4" style="height: 300px;">
        <!-- TODO: Render spending chart here -->
      </div>
    </section>
  </main>
</body>
</html>