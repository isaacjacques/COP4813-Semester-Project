<?php
namespace Src\Models;

use Src\Config\Database;
use PDO;

class Stage
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->connect();
    }

    public function allByProject(int $projectId): array
    {
        $stmt = $this->db->prepare(
            "SELECT stage_id, name, budget AS allocated, deadline, color
             FROM stages
             WHERE project_id = :project_id
             ORDER BY deadline ASC"
        );
        $stmt->execute([':project_id' => $projectId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByProject(int $stageId, int $projectId): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT stage_id, name, budget AS allocated, deadline, color
             FROM stages
             WHERE stage_id = :stage_id AND project_id = :project_id"
        );
        $stmt->execute([':stage_id' => $stageId, ':project_id' => $projectId]);
        $stage = $stmt->fetch(PDO::FETCH_ASSOC);
        return $stage ?: null;
    }

    public function create(array $data): bool
    {
        $stmt = $this->db->prepare(
            "INSERT INTO stages (project_id, name, budget, deadline, color)
             VALUES (:project_id, :name, :budget, :deadline, :color)"
        );
        return $stmt->execute([
            ':project_id' => $data['project_id'],
            ':name'       => $data['name'],
            ':budget'     => $data['allocated'],
            ':deadline'   => $data['deadline'],
            ':color'      => $data['color'],
        ]);
    }

    public function update(int $stageId, array $data): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE stages SET name = :name, budget = :budget, deadline = :deadline, color = :color
             WHERE stage_id = :stage_id AND project_id = :project_id"
        );
        return $stmt->execute([
            ':name'       => $data['name'],
            ':budget'     => $data['allocated'],
            ':deadline'   => $data['deadline'],
            ':color'      => $data['color'],
            ':stage_id'   => $data['stage_id'],
            ':project_id' => $data['project_id'],
        ]);
    }
}