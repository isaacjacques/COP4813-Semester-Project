<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Controllers/InvoiceController.php';

use Src\Controllers\InvoiceController;

$controller = new InvoiceController();
$invoices = $controller->getAllInvoices();
$firstInvoice = $invoices[0] ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoices</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container mt-5">
    <h2>Invoices</h2>
    <div class="row">
        <!-- Invoice List -->
        <div class="col-md-4">
            <ul class="list-group" id="invoiceList">
                <?php foreach ($invoices as $index => $inv): ?>
                    <li class="list-group-item invoice-item <?= $index === 0 ? 'active' : '' ?>"
                        data-id="<?= htmlspecialchars($inv['invoice_id']) ?>"
                        data-amount="<?= htmlspecialchars($inv['amount']) ?>"
                        data-notes="<?= htmlspecialchars($inv['description']) ?>"
                        data-stage="<?= htmlspecialchars($inv['stage_name']) ?>">
                        <?= htmlspecialchars($inv['invoice_id']) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
            <button class="btn btn-outline-primary mt-3 w-100">+</button>
        </div>

        <!-- Invoice Form -->
        <div class="col-md-8 rounded border" style="background-color: var(--color-secondary);">
            <form method="post" action="">
                <div class="mb-3">
                    <label for="invoice_number" class="form-label">Invoice Number</label>
                    <input type="text" class="form-control" id="invoice_number" name="invoice_number"
                           value="<?= $firstInvoice['invoice_id'] ?? '' ?>">
                </div>

                <div class="mb-3">
                    <label for="amount" class="form-label">Cost</label>
                    <input type="number" class="form-control" id="amount" name="amount"
                           value="<?= $firstInvoice['amount'] ?? '' ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Stage Tags</label>
                    <div id="stageTags">
                        <?php if (!empty($firstInvoice['stage_name'])): ?>
                            <span class="badge bg-secondary me-2"><?= htmlspecialchars($firstInvoice['stage_name']) ?></span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="notes" class="form-label">Notes</label>
                    <textarea class="form-control" id="notes" name="notes" rows="3"><?= $firstInvoice['description'] ?? '' ?></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Save Invoice</button>
            </form>
        </div>
    </div>
</div>
<script>
  document.querySelectorAll('.invoice-item').forEach(item => {
      item.addEventListener('click', () => {
          const id = item.dataset.id;
          const amount = item.dataset.amount;
          const notes = item.dataset.notes;
          const stage = item.dataset.stage;

          document.getElementById('invoice_number').value = id;
          document.getElementById('amount').value = amount;
          document.getElementById('notes').value = notes;

          const stageContainer = document.getElementById('stageTags');
          stageContainer.innerHTML = '';
          if (stage) {
              const tag = document.createElement('span');
              tag.className = 'badge bg-secondary me-2';
              tag.textContent = stage;
              stageContainer.appendChild(tag);
          }

          document.querySelectorAll('.invoice-item').forEach(el => el.classList.remove('active'));
          item.classList.add('active');
      });
  });
</script>
</body>
</html>