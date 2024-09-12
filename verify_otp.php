<?php
session_start();

header('Content-Type: application/json');

if (isset($_POST['otp'])) {
    $otp = $_POST['otp'];

    if (isset($_SESSION['otp']) && $otp == $_SESSION['otp']) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid OTP']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'OTP not provided']);
}