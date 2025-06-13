<?php
require __DIR__.'/../vendor/autoload.php';
(Dotenv\Dotenv::createImmutable(__DIR__.'/../'))->load();

session_start();
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// simple router
switch ($uri) {
  case '/':
  case '/home':
    App\Controllers\ProjectController::home();
    break;
  case '/login':
    App\Controllers\AuthController::showLogin();
    break;
  case '/auth/login':
    App\Controllers\AuthController::login($_POST);
    break;
  // add /budget, /stages, /invoices
  default:
    header("HTTP/1.0 404 Not Found");
    echo "404";
}