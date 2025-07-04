<?php
namespace Src\Models;

class ProjectUser extends BaseModel
{
    public function create(int $projectId, int $userId): bool
    {
        $sql = "INSERT INTO project_users (project_id, user_id)
                VALUES (:project_id, :user_id)";

        return $this->execute($sql, [
            ':project_id' => $projectId,
            ':user_id'    => $userId,
        ]);
    }
}