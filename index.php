<?php
require_once __DIR__ . '/functions.php';

session_start();

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['code'])) {
    $userCode = filter_input(INPUT_POST, 'code', FILTER_SANITIZE_STRING);
    $email = $_SESSION['email'] ?? '';
    
    if (!empty($email) && verifyCode($email, $userCode)) {
        if (registerEmail($email)) {
            $message = 'Thank you for subscribing! You will now receive GitHub updates.';
        } else {
            $message = 'This email is already registered.';
        }
    } else {
        $message = 'Invalid verification code. Please try again.';
    }
    
    unset($_SESSION['email']);
} else {
    header('Location: index.php');
    exit;
}
