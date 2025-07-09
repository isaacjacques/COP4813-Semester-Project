<?php
namespace Src\Controllers;

use Src\Config\Database;

class BaseController {
    protected $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->logPageVisit();
    }

    protected function logPageVisit(): void
    {
        $userId = $_SESSION['user_id'] ?? null;
        $requestUri = $_SERVER['REQUEST_URI'] ?? '';
        $pagePath   = parse_url($requestUri, PHP_URL_PATH) ?: '';


        $stmt = $this->db->prepare(
            "INSERT INTO page_visits (user_id, page) VALUES (:uid, :page)"
        );
        $stmt->execute([
            ':uid'  => $userId,
            ':page' => $pagePath
        ]);
    }
}
