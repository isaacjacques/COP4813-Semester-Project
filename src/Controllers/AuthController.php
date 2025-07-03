<?php
namespace Src\Controllers;
use Src\Config\Database;
use PDO;

class AuthController
{
    public function showLoginForm()
    {
        include __DIR__ . '/../../views/login.php';
    }

    public function handleLogin()
    {
        session_start();

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($username === '' || $password === '') {
            header('Location: /login?error=1');
            exit;
        }
        
        $db   = new Database();
        $conn = $db->connect();

        $stmt = $conn->prepare(
            'SELECT user_id, username, password_hash, is_admin, is_active
             FROM users 
             WHERE username = :username 
             LIMIT 1'
        );
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && md5($password) === $user['password_hash']) {
            session_regenerate_id(true);

            
            $_SESSION['user_id']  = $user['user_id'];
            $_SESSION['username'] = $user['username'];            
            $_SESSION['is_admin'] = $user['is_admin'];           
            $_SESSION['is_active'] = $user['is_active'];

            //If user account is active then go home else show login error
            $is_active = $_SESSION['is_active'];
            if ($is_active === 0) {
                $_SESSION = [];
                session_destroy();
                header("Location: /login?error=2");
                exit;
            } else {
                header('Location: /home');
                exit;
            }

        } 

        header("Location: /login?error=1");
        exit;
    }

    public function logout() {
        session_start();

        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
        exit;
    }
}