<?php
namespace Src\Controllers;

class HomeController {
    public function index() {
        session_start();

        if (isset($_SESSION['user_id']) && $_SESSION['user_id'] !== null) {
            //User is logged in, show home dashboard
            $this->loadView('home', [
                'user' => $this->getUserById($_SESSION['user_id'])
            ]);
        } else {
            //User is not logged in, show public welcome page
            $this->loadView('welcome');
        }
    }

    private function loadView(string $viewName, array $data = []) {
        extract($data);
        require __DIR__ . "/../../views/{$viewName}.php";
    }

    private function getUserById($id) {
        // todo
    }
}
