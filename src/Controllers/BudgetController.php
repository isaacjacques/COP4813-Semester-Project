<?php
namespace Src\Controllers;
use Src\Config\Database;
use PDO;

class BudgetController {

    public function index() {
        $db = new Database();
        $conn = $db->connect();

        $stmt = $conn->prepare(
            "SELECT 
                s.name, 
                s.budget AS allocated, 
                IFNULL(SUM(i.amount), 0) AS used, 
                s.color 
             FROM stages s 
             LEFT JOIN invoices i ON s.stage_id = i.stage_id 
             GROUP BY s.stage_id 
             ORDER BY s.deadline ASC"
        );
        $stmt->execute();
        $stages = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $totalBudget    = array_sum(array_column($stages, 'allocated'));
        $usedTotal      = array_sum(array_column($stages, 'used'));
        $remaining      = max($totalBudget - $usedTotal, 0);

        $stagesJson      = json_encode($stages);
        $totalBudgetJson = json_encode($totalBudget);
        $usedTotalJson   = json_encode($usedTotal);
        $remainingJson   = json_encode($remaining);

        include __DIR__ . '/../../views/budget.php';
    }
}
