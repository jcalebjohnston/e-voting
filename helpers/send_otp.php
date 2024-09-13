<?php
session_start();

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

if (!isset($_SESSION['fetched_user']) || !$_SESSION['fetched_user']) {
    header("Location: kill.php");
    exit;
}

$arkesel_api_key = $_ENV['ARKESEL_API_KEY'];
$sender = $_ENV['ARKESEL_API_SENDER_ID'];
$urli = $_ENV['SMS_API_URL'];

header('Content-Type: application/json');

if (isset($_SESSION['phone'])) {
    $phoneNumber = $_SESSION['phone'];

    $otp = rand(100000, 999999);

    $_SESSION['otp'] = $otp;

    $message = "Your OTP for the Safety Awards voting is: $otp";
    
    $url = "$urli";
    $url .= '&api_key=' . urlencode($arkesel_api_key);
    $url .= '&to=' . urlencode($phoneNumber);
    $url .= '&from=' . urlencode($sender);
    $url .= '&sms=' . urlencode($message);

    $context = stream_context_create([
        'http' => [
            'method' => 'GET',
            'header' => 'Content-Type: application/x-www-form-urlencoded',
        ],
    ]);

    $response = file_get_contents($url, false, $context);

    if ($response === false) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to connect to SMS service']);
        exit;
    }

    $result = json_decode($response, true);

    if (isset($result['code']) && $result['code'] === 'ok') {
        $_SESSION['sent_otp'] = true;
        echo json_encode(['status' => 'success', 'otp_sent' => true]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to send OTP']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Phone number not found in session']);
}
