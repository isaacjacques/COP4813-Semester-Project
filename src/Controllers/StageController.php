<?php
namespace Src\Controllers;
use Src\Config\Database;
use PDO;

class StageController
{

    public function index()
    {
        $db = new Database();
        $conn = $db->connect();

        $stmt = $conn->prepare(
            "SELECT 
                name, 
                budget AS allocated, 
                deadline, 
                color 
             FROM stages 
             ORDER BY deadline ASC"
        );
        $stmt->execute();
        $stages = $stmt->fetchAll(PDO::FETCH_ASSOC);

        include __DIR__ . '/../../views/stages.php';
    }


    public function save()
    {
        // TODO: Update/Insert stage changes to database
        header('Location: /public/index.php?route=stages');
        exit;
    }
}
