<?php
namespace Src\Controllers;
use Src\Config\Database;
use PDO;
class AdminController
{
    public function index()
    {
        session_start();

        if ((int)($_SESSION['is_admin'] ?? 0) !== 1) {
            echo "This page is only accessible for admins.";
            return;
        }
        

        $db = new Database();
        $conn = $db->connect();
    
        $stmt = $conn->prepare("SELECT user_id, username, email, is_admin FROM users");
        $stmt->execute();
        $users = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    
        include __DIR__ . '/../views/admin_panel.php';
    }

    public function viewUser() {
        session_start();


        if ((int)($_SESSION['is_admin'] ?? 0) !== 1) {
            echo "This page is only accessible for admins.";
            return;
        }
    
        if (!isset($_GET['user_id'])) {
            echo "User ID not provided.";
            exit;
        }
    
        $user_id = $_GET['user_id'];
    
        $db = new Database();
        $conn = $db->connect();
    
        $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = :user_id");
        $stmt->execute([':user_id' => $user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if (!$user) {
            echo "User not found.";
            exit;
        }
    
        include __DIR__ . '/../views/admin_user_form.php';
    }
    

    public function updateUser() {
        session_start();
        $user_id = $_POST['user_id'] ?? null;
        $action = $_POST['action'] ?? 'update';
    
        if (!$user_id) {
            header("Location: /admin");
            exit;
        }
    
        $db = new Database();
        $conn = $db->connect();

    
        // Get current admin count (needed in case of demotion or deletion)
        $stmt = $conn->query("SELECT COUNT(*) as admin_count FROM users WHERE is_admin = 1");
        $adminCount = $stmt->fetch(PDO::FETCH_ASSOC)['admin_count'];
    
        // Check if this user is the last admin
        $stmt = $conn->prepare("SELECT is_admin FROM users WHERE user_id = :user_id");
        $stmt->execute([':user_id' => $user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Handle DELETE
        if ($action === 'delete') {
            if ($user['is_admin'] && $adminCount <= 1) {
                // Cannot delete the last admin
                header("Location: /admin?error=last_admin");
                exit;
            }
    
            $stmt = $conn->prepare("DELETE FROM users WHERE user_id = :user_id");
            $stmt->execute([':user_id' => $user_id]);
    
            header("Location: /admin?deleted=1");
            exit;
        }
    
        // Otherwise: Update user info
        $username  = $_POST['username'] ?? '';
        $email     = $_POST['email'] ?? '';
        $is_admin  = isset($_POST['is_admin']) ? (int)$_POST['is_admin'] : 0;
        $is_active = isset($_POST['is_active']) ? (int)$_POST['is_active'] : 1;
    
        // Prevent demoting the last admin
        if ($user['is_admin'] && !$is_admin && $adminCount <= 1) {
            header("Location: /admin?error=last_admin");
            exit;
        }
    
        $stmt = $conn->prepare("UPDATE users SET username = :username, email = :email, is_admin = :is_admin, is_active = :is_active WHERE user_id = :user_id");
        $stmt->execute([
            ':username'  => $username,
            ':email'     => $email,
            ':is_admin'  => $is_admin,
            ':is_active' => $is_active,
            ':user_id'   => $user_id
        ]);
    
        header("Location: /admin?updated=1");
        exit;
    }

     public function manageUsers()
    {
        session_start();

        if ((int)($_SESSION['is_admin'] ?? 0) !== 1) {
            echo "This page is only accessible for admins.";
            return;
        }

        $db = new Database();
        $conn = $db->connect();

        $projStmt = $conn->prepare("SELECT project_id, title FROM projects ORDER BY title");
        $projStmt->execute();
        $projects = $projStmt->fetchAll(PDO::FETCH_ASSOC);

        $userStmt = $conn->prepare("SELECT user_id, username FROM users");
        $userStmt->execute();
        $users = $userStmt->fetchAll(PDO::FETCH_ASSOC);

        $selectedProjectId = $_SESSION['project_id'] ?? ($projects[0]['project_id'] ?? null);
 
        $assignedStmt = $conn->prepare(
            "SELECT u.user_id, u.username
             FROM users u
             JOIN project_users pu ON u.user_id = pu.user_id
             WHERE pu.project_id = :project_id"
        );
        $assignedStmt->execute([':project_id' => $selectedProjectId]);
        $assignedUsers = $assignedStmt->fetchAll(PDO::FETCH_ASSOC);

        include __DIR__ . '/../views/manage_users.php';
    }

    public function assignUser()
    {
        session_start();

        if ((int)($_SESSION['is_admin'] ?? 0) !== 1) {
            echo "This page is only accessible for admins.";
            return;
        }

        $projectId = (int)($_POST['project_id'] ?? 0);
        $userId    = (int)($_POST['user_id'] ?? 0);

        if ($projectId && $userId) {
            $db = new Database();
            $conn = $db->connect();

            $stmt = $conn->prepare(
                "INSERT IGNORE INTO project_users (project_id, user_id) VALUES (:project_id, :user_id)"
            );
            $stmt->execute([
                ':project_id' => $projectId,
                ':user_id'    => $userId
            ]);
        }

        header("Location: /admin/users?project_id={$projectId}");
        exit;
    }
}    