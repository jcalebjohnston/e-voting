<?php
session_start();

if (!isset($_SESSION['fetched_user']) || !$_SESSION['fetched_user'] || !isset($_SESSION['sent_otp']) || !$_SESSION['sent_otp'] || !isset($_SESSION['otp_verified']) || !$_SESSION['otp_verified']) {
    header("Location: kill.php");
    exit;
}

require '../config/db.php';

if (isset($_POST['vote']) && isset($_SESSION['badge_number'])) {
    $vote = $_POST['vote'];
    $badgeNumber = $_SESSION['badge_number'];

    $stmt = $pdo->prepare("SELECT * FROM votes WHERE badge_number = :badge_number");
    $stmt->execute(['badge_number' => $badgeNumber]);
    if ($stmt->rowCount() > 0) {
        echo json_encode(['status' => 'error', 'message' => 'You have already voted!']);
        exit;
    }

    $stmt2 = $pdo->prepare('INSERT INTO votes (badge_number, vote_option) VALUES (:badge_number, :vote)');
    $stmt2->execute(['badge_number' => $badgeNumber, 'vote' => $vote]);

    if ($stmt2->rowCount()) {
        $_SESSION['vote_submitted'] = true;
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to submit vote']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}