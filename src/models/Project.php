<?php
namespace Src\Models;

class Project extends BaseModel
{
 public function allByUser(int $userId): array
    {
        $sql = "SELECT pu.project_id, title, description, total_budget
                FROM projects p 
                INNER JOIN project_users pu
                    ON p.project_id = pu.project_id
                WHERE pu.user_id = :user_id
                ORDER BY pu.project_id ASC";
        return $this->fetchAll($sql, [':user_id' => $userId]);
    }

    public function findByUser(int $projectId, int $userId): ?array
    {
        $sql = "SELECT pu.project_id, title, description, total_budget
                FROM projects
                INNER JOIN project_users pu
                    ON p.project_id = pu.project_id
                WHERE pu.user_id = :user_id
                ORDER BY pu.project_id ASC";
        return $this->fetchOne($sql, [
            ':project_id' => $projectId,
            ':user_id'    => $userId,
        ]);
    }

    public function create(array $data): bool
    {
        $sql = "INSERT INTO projects
                (user_id, title, description, total_budget)
                VALUES
                (:user_id, :title, :description, :total_budget)";
        return $this->execute($sql, [
            ':user_id'      => $data['user_id'],
            ':title'        => $data['title'],
            ':description'  => $data['description'],
            ':total_budget' => $data['total_budget'],
        ]);
    }

    public function update(int $projectId, array $data): bool
    {
        $sql = "UPDATE projects
                SET title        = :title,
                    description  = :description,
                    total_budget = :total_budget
                WHERE project_id = :project_id";
        return $this->execute($sql, [
            ':title'        => $data['title'],
            ':description'  => $data['description'],
            ':total_budget' => $data['total_budget'],
            ':project_id'   => $projectId,
        ]);
    }
}