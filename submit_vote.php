<?php
session_start();

require 'db.php';

if (isset($_POST['vote']) && isset($_SESSION['badge_number'])) {
    $vote = $_POST['vote'];
    $badgeNumber = $_SESSION['badge_number'];

    $stmt = $pdo->prepare('INSERT INTO votes (badge_number, vote_option) VALUES (:badge_number, :vote)');
    $stmt->execute(['badge_number' => $badgeNumber, 'vote' => $vote]);

    if ($stmt->rowCount()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to submit vote']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}