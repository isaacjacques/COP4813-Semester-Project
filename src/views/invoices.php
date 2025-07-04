<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Invoices</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
  <?php include 'navbar.php'; ?>
  <div class="container mt-4">
    <h3>Invoices</h3>
    <div class="row">
      <div class="col-md-4">
        <div id="invoiceList" class="list-group" style="max-height:400px; overflow-y:auto;">
          <?php foreach($invoices as $idx => $inv): ?>
            <button type="button"
                    class="list-group-item list-group-item-action"
                    data-index="<?= $idx ?>"
                    data-invoice-id="<?= $inv['invoice_id'] ?>">
              Invoice #<?= htmlspecialchars($inv['invoice_id']) ?>
            </button>
          <?php endforeach; ?>
        </div>
        <button id="addInvoiceBtn" class="btn btn-outline-primary w-100 mt-2">+</button>
      </div>

      <div class="col-md-8">
        <div class="card p-4 bg-light">
          <form id="invoiceForm" action="/invoices" method="POST">
            <input type="hidden" name="invoice_id" id="invoiceId" value="">
            <div class="mb-3">
              <label for="invoiceStage" class="form-label">Stage</label>
              <select id="invoiceStage" name="stage_id" class="form-select" required>
                <?php foreach($stages as $s): ?>
                  <option value="<?= $s['stage_id'] ?>"><?= htmlspecialchars($s['name']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="mb-3">
              <label for="invoiceAmount" class="form-label">Amount</label>
              <input type="number" step="0.01" id="invoiceAmount" name="amount" class="form-control" required>
            </div>
            <div class="mb-3">
              <label for="invoiceDesc" class="form-label">Description</label>
              <textarea id="invoiceDesc" name="description" class="form-control" rows="2"></textarea>
            </div>
            <div class="mb-3">
              <label for="invoiceDate" class="form-label">Date Issued</label>
              <input type="date" id="invoiceDate" name="date_issued" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Save Invoice</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const invoices = <?= json_encode($invoices) ?>;
      const stages   = <?= json_encode($stages) ?>;
      const list     = document.getElementById('invoiceList');
      const form     = document.getElementById('invoiceForm');
      const idInput  = document.getElementById('invoiceId');
      const stageSel = form.elements['stage_id'];
      const amtIn    = form.elements['amount'];
      const descIn   = form.elements['description'];
      const dateIn   = form.elements['date_issued'];

      function loadInvoice(idx) {
        if (idx === null) {
          idInput.value = '';
          stageSel.selectedIndex = 0;
          amtIn.value = '';
          descIn.value = '';
          dateIn.value = '';
          list.querySelectorAll('.list-group-item').forEach(btn => btn.classList.remove('active'));
          return;
        }
        const inv = invoices[idx];
        idInput.value = inv.invoice_id;
        stageSel.value = inv.stage_id;
        amtIn.value = inv.amount;
        descIn.value = inv.description;
        dateIn.value = inv.date_issued;
        list.querySelectorAll('.list-group-item').forEach(btn => btn.classList.remove('active'));
        list.querySelector(`[data-index='${idx}']`).classList.add('active');
      }

      loadInvoice(null);
      list.addEventListener('click', e => {
        if (e.target.matches('.list-group-item')) {
          loadInvoice(e.target.dataset.index);
        }
      });
      document.getElementById('addInvoiceBtn').addEventListener('click', () => loadInvoice(null));
    });
  </script>
</body>
</html>