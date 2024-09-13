<?php

/**
 * Db connection
 */

 require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$host = $_ENV['DBHOST'];
$db = $_ENV['DBNAME'];
$user = $_ENV['DBUSER'];
$pass = $_ENV['DBPASS'];
$db_port = $_ENV['DBPORT'] ?? '3306';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}