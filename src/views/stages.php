<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Stages</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <?php include 'navbar.php'; ?>
  <div class="container mt-4">
    <h3>Stages</h3>
    <div class="row">
      <div class="col-md-4">
        <div id="stageList" class="list-group overflow-auto" style="max-height:400px;"></div>
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
              <input type="color" id="stageColor" name="color" class="form-control form-control-color">
            </div>
            <button type="submit" class="btn btn-primary">Save Stage</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const stageList = document.getElementById('stageList');
      const form      = document.getElementById('stageForm');
      const idInput   = document.getElementById('stageId');
      const nameIn    = form.elements['name'];
      const budIn     = form.elements['allocated'];
      const dateIn    = form.elements['deadline'];
      const colorIn   = form.elements['color'];
      let stages = [];

      function fetchStages() {
        fetch(`/stages?ajax=1`)
          .then(res => res.json())
          .then(data => {
            stages = Array.isArray(data) ? data : [];
            renderList();
          })
          .catch(console.error);
      }

      function renderList() {
        stageList.innerHTML = '';
        stages.forEach((s, idx) => {
          const btn = document.createElement('button');
          btn.type = 'button';
          btn.className = 'list-group-item list-group-item-action';
          btn.dataset.index = idx;
          btn.textContent = s.name;
          stageList.appendChild(btn);
        });
        loadStage(null);
      }

      function loadStage(idx) {
        if (idx === null) {
          stageList.querySelectorAll('button').forEach(btn => btn.classList.remove('active'));
          idInput.value = '';
          nameIn.value = '';
          budIn.value = '';
          dateIn.value = '';
          colorIn.value = '#D0E6A5';
          return;
        }
        if (!Array.isArray(stages) || idx < 0 || idx >= stages.length) return;
        const buttons = stageList.querySelectorAll('button');
        buttons.forEach(btn => btn.classList.remove('active'));
        buttons[idx].classList.add('active');
        const stage = stages[idx];
        idInput.value = stage.stage_id;
        nameIn.value = stage.name;
        budIn.value = stage.allocated;
        dateIn.value = stage.deadline;
        colorIn.value = stage.color;
      }

      stageList.addEventListener('click', e => {
        const btn = e.target.closest('button[data-index]');
        if (!btn) return;
        loadStage(Number(btn.dataset.index));
      });

      document.getElementById('addStageBtn').addEventListener('click', () => loadStage(null));

      fetchStages();
    });
  </script>
</body>
</html>
