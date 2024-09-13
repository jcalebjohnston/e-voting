<?php
session_start();

if (!isset($_SESSION['fetched_user']) || !$_SESSION['fetched_user'] || !isset($_SESSION['sent_otp']) || !$_SESSION['sent_otp']) {
    header("Location: kill.php");
    exit;
}

header('Content-Type: application/json');

if (isset($_POST['otp'])) {
    $otp = $_POST['otp'];

    if (isset($_SESSION['otp']) && $otp == $_SESSION['otp']) {
        $_SESSION['otp_verified'] = true;
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid OTP']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'OTP not provided']);
}