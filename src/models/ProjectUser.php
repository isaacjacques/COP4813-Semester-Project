<?php
namespace Src\Models;
use Src\Config\Database;

class ProjectUser extends BaseModel
{
    protected string $table = 'project_users';

    public function create(int $projectId, int $userId): bool
    {
        $sql = "INSERT INTO project_users (project_id, user_id)
                VALUES (:project_id, :user_id)";

        return $this->execute($sql, [
            ':project_id' => $projectId,
            ':user_id'    => $userId,
        ]);
    }

    public function isUserAssigned(int $projectId, int $userId): bool
    {
        $sql = "SELECT 1
                  FROM {$this->table}
                 WHERE project_id = :project_id
                   AND user_id    = :user_id
                 LIMIT 1";
        return (bool) $this->fetchOne($sql, [
            ':project_id' => $projectId,
            ':user_id'    => $userId
        ]);
    }


    public function deleteByProjectId(int $projectId): void
    {
        $sql = "DELETE
                  FROM {$this->table}
                 WHERE project_id = :project_id";
        $this->execute($sql, [
            ':project_id' => $projectId
        ]);
    }
}