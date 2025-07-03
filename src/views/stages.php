<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Project Stages</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
  <?php include 'navbar.php'; ?>
  <div class="container mt-4">
    <h3>Project Stages</h3>
    <div class="row">
      <!-- Stage List -->
      <div class="col-md-4">
        <div id="stageList" class="list-group" style="max-height:400px; overflow-y:auto;">
          <?php foreach($stages as $idx => $stage): ?>
            <button type="button" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" 
                    style="background:<?= $stage['color'] ?>; border-color:#000; color:#000;" 
                    data-index="<?= $idx ?>">
              <?= htmlspecialchars($stage['name']) ?>
            </button>
          <?php endforeach; ?>
        </div>
        <button id="addStageBtn" class="btn btn-outline-primary w-100 mt-2">+</button>
      </div>

      <!-- Stage Detail Form -->
      <div class="col-md-8">
        <div class="card p-4 bg-light">
          <form id="stageForm" action="stages" method="POST">
            <div class="mb-3">
              <label for="stageName" class="form-label">Stage Name</label>
              <input type="text" id="stageName" name="name" class="form-control" required value="">
            </div>
            <div class="mb-3">
              <label for="stageBudget" class="form-label">Allocated Budget</label>
              <input type="number" id="stageBudget" name="allocated" class="form-control" required value="">
            </div>
            <div class="mb-3">
              <label for="stageDeadline" class="form-label">Deadline</label>
              <input type="date" id="stageDeadline" name="deadline" class="form-control" required value="">
            </div>
            <button type="submit" class="btn btn-primary">Save Stage</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Placeholder JS: swaps detail form on list click and handles add new
    document.addEventListener('DOMContentLoaded', () => {
      const stages = <?= json_encode($stages) ?>;
      const list   = document.getElementById('stageList');
      const form   = document.getElementById('stageForm');
      const nameIn = form.elements['name'];
      const budIn  = form.elements['allocated'];
      const dlIn   = form.elements['deadline'];

      function loadStage(idx) {
        const st = stages[idx] || {name:'',allocated:'',deadline:''};
        nameIn.value     = st.name;
        budIn.value      = st.allocated;
        dlIn.value       = st.deadline;
        // mark active button
        list.querySelectorAll('.list-group-item').forEach(btn=>btn.classList.remove('active'));
        if (idx !== null) {
          const btn = list.querySelector(`[data-index='${idx}']`);
          if (btn) btn.classList.add('active');
        }
      }

      // initial load first stage
      loadStage(0);

      // click list item
      list.addEventListener('click', e => {
        if (!e.target.matches('.list-group-item')) return;
        loadStage(e.target.dataset.index);
      });

      // add new stage
      document.getElementById('addStageBtn').addEventListener('click', () => {
        loadStage(null);
      });

      // form submit (placeholder)
      // form.addEventListener('submit', e => {
      //   e.preventDefault();
      //   alert('Save functionality coming soon');
      // });
    });
  </script>
</body>
</html>
