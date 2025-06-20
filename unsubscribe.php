<?php
require_once __DIR__ . '/functions.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        if (unsubscribeEmail($email)) {
            $message = 'You have been unsubscribed successfully.';
        } else {
            $message = 'Email not found in our subscriptions.';
        }
    } else {
        $message = 'Invalid email format.';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Unsubscribe</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; }
        .message { padding: 10px; margin: 10px 0; border-radius: 4px; }
        .success { background-color: #e6f7e6; border: 1px solid #c3e6c3; }
        .error { background-color: #ffebee; border: 1px solid #ffcdd2; }
        form { margin-top: 20px; }
        input, button { padding: 8px; margin: 5px 0; }
        a { display: inline-block; margin-top: 20px; }
    </style>
</head>
<body>
    <h1>Unsubscribe from Updates</h1>
    
    <?php if ($message): ?>
        <div class="message <?= strpos($message, 'successfully') !== false ? 'success' : 'error' ?>">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>
    
    <form method="POST">
        <label for="email">Your Email Address:</label><br>
        <input type="email" id="email" name="email" required><br>
        <button type="submit">Unsubscribe</button>
    </form>
    
    <a href="index.php">Return to Home</a>
</body>
</html>
