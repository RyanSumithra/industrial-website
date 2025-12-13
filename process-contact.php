<?php
require_once 'includes/config.php';

// Only process POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: contact.php');
    exit;
}

// Sanitize input data
$name = htmlspecialchars(trim($_POST['name'] ?? ''));
$email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
$company = htmlspecialchars(trim($_POST['company'] ?? ''));
$service = htmlspecialchars(trim($_POST['service'] ?? ''));
$message = htmlspecialchars(trim($_POST['message'] ?? ''));

// Validate required fields
if (empty($name) || empty($email) || empty($message)) {
    header('Location: contact.php?error=1');
    exit;
}

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: contact.php?error=1');
    exit;
}

// Here you would typically:
// 1. Save to database
// 2. Send email notification
// 3. Send auto-reply to user

// Example: Send email (configure your mail server first)
/*
$to = SITE_EMAIL;
$subject = "New Contact Form Submission from " . $name;
$email_message = "Name: $name\n";
$email_message .= "Email: $email\n";
$email_message .= "Phone: $phone\n";
$email_message .= "Company: $company\n";
$email_message .= "Service: $service\n\n";
$email_message .= "Message:\n$message";

$headers = "From: $email\r\n";
$headers .= "Reply-To: $email\r\n";

mail($to, $subject, $email_message, $headers);
*/

// For now, just redirect with success message
header('Location: contact.php?success=1');
exit;
?>