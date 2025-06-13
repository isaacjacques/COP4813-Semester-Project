<?php
require __DIR__ . '/../vendor/autoload.php';

use Src\Controllers\HomeController;

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($uri) {
    case '/':
    case '/index.php':
        (new HomeController())->index();
        break;
    default:
        header("HTTP/1.0 404 Not Found");
        echo "404 Not Found";
        break;
}
?>