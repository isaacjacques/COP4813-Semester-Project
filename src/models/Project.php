<?php
namespace Src\Models;

use Src\Config\Database;
use PDO;

class Project
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->connect();
    }

    public function allByUser(int $userId): array
    {
        $stmt = $this->db->prepare(
            "SELECT project_id, title, description, total_budget
             FROM projects
             WHERE user_id = :user_id
             ORDER BY project_id ASC"
        );
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByUser(int $projectId, int $userId): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT project_id, title, description, total_budget
             FROM projects
             WHERE project_id = :project_id
               AND user_id = :user_id"
        );
        $stmt->execute([
            ':project_id' => $projectId,
            ':user_id'    => $userId
        ]);
        $project = $stmt->fetch(PDO::FETCH_ASSOC);
        return $project ?: null;
    }

    public function create(array $data): bool
    {
        $stmt = $this->db->prepare(
            "INSERT INTO projects (user_id, title, description, total_budget)
             VALUES (:user_id, :title, :description, :total_budget)"
        );
        return $stmt->execute([
            ':user_id'      => $data['user_id'],
            ':title'        => $data['title'],
            ':description'  => $data['description'],
            ':total_budget' => $data['total_budget'],
        ]);
    }

    public function update(int $projectId, array $data): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE projects
             SET title = :title,
                 description = :description,
                 total_budget = :total_budget
             WHERE project_id = :project_id"
        );
        return $stmt->execute([
            ':title'        => $data['title'],
            ':description'  => $data['description'],
            ':total_budget' => $data['total_budget'],
            ':project_id'   => $projectId,
        ]);
    }
}