<?php
namespace Src\Controllers;
use Src\Config\Database;
use PDO;

class HomeController {

    public function index()
    {
        session_start();

        // If not logged in, show welcome page
        if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] === null) {
            require __DIR__ . '/../../views/welcome.php';
            return;
        }

        $db   = new Database();
        $conn = $db->connect();

        $stmt = $conn->prepare(
            "SELECT 
                s.name, 
                s.color, 
                s.deadline,
                s.budget AS allocated, 
                IFNULL(SUM(i.amount), 0) AS used
             FROM stages s
             LEFT JOIN invoices i ON s.stage_id = i.stage_id
             GROUP BY s.stage_id
             ORDER BY s.deadline ASC"
        );
        $stmt->execute();
        $stages = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $allocations = array_column($stages, 'allocated');
        $usedAmounts = array_column($stages, 'used');
        $totalBudget = array_sum($allocations);
        $remaining   = max($totalBudget - array_sum($usedAmounts), 0);

        $stageNamesJson   = json_encode(array_column($stages, 'name'));
        $colorsJson       = json_encode(array_column($stages, 'color'));
        $allocationsJson  = json_encode($allocations);
        $usedJson         = json_encode($usedAmounts);
        $remainingJson    = json_encode($remaining);

        require __DIR__ . '/../../views/home.php';
    }

    public function getUserProjects(int $userId): array
    {
        $db   = new Database();
        $conn = $db->connect();

        $user_id = $_SESSION['user_id'];
        $stmt = $conn->prepare(
            "SELECT project_id, title
               FROM projects
              WHERE user_id = :user_id
           ORDER BY project_id"
        );
        $stmt->execute([':user_id' => $user_id]);
        $count = $stmt->rowCount();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
