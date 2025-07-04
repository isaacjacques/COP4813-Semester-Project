<?php
namespace Src\Models;

class Stage extends BaseModel
{
    public function allByProject(int $projectId): array
    {
        $sql = "SELECT stage_id, name, budget AS allocated, deadline, color
                FROM stages
                WHERE project_id = :project_id
                ORDER BY deadline ASC";
        return $this->fetchAll($sql, [':project_id' => $projectId]);
    }

    public function findByProject(int $stageId, int $projectId): ?array
    {
        $sql = "SELECT stage_id, name, budget AS allocated, deadline, color
                FROM stages
                WHERE stage_id   = :stage_id
                  AND project_id = :project_id";
        return $this->fetchOne($sql, [
            ':stage_id'   => $stageId,
            ':project_id' => $projectId,
        ]);
    }

    public function create(array $data): bool
    {
        $sql = "INSERT INTO stages (project_id, name, budget, deadline, color)
                VALUES (:project_id, :name, :budget, :deadline, :color)";
        return $this->execute($sql, [
            ':project_id' => $data['project_id'],
            ':name'       => $data['name'],
            ':budget'     => $data['allocated'],
            ':deadline'   => $data['deadline'],
            ':color'      => $data['color'],
        ]);
    }

    public function update(int $stageId, array $data): bool
    {
        $sql = "UPDATE stages
                SET name     = :name,
                    budget   = :budget,
                    deadline = :deadline,
                    color    = :color
                WHERE stage_id   = :stage_id
                  AND project_id = :project_id";
        return $this->execute($sql, [
            ':name'       => $data['name'],
            ':budget'     => $data['allocated'],
            ':deadline'   => $data['deadline'],
            ':color'      => $data['color'],
            ':stage_id'   => $data['stage_id'],
            ':project_id' => $data['project_id'],
        ]);
    }
}