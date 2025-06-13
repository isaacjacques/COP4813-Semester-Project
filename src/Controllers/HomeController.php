<?php
namespace Src\Controllers;

class HomeController {
    public function index() {
        include __DIR__ . '/../../views/welcome.php';
    }
}
?>
