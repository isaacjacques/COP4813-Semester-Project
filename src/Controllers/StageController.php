<?php
namespace Src\Controllers;

use Src\Models\Stage;

class StageController
{
    protected $model;

    public function __construct()
    {
        session_start();
        $this->model = new Stage();
    }

    public function index(): void
    {
        $userId    = $_SESSION['user_id'] ?? null;
        $projectId = $_SESSION['project_id'] ?? null;
        if (!$userId || !$projectId) {
            header('Location: /home');
            exit;
        }

        $stages = $this->model->allByProject($projectId);
        include __DIR__ . '/../views/stages.php';
    }

    public function save(): void
    {
        $userId    = $_SESSION['user_id'] ?? null;
        $projectId = $_SESSION['project_id'] ?? null;
        if (!$userId || !$projectId) {
            header('Location: /home');
            exit;
        }

        $rawId    = $_POST['stage_id'] ?? '';
        $stageId  = $rawId !== '' ? (int)$rawId : null;
        $data     = [
            'project_id' => $projectId,
            'stage_id'   => $stageId,
            'name'       => trim($_POST['name']),
            'allocated'  => trim($_POST['allocated']),
            'deadline'   => trim($_POST['deadline']),
            'color'      => trim($_POST['color'] ?? '#D0E6A5'),
        ];

        if ($stageId !== null && $this->model->findByProject($stageId, $projectId)) {
            $success = $this->model->update($stageId, $data);
        } else {
            $success = $this->model->create($data);
        }

        if ($success) {
            header('Location: /stages');
            exit;
        }

        echo "Error saving stage.";
        exit;
    }
}