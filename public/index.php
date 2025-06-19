<?php
require __DIR__ . '/../vendor/autoload.php';

use Src\Controllers\HomeController;
use Src\Controllers\AuthController;
use Src\Controllers\BudgetController;
use Src\Controllers\InvoiceController;
use Src\Controllers\StageController;

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
        (new InvoiceController())->index();
        break;

    case '/stages':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            (new StageController())->save();
        } else {
            (new StageController())->index();
        }
        break;

    case '/login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            (new AuthController())->handleLogin();
        } else {
            (new AuthController())->showLoginForm();
        }
        break;
        
    case '/logout':
        (new AuthController())->logout();
        break;

    default:
        http_response_code(404);
        echo "404 - Page Not Found";
        break;
}
?>