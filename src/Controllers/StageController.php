<?php
namespace Src\Controllers;
use Src\Config\Database;
use PDO;

class StageController
{

    public function index()
    {
        session_start();

        $user_id    = $_SESSION['user_id']    ?? null;

        if (isset($_GET['project_id'])) {
            $_SESSION['project_id'] = $_GET['project_id'];
        }
        
        $project_id = $_SESSION['project_id'] ?? null;
        if (!$user_id || !$project_id) {
            header('Location: /home');
            exit;
        }
        
        $db = new Database();
        $conn = $db->connect();

        $stmt = $conn->prepare(
            "SELECT 
                name, 
                budget AS allocated, 
                deadline, 
                color 
             FROM stages 
             WHERE project_id=:project_id

             ORDER BY deadline ASC"
        );
        $stmt->execute([
            ':project_id'=> $project_id
        ]);
        $stages = $stmt->fetchAll(PDO::FETCH_ASSOC);

        include __DIR__ . '/../../views/stages.php';
    }


    public function save()
    {
        session_start();
        
        $user_id    = $_SESSION['user_id'] ?? null;
        $project_id = $_SESSION['project_id'] ?? null;

        $name = trim($_POST['name']);
        $allocated = trim($_POST['allocated']);
        $deadline = trim($_POST['deadline']);

        $db = new Database();
        $conn = $db->connect();

        $stmt = $conn->prepare(
            "INSERT INTO stages (project_id, name, budget, deadline, color) 
                VALUES (:project_id, :name, :budget, :deadline, :color)"
        );

        $success = $stmt->execute([
            ':project_id'=> $project_id,
            ':name'      => $name,
            ':budget'    => $allocated,
            ':deadline'  => $deadline,
            ':color'     => '#D0E6A5'
        ]);

        if ($success) {
            header('Location: /stages');
            exit;
        }

        echo "Failed to save stage.";
        exit;
    }
}
