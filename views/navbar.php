<?php
use Src\Controllers\HomeController;

if (!isset($projects)) {
    $controller = new \Src\Controllers\HomeController();
    $userId     = $_SESSION['user_id'] ?? 0;
    $projects   = $controller->getUserProjects($userId);
}

if (isset($_GET['project_id'])) {
    $_SESSION['project_id'] = (int)$_GET['project_id'];
} elseif (!isset($_SESSION['project_id']) && !empty($projects)) {
    $_SESSION['project_id'] = $projects[0]['project_id'];
}

$project_id = $_SESSION['project_id'] ?? null;

$currentProjectName = 'Select Project';
foreach ($projects as $proj) {
    if ($proj['project_id'] == $project_id) {
        $currentProjectName = $proj['title'];
        break;
    }
}
?>
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
<div class="container">
    <a class="navbar-brand d-flex align-items-center" href="home">
    <img src="assets/images/logo.svg" alt="Wizard" width="30" height="30" class="me-2">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
            aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNav">
    <ul class="navbar-nav ms-3">
        <li class="nav-item">
        <a class="nav-link active" href="home">Home</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="budget">Budget</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="stages">Stages</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="invoices">Invoices</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="admin">Admin</a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="projectDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <?php echo htmlspecialchars($currentProjectName); ?>
            </a>
            <ul class="dropdown-menu" aria-labelledby="projectDropdown">
                <?php foreach ($projects as $proj): ?>
                    <li>
                        <a class="dropdown-item <?php echo ($proj['project_id'] == $project_id) ? 'active' : ''; ?>" href="?project_id=<?php echo $proj['project_id']; ?>">
                            <?php echo htmlspecialchars($proj['title']); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </li>
    </ul>
    <div class="ms-auto">
        <a href="logout" class="btn btn-logout">Log Out</a>
    </div>
    </div>
</div>
</nav>
<?php if (!isset($_GET['project_id']) && isset($project_id)): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var url = new URL(window.location.href);
        url.searchParams.set('project_id', <?php echo $project_id; ?>);
        window.history.replaceState({}, '', url);
    });
</script>
<?php endif; ?>