<?php
require '../config/db.php';
session_start();

if (isset($_POST['badgeNumber'])) {
    $badgeNumber = $_POST['badgeNumber'];

    if (!preg_match('/^0\d{5}$/', $badgeNumber)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid badge number format']);
        exit;
    }

    $stmt = $pdo->prepare("SELECT * FROM votes WHERE badge_number = :badge_number");
    $stmt->execute(['badge_number' => $badgeNumber]);
    if ($stmt->rowCount() > 0) {
        echo json_encode(['status' => 'error', 'message' => 'You have already voted!']);
        exit;
    }

    $stmt = $pdo->prepare("SELECT name, safety_section, department, phone FROM users WHERE badge_number = :badge_number");
    $stmt->execute(['badge_number' => $badgeNumber]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['badge_number'] = $badgeNumber;
        $_SESSION['name'] = $user['name'];
        $_SESSION['safety_section'] = $user['safety_section'];
        $_SESSION['department'] = $user['department'];
        $_SESSION['phone'] = $user['phone'];
        $_SESSION['fetched_user'] = true;

        echo json_encode(['status' => 'success', 'user' => $user]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Badge number not found']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No badge number provided']);
}