<?php
session_start();

if (!isset($_SESSION['fetched_user']) || !$_SESSION['fetched_user'] || !isset($_SESSION['sent_otp']) || !$_SESSION['sent_otp'] || !isset($_SESSION['otp_verified']) || !$_SESSION['otp_verified'] || !isset($_SESSION['vote_submitted']) || !$_SESSION['vote_submitted']) {
    header("Location: kill.php");
    exit;
}

// $safety_section = $_SESSION['safety_section'];

require '../config/db.php';

$stmt = $pdo->query("SELECT vote_option, COUNT(*) as vote_count FROM votes GROUP BY vote_option");
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

$data = [
    'award1' => 0,
    'award2' => 0,
    'award3' => 0,
    'award4' => 0,
];

foreach ($results as $result) {
    $data[$result['vote_option']] = $result['vote_count'];
}

echo json_encode($data);