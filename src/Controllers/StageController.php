<?php
namespace Src\Controllers;

use Src\Models\Stage;
use Src\Models\Project;

class StageController extends BaseController
{
    protected Stage   $stageModel;
    protected Project $projectModel;
    public function __construct()
    {
        parent::__construct();
        $this->stageModel   = new Stage();
        $this->projectModel = new Project();
    }

    public function index(): void
    {
        if (isset($_GET['project_id'])) {
            $_SESSION['project_id'] = (int)$_GET['project_id'];
        }

        $userId    = $_SESSION['user_id']    ?? null;
        $projectId = $_SESSION['project_id'] ?? null;
        if (!$userId || !$projectId) {
            header('Location: /home');
            exit;
        }

        $projects = $this->projectModel->allByUser($userId);
        $stages   = $this->stageModel->allByProject($projectId);

        if (!empty($_GET['ajax'])) {
            header('Content-Type: application/json');
            echo json_encode($stages);
            exit;
        }

        include __DIR__ . '/../Views/stages.php';
    }

    public function save(): void
    {
        $userId    = $_SESSION['user_id']    ?? null;
        $projectId = $_SESSION['project_id'] ?? null;
        if (!$userId || !$projectId) {
            header('Location: /home');
            exit;
        }

        $rawId   = $_POST['stage_id'] ?? '';
        $stageId = $rawId !== '' ? (int)$rawId : null;
        $data    = [
            'project_id' => $projectId,
            'stage_id'   => $stageId,
            'name'       => trim($_POST['name']),
            'allocated'  => trim($_POST['allocated']),
            'deadline'   => trim($_POST['deadline']),
            'color'      => trim($_POST['color'] ?? '#D0E6A5'),
        ];

        if ($stageId !== null && $this->stageModel->findByProject($stageId, $projectId)) {
            $success = $this->stageModel->update($stageId, $data);
        } else {
            $success = $this->stageModel->create($data);
        }

        if ($success) {
            header('Location: /stages');
            exit;
        }

        echo "Error saving stage.";
        exit;
    }
}