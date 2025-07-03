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
    
        include __DIR__ . '/../../views/admin_panel.php';
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
    
        include __DIR__ . '/../../views/admin_user_form.php';
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
}    