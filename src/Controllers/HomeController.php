<?php
namespace Src\Controllers;
use Src\Config\Database;
use PDO;

class HomeController {

    public function index()
    {
        session_start();

        // If not logged in, show welcome page
        $user_id = $_SESSION['user_id'] ?? null;
        if (!$user_id) {
            require __DIR__ . '/../../views/welcome.php';
            return;
        }
        
        if (!isset($_SESSION['projects'])) {
            $projects = $this->getUserProjects($user_id);
        }

        if (isset($_GET['project_id'])) {
            $_SESSION['project_id'] = $_GET['project_id'];
        }

        if (!isset($_SESSION['project_id']) && !empty($projects)) {
            $_SESSION['project_id'] = $projects[0]['project_id'];
        }

        $project_id = $_SESSION['project_id'] ?? 0;


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
             WHERE s.project_id = :project_id
             GROUP BY s.stage_id
             ORDER BY s.deadline ASC"
        );
        $stmt->execute([
            ':project_id'=> $project_id
        ]);
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
        
        $stages = $this->getProjectStages($project_id);

        require __DIR__ . '/../../views/home.php';
    }

    public function getProjectStages(int $project_id): array
    {
        $db   = new Database();
        $conn = $db->connect();

        $sql = "
            SELECT
              stage_id AS id,
              name     AS title,
              COALESCE(
                  LAG(deadline) OVER (ORDER BY deadline),
                  CASE
                    WHEN CURDATE() < deadline THEN CURDATE()
                    ELSE deadline
                  END
              ) AS start,
              deadline AS end,
              color
            FROM stages
            WHERE project_id = :project_id
            ORDER BY deadline
        ";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':project_id' => $project_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
