<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Your Projects</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
  <?php include 'navbar.php'; ?>
  <div class="container mt-4">
    <h3>Your Projects</h3>
    <div class="row">
      <div class="col-md-4">
        <div id="projectList" class="list-group" style="max-height:400px; overflow-y:auto;">
          <?php foreach($projects as $idx => $p): ?>
            <button type="button"
                    class="list-group-item list-group-item-action"
                    data-index="<?= $idx ?>"
                    data-project-id="<?= $p['project_id'] ?>">
              <?= htmlspecialchars($p['title']) ?>
            </button>
          <?php endforeach; ?>
        </div>
        <button id="addProjectBtn" class="btn btn-outline-primary w-100 mt-2">+</button>
      </div>

      <div class="col-md-8">
        <div class="card p-4 bg-light">
          <form id="projectForm" action="/projects" method="POST">
            <input type="hidden" name="project_id" id="projectId" value="">
            <div class="mb-3">
              <label for="projTitle" class="form-label">Title</label>
              <input type="text" id="projTitle" name="title" class="form-control" required>
            </div>
            <div class="mb-3">
              <label for="projDesc" class="form-label">Description</label>
              <textarea id="projDesc" name="description" class="form-control" rows="3" required></textarea>
            </div>
            <div class="mb-3">
              <label for="projBudget" class="form-label">Total Budget</label>
              <input type="number" id="projBudget" name="total_budget" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Save Project</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const projects = <?= json_encode($projects) ?>;
      const list     = document.getElementById('projectList');
      const form     = document.getElementById('projectForm');
      const projectIdInput = document.getElementById('projectId');
      const titleIn  = form.elements['title'];
      const descIn   = form.elements['description'];
      const budIn    = form.elements['total_budget'];

      function loadProject(idx) {
        if (idx === null) {
          projectIdInput.value = '';
          titleIn.value = '';
          descIn.value  = '';
          budIn.value   = '';
          list.querySelectorAll('.list-group-item').forEach(btn => btn.classList.remove('active'));
          return;
        }
        const project = projects[idx];
        projectIdInput.value = project.project_id;
        titleIn.value        = project.title;
        descIn.value         = project.description;
        budIn.value          = project.total_budget;
        list.querySelectorAll('.list-group-item').forEach(btn => btn.classList.remove('active'));
        list.querySelector(`[data-index='${idx}']`).classList.add('active');
      }

      loadProject(null);
      list.addEventListener('click', e => {
        if (e.target.matches('.list-group-item')) {
          loadProject(e.target.dataset.index);
        }
      });
      document.getElementById('addProjectBtn').addEventListener('click', () => loadProject(null));
    });
  </script>
</body>
</html>