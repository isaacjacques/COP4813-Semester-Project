<?php
namespace Src\Controllers;
use Src\Config\Database;
use PDO;

class BudgetController {

    public function index() {
        session_start();
        
        $db = new Database();
        $conn = $db->connect();

        if (isset($_GET['project_id'])) {
            $_SESSION['project_id'] = (int) $_GET['project_id'];
        }

        $userId    = $_SESSION['user_id'] ?? null;
        $projectId = $_SESSION['project_id'] ?? null;

        if (!$userId || !$projectId) {
            header('Location: /home');
            exit;
        }

        $stmt = $conn->prepare(
            "SELECT 
                s.name, 
                s.budget AS allocated, 
                IFNULL(SUM(i.amount), 0) AS used, 
                s.color 
             FROM stages s 
             LEFT JOIN invoices i ON s.stage_id = i.stage_id 
             WHERE s.project_id = :project_id
             GROUP BY s.stage_id 
             ORDER BY s.deadline ASC"
        );
        $params=[
            ':project_id' => $projectId
        ];
        $stmt->execute($params);
        $stages = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $totalBudget    = array_sum(array_column($stages, 'allocated'));
        $usedTotal      = array_sum(array_column($stages, 'used'));
        $remaining      = max($totalBudget - $usedTotal, 0);

        $stagesJson      = json_encode($stages);
        $totalBudgetJson = json_encode($totalBudget);
        $usedTotalJson   = json_encode($usedTotal);
        $remainingJson   = json_encode($remaining);

        include __DIR__ . '/../views/budget.php';
    }
}
