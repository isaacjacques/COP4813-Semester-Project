<?php
namespace Src\Controllers;

class AuthController
{
    public function showLoginForm()
    {
        include __DIR__ . '/../../views/login.php';
    }

    public function handleLogin()
    {
        session_start();

        // Placeholder logic
        // Later, verify credentials against DB
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if ($username === 'admin' && $password === 'password') {
            $_SESSION['user_id'] = $username;
            $_SESSION['username'] = $username;
            header('Location: /home');
            exit;
        }

        //echo "Invalid login";
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
        header('Location: /home');
        exit;
    }
}