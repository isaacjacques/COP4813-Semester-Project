<?php
namespace Src\Controllers;
use Src\Config\Database;
use Src\Models\Project;
use Src\Models\ProjectUser;
use Src\Models\Analytics;

use PDO;
use DateTime;
use DateInterval;
use DatePeriod;
class AdminController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ((int)($_SESSION['is_admin'] ?? 0) !== 1) {
            echo "This page is only accessible for admins.";
            return;
        }
        

        $db = new Database();
        $conn = $db->connect();
    
        $stmt = $conn->prepare("SELECT user_id, username, email, is_admin FROM users");
        $stmt->execute();
        $users = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    
        include __DIR__ . '/../Views/admin_panel.php';
    }

    public function viewUser() {
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
    
        include __DIR__ . '/../Views/admin_user_form.php';
    }
    

    public function updateUser() {
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

        if (isset($_GET['project_id'])) {
            $_SESSION['project_id'] = (int)$_GET['project_id'];
        }
        $selectedProjectId = $_SESSION['project_id'] ?? 0;
 
        $assignedStmt = $conn->prepare(
            "SELECT u.user_id, u.username
             FROM users u
             JOIN project_users pu ON u.user_id = pu.user_id
             WHERE pu.project_id = :project_id"
        );
        $assignedStmt->execute([':project_id' => $selectedProjectId]);
        $assignedUsers = $assignedStmt->fetchAll(PDO::FETCH_ASSOC);

        include __DIR__ . '/../Views/manage_users.php';
    }

    public function assignUser()
    {
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

    public function projectOverview()
    {
        if ((int)($_SESSION['is_admin'] ?? 0) !== 1) {
            echo "This page is only accessible for admins.";
            return;
        }

        $adminId = $_SESSION['user_id'];

        $projects = (new Project())->allByUser($adminId);

        include __DIR__ . '/../Views/project_overview.php';
    }

    public function deleteProject(array $params)
    {
        if ((int)($_SESSION['is_admin'] ?? 0) !== 1) {
            echo "This page is only accessible for admins.";
            return;
        }

        $adminId   = $_SESSION['user_id'];
        $projectId = (int) ($params['project_id'] ?? 0);

        $puModel = new ProjectUser();
        if ($puModel->isUserAssigned($projectId, $adminId)) {
            $puModel->deleteByProjectId($projectId);

            (new Project())->deleteById($projectId);

        }

        header('Location: /admin/project_overview');
        exit;
    }
    public function analytics()
    {
        if ((int)($_SESSION['is_admin'] ?? 0) !== 1) {
            echo "This page is only accessible for admins.";
            return;
        }

        $today = new DateTime('now');
        $from  = (clone $today)->modify('-30 days');
        $role  = strtolower($_GET['role'] ?? '');

        $model = new Analytics();
        $data = [
            'totalUsers'     => $model->getTotalUsers($role),
            'regTrends'      => $model->getRegistrationTrends('day', $from, $today, $role),
            'activeInactive' => $model->getActiveInactiveCounts($role),
            'projectCount'   => $model->getProjectCount($from, $today),
            'stageCount'     => $model->getStageCount($from, $today),
            'invoiceCount'   => $model->getInvoiceCount($from, $today),
            'pageUsage'      => $model->getPageUsage($from, $today, 10, $role),
            'invoiceTrends'  => $model->getInvoiceTrends('day', $from, $today)
        ];

        extract($data);
        require __DIR__ . '/../Views/analytics.php';
    }

    public function analyticsData()
    {
        if ((int)($_SESSION['is_admin'] ?? 0) !== 1) {
            echo "This page is only accessible for admins.";
            return;
        }
        
        $input    = json_decode(file_get_contents('php://input'), true);
        $from     = isset($input['from'])     ? new DateTime($input['from']) : new DateTime('-30 days');
        $to       = isset($input['to'])       ? new DateTime($input['to'])   : new DateTime('now');
        $interval = $input['interval']        ?? 'day';
        $role     = strtolower($input['role'] ?? '');

        $model = new Analytics();
        $response = [
            'totalUsers'     => $model->getTotalUsers($role),
            'regTrends'      => $model->getRegistrationTrends($interval, $from, $to, $role),
            'activeInactive' => $model->getActiveInactiveCounts($role),
            'projectCount'   => $model->getProjectCount($from, $to),
            'stageCount'     => $model->getStageCount($from, $to),
            'invoiceCount'   => $model->getInvoiceCount($from, $to),
            'pageUsage'      => $model->getPageUsage($from, $to, 10, $role),
            'invoiceTrends'  => $model->getInvoiceTrends($interval, $from, $to)
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
    }

}    