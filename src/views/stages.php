<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Stages</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
  <?php include 'navbar.php'; ?>
  <div class="container mt-4">
    <h3>Stages</h3>
    <div class="row">
      <div class="col-md-4">
        <div id="stageList" class="list-group" style="max-height:400px; overflow-y:auto;">
          <?php foreach($stages as $idx => $s): ?>
            <button type="button"
                    class="list-group-item list-group-item-action"
                    data-index="<?= $idx ?>"
                    data-stage-id="<?= $s['stage_id'] ?>">
              <?= htmlspecialchars($s['name']) ?>
            </button>
          <?php endforeach; ?>
        </div>
        <button id="addStageBtn" class="btn btn-outline-primary w-100 mt-2">+</button>
      </div>

      <div class="col-md-8">
        <div class="card p-4 bg-light">
          <form id="stageForm" action="/stages" method="POST">
            <input type="hidden" name="stage_id" id="stageId" value="">
            <div class="mb-3">
              <label for="stageName" class="form-label">Name</label>
              <input type="text" id="stageName" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
              <label for="stageBudget" class="form-label">Budget</label>
              <input type="number" id="stageBudget" name="allocated" class="form-control" required>
            </div>
            <div class="mb-3">
              <label for="stageDeadline" class="form-label">Deadline</label>
              <input type="date" id="stageDeadline" name="deadline" class="form-control" required>
            </div>
            <div class="mb-3">
              <label for="stageColor" class="form-label">Color</label>
              <input type="color" id="stageColor" name="color" class="form-control form-control-color" value="#D0E6A5">
            </div>
            <button type="submit" class="btn btn-primary">Save Stage</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const stages    = <?= json_encode($stages) ?>;
      const list      = document.getElementById('stageList');
      const form      = document.getElementById('stageForm');
      const idInput   = document.getElementById('stageId');
      const nameIn    = form.elements['name'];
      const budIn     = form.elements['allocated'];
      const dateIn    = form.elements['deadline'];
      const colorIn   = form.elements['color'];

      function loadStage(idx) {
        if (idx === null) {
          idInput.value   = '';
          nameIn.value    = '';
          budIn.value     = '';
          dateIn.value    = '';
          colorIn.value   = '#D0E6A5';
          list.querySelectorAll('.list-group-item').forEach(btn => btn.classList.remove('active'));
          return;
        }
        const s = stages[idx];
        idInput.value   = s.stage_id;
        nameIn.value    = s.name;
        budIn.value     = s.allocated;
        dateIn.value    = s.deadline;
        colorIn.value   = s.color;
        list.querySelectorAll('.list-group-item').forEach(btn => btn.classList.remove('active'));
        list.querySelector(`[data-index='${idx}']`).classList.add('active');
      }

      loadStage(null);
      list.addEventListener('click', e => {
        if (e.target.matches('.list-group-item')) {
          loadStage(e.target.dataset.index);
        }
      });
      document.getElementById('addStageBtn').addEventListener('click', () => loadStage(null));
    });
  </script>
</body>
</html>