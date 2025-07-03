<?php
namespace Src\Controllers;
use Src\Config\Database;
use PDO;

class RegisterController
{
    public function showForm()
    {
        include __DIR__ . '/../../views/register.php';
    }

    public function handleRegistration()
    {
        $db = new Database();
        $conn = $db->connect(); 

        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $hashedPassword = md5($password);
        // TODO: make checkbox to allow users to be admin
        $is_admin = 0; 
        $is_active = 1;

        try {
            $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email OR username = :username");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($result) > 0) {
                echo "User with this email or username already exists.";
                return;
            }

            // Insert new user
            $insert = $conn->prepare("INSERT INTO users (username, email, password_hash, is_admin, is_active) VALUES (:username, :email, :password, :is_admin, :is_active)");
            $insert->bindParam(':username', $username);
            $insert->bindParam(':email', $email);
            $insert->bindParam(':password', $hashedPassword);
            $insert->bindParam(':is_admin', $is_admin, PDO::PARAM_INT);
            $insert->bindParam(':is_active', $is_active, PDO::PARAM_INT);;

            if ($insert->execute()) {
                header("Location: ../login?registered=1");
                exit();
            } else {
                echo "Registration failed. Please try again.";
            }
        } catch (\PDOException $e) {
            echo "Database error: " . $e->getMessage();
        }
    }
}
