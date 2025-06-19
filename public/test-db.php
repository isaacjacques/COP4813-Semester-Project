<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Src\Config\Database;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$db = new Database();
$conn = $db->connect();

if ($conn) {
    echo "✅ Connected to MySQL database successfully!";
}