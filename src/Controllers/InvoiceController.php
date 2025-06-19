<?php
namespace Src\Controllers;
use Src\Config\Database;
use PDO;

class InvoiceController
{
    public function getAllInvoices()
    {
        $db = new Database();
        $conn = $db->connect();

        $stmt = $conn->prepare("
            SELECT i.invoice_id, i.amount, i.description, i.date_issued,
                s.name AS stage_name
            FROM invoices i
            JOIN stages s ON i.stage_id = s.stage_id
            ORDER BY i.date_issued DESC
        ");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function index()
    {
        include __DIR__ . '/../../views/invoices.php';
    }
}