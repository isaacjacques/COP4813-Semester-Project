<?php

require __DIR__ . '/../vendor/autoload.php';

use Src\Controllers\HomeController;
use Src\Controllers\AuthController;
use Src\Controllers\BudgetController;
use Src\Controllers\InvoiceController;
use Src\Controllers\StageController;
use Src\Controllers\RegisterController;
use Src\Controllers\AdminController;
use Src\Controllers\ProjectController;


$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
switch ($uri) {
    case '/':
        (new HomeController())->index();
        break;

    case '/home':
        (new HomeController())->index();
        break;

    case '/budget':
        (new BudgetController())->index();
        break;

    case '/invoices':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            (new InvoiceController())->save();
        } else {
            (new InvoiceController())->index();
        }
        break;

    case '/stages':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            (new StageController())->save();
        } else {
            (new StageController())->index();
        }
        break;

    case '/projects':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            (new ProjectController())->save();
        } else {
            (new ProjectController())->index();
        }
        break;

    case '/login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            (new AuthController())->handleLogin();
        } else {
            (new AuthController())->showLoginForm();
        }
        break;
    
    case '/register':
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['register'])) {
            (new RegisterController())->handleRegistration();
        } else {
            (new RegisterController())->showForm();
        }
        break;

    case '/logout':
        (new AuthController())->logout();
        break;

    case '/admin':
        (new AdminController())->index();
        break;

    case '/admin/users':
        (new AdminController())->manageUsers();
        break;

    case '/admin/assignUser':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            (new AdminController())->assignUser();
        }
        break;
        
    case '/admin/user/view':
        (new AdminController())->viewUser();
         break;
        
    case '/admin/user/update':
        (new AdminController())->updateUser();
        break;

    case '/admin/project_overview':
        (new AdminController())->projectOverview();
        break;

    case '/admin/deleteProject':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            (new AdminController())->deleteProject($_POST);
        }
        break;

    case '/admin/analytics':
        (new AdminController())->analytics();
        break;

    case '/admin/analytics/data':
        (new AdminController())->analyticsData();
        break;

    default:
        http_response_code(404);
        echo "404 - Page Not Found";
        break;
}
?>