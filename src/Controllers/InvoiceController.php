<?php
namespace Src\Controllers;

use Src\Models\Invoice;
use Src\Models\Stage;

class InvoiceController
{
    protected Invoice $model;
    protected Stage   $stageModel;

    public function __construct()
    {
        session_start();
        $this->model      = new Invoice();
        $this->stageModel = new Stage();
    }

    public function index(): void
    {
        if (isset($_GET['project_id'])) {
            $_SESSION['project_id'] = (int) $_GET['project_id'];
        }

        $userId    = $_SESSION['user_id'] ?? null;
        $projectId = $_SESSION['project_id'] ?? null;
        if (!$userId || !$projectId) {
            header('Location: /home');
            exit;
        }

        $invoices = $this->model->allByProject($projectId, $userId);
        $stages   = $this->stageModel->allByProject($projectId);
        include __DIR__ . '/../views/invoices.php';
    }

    public function save(): void
    {
        $userId    = $_SESSION['user_id'] ?? null;
        $projectId = $_SESSION['project_id'] ?? null;
        if (!$userId || !$projectId) {
            header('Location: /home');
            exit;
        }

        $rawId     = $_POST['invoice_id'] ?? '';
        $invoiceId = $rawId !== '' ? (int)$rawId : null;
        $data      = [
            'stage_id'    => (int) $_POST['stage_id'],
            'amount'      => trim($_POST['amount']),
            'description' => trim($_POST['description']),
            'date_issued' => trim($_POST['date_issued']),
        ];

        if ($invoiceId !== null && $this->model->findByUser($invoiceId, $userId)) {
            $success = $this->model->update($invoiceId, $data);
        } else {
            $success = $this->model->create($data);
        }

        if ($success) {
            header('Location: /invoices');
            exit;
        }

        echo "Error saving invoice.";
        exit;
    }
}