<?php
namespace Src\Controllers;

use Src\Models\Project;
use Src\Models\ProjectUser;

class ProjectController
{
    protected $model;
    protected $projectUserModel;

    public function __construct()
    {
        session_start();
        $this->model            = new Project();
        $this->projectUserModel = new ProjectUser();
    }

    public function index(): void
    {
        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            header('Location: /login');
            exit;
        }

        $projects = $this->model->allByUser($userId);
        include __DIR__ . '/../views/projects.php';
    }

    public function save(): void
    {
        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            header('Location: /login');
            exit;
        }

        $rawId     = $_POST['project_id'] ?? '';
        $projectId = $rawId !== '' ? (int)$rawId : null;

        $data = [
            'user_id'      => $userId,
            'title'        => trim($_POST['title']),
            'description'  => trim($_POST['description']),
            'total_budget' => trim($_POST['total_budget']),
        ];

        if ($projectId !== null && $this->model->findByUser($projectId, $userId)) {
            $success = $this->model->update($projectId, $data);
        } else {
            $success = $this->model->create($data);
            if ($success) {
                // Link the user to the new project
                $newProjectId = (int)$this->model->getLastInsertId();
                $this->projectUserModel->create($newProjectId, $userId);
            }
        }

        if ($success) {
            header('Location: /projects');
            exit;
        }

        echo "Error saving project.";
        exit;
    }
}