<?php
session_start();

$arkesel_api_key = 'YOUR_SMS_API_KEY';

header('Content-Type: application/json');

if (isset($_SESSION['phone'])) {
    $phoneNumber = $_SESSION['phone'];

    $otp = rand(100000, 999999);

    $_SESSION['otp'] = $otp;

    $message = "Your OTP for the Safety Awards voting is: $otp";
    $sender = 'YOUR__SMS_SENDER_ID';

    $url = "https://sms.arkesel.com/sms/api?action=send-sms";
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
        echo json_encode(['status' => 'success', 'otp_sent' => true]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to send OTP']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Phone number not found in session']);
}
