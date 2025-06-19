<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Invoices</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <?php include 'navbar.php'; ?>

  <div class="container mt-4">
    <h3>Invoices</h3>
    <div class="row">
      <!-- Invoice List -->
      <div class="col-md-4">
        <div id="invoiceList" class="list-group" style="height:400px; overflow-y:auto;">
          <?php foreach($invoices as $idx => $inv): ?>
            <a href="#" class="list-group-item list-group-item-action <?= $idx===0 ? 'active' : '' ?>" data-index="<?= $idx ?>">
              <?= htmlspecialchars($inv['number']) ?>
            </a>
          <?php endforeach; ?>
        </div>
        <button id="addInvoiceBtn" class="btn btn-outline-primary w-100 mt-2">+</button>
      </div>

      <!-- Invoice Detail Form -->
      <div class="col-md-8">
        <div class="card p-3 bg-light">
          <form id="invoiceForm">
            <div class="mb-3">
              <label class="form-label">Invoice Number</label>
              <input type="text" name="number" class="form-control" value="<?= htmlspecialchars($invoices[0]['number']) ?>">
            </div>
            <div class="mb-3">
              <label class="form-label">Cost</label>
              <input type="number" name="cost" class="form-control" value="<?= htmlspecialchars($invoices[0]['cost']) ?>">
            </div>
            <div class="mb-3">
              <label class="form-label">Stage Tags</label>
              <div id="tagContainer">
                <?php foreach($invoices[0]['tags'] as $tag): ?>
                  <span class="badge bg-secondary me-1"><?= htmlspecialchars($tag) ?></span>
                <?php endforeach; ?>
              </div>
              <select id="stageSelect" class="form-select mt-1" style="display:none;">
                <?php foreach($stages as $st): ?>
                  <option value="<?= htmlspecialchars($st['name']) ?>"><?= htmlspecialchars($st['name']) ?></option>
                <?php endforeach; ?>
              </select>
              <button type="button" id="addTagBtn" class="btn btn-outline-secondary btn-sm mt-1">+</button>
            </div>
            <div class="mb-3">
              <label class="form-label">Notes</label>
              <textarea name="notes" class="form-control" rows="4"><?= htmlspecialchars($invoices[0]['notes']) ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Save Invoice</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    // Bring PHP arrays into JS
    const invoices = <?= json_encode($invoices) ?>;
    const stages   = <?= json_encode(array_column($stages,'name')) ?>;

    document.addEventListener('DOMContentLoaded', () => {
      const list        = document.getElementById('invoiceList');
      const form        = document.getElementById('invoiceForm');
      const numInput    = form.elements['number'];
      const costInput   = form.elements['cost'];
      const notesInput  = form.elements['notes'];
      const tagContainer= document.getElementById('tagContainer');
      const stageSelect = document.getElementById('stageSelect');

      function loadInvoice(idx) {
        const inv = invoices[idx];
        numInput.value   = inv.number;
        costInput.value  = inv.cost;
        notesInput.value = inv.notes;
        tagContainer.innerHTML = '';
        inv.tags.forEach(tag => {
          const span = document.createElement('span');
          span.className = 'badge bg-secondary me-1';
          span.textContent = tag;
          tagContainer.appendChild(span);
        });
      }

      loadInvoice(0);

      // Switch selection
      list.addEventListener('click', e => {
        e.preventDefault();
        if (!e.target.matches('.list-group-item')) return;
        list.querySelectorAll('.list-group-item').forEach(i => i.classList.remove('active'));
        e.target.classList.add('active');
        loadInvoice(e.target.dataset.index);
      });

      // Add new tag
      document.getElementById('addTagBtn').addEventListener('click', () => {
        stageSelect.style.display = 'block';
        stageSelect.focus();
      });
      stageSelect.addEventListener('change', () => {
        const tag = stageSelect.value;
        const span = document.createElement('span');
        span.className = 'badge bg-secondary me-1';
        span.textContent = tag;
        tagContainer.appendChild(span);
        stageSelect.style.display = 'none';
      });
    });
  </script>
</body>
</html>
