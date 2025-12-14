<?php
// process-contact.php

// 1. Load Configuration
require_once 'includes/config.php';

// 2. Start Session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 3. Security: Allow Only POST Requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: contact.php');
    exit;
}

// 4. Input Sanitization Helper
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

// 5. Retrieve & Sanitize Data
$name       = sanitize_input($_POST['name'] ?? '');
$email      = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$message    = sanitize_input($_POST['message'] ?? '');
$honeypot   = $_POST['website'] ?? ''; // Hidden field for bots

// 6. Honeypot Check (Bot Protection)
// If the hidden 'website' field is filled, it's a bot.
// We redirect to success page but DO NOT send the email.
if (!empty($honeypot)) {
    header('Location: contact.php?success=1');
    exit;
}

// 7. Validation
$errors = [];

if (empty($name) || strlen($name) < 2) {
    $errors[] = "Please provide a valid name.";
}

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Please provide a valid email address.";
}

if (empty($message) || strlen($message) < 10) {
    $errors[] = "Message must be at least 10 characters long.";
}

// If errors exist, redirect back with error flag
if (!empty($errors)) {
    $_SESSION['form_errors'] = $errors;
    $_SESSION['form_data'] = $_POST; // Preserve input
    header('Location: contact.php?error=1');
    exit;
}

// 8. Prepare Emails

// --- A. Email to Admin ---
$toAdmin = SITE_EMAIL; 
$subjectAdmin = "New Contact: " . $name . " - " . SITE_NAME;

$bodyAdmin = "New Inquiry Received\n";
$bodyAdmin .= "====================\n\n";
$bodyAdmin .= "Name: " . $name . "\n";
$bodyAdmin .= "Email: " . $email . "\n";
$bodyAdmin .= "Date: " . date('F j, Y, g:i a') . "\n";
$bodyAdmin .= "IP: " . $_SERVER['REMOTE_ADDR'] . "\n\n";
$bodyAdmin .= "Message:\n";
$bodyAdmin .= $message . "\n";

// Headers for Admin Email
// IMPORTANT: 'From' should be a valid email on your server (e.g., noreply@yourdomain.com) 
// to prevent being marked as spam. If not available, use SITE_EMAIL.
$fromEmail = defined('SITE_EMAIL') ? SITE_EMAIL : 'noreply@' . $_SERVER['HTTP_HOST'];

$headersAdmin = "From: " . SITE_NAME . " <" . $fromEmail . ">\r\n";
$headersAdmin .= "Reply-To: " . $email . "\r\n";
$headersAdmin .= "X-Mailer: PHP/" . phpversion();

// Send to Admin
$mailSent = mail($toAdmin, $subjectAdmin, $bodyAdmin, $headersAdmin);


// --- B. Auto-Reply to User (Only if admin mail sent) ---
if ($mailSent) {
    $subjectUser = "Thank you for contacting " . SITE_NAME;
    
    $bodyUser = "Dear " . $name . ",\n\n";
    $bodyUser .= "Thank you for reaching out to " . SITE_NAME . ".\n";
    $bodyUser .= "We have received your message and our team will review it shortly.\n\n";
    $bodyUser .= "Best regards,\n";
    $bodyUser .= SITE_NAME . " Team\n";
    
    $headersUser = "From: " . SITE_NAME . " <" . $fromEmail . ">\r\n";
    $headersUser .= "Reply-To: " . $toAdmin . "\r\n";
    $headersUser .= "X-Mailer: PHP/" . phpversion();

    // Send Auto-reply (use @ to suppress errors if user email is invalid)
    @mail($email, $subjectUser, $bodyUser, $headersUser);
}

// 9. Logging (Backup)
$logEntry = "[" . date('Y-m-d H:i:s') . "] IP: " . $_SERVER['REMOTE_ADDR'] . " | Email: " . $email . " | Name: " . $name . "\n";
$logFile = 'contact_submissions.log';
file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);

// 10. Success Redirect
header('Location: contact.php?success=1');
exit;
?>