<?php
// process-contact.php

// 1. Load Config
if (file_exists('includes/config.php')) {
    require_once 'includes/config.php';
}

// -------------------- CRITICAL EMAIL SETTINGS --------------------
// [A] SENDER: Must be an email created in your Hostinger Panel
// If this doesn't match your domain, Hostinger will block it.
define('SENDER_EMAIL', 'info@techasiamechatronics.com'); 

// [B] RECIPIENT: Your personal email where you want to read messages
define('ADMIN_EMAIL', 'patilpouras145@gmail.com'); 
// ------------------------------------------------------------------

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

// 5. Retrieve User Data
$name     = sanitize_input($_POST['name'] ?? '');
$userEmail = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL); // <--- THIS IS THE USER'S INPUT
$message  = sanitize_input($_POST['message'] ?? '');
$honeypot = $_POST['website'] ?? ''; 

// 6. Bot Check
if (!empty($honeypot)) {
    header('Location: contact.php?success=1');
    exit;
}

// 7. Validation
$errors = [];
if (empty($name) || strlen($name) < 2) $errors[] = "Name is required.";
if (empty($userEmail) || !filter_var($userEmail, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required.";
if (empty($message) || strlen($message) < 5) $errors[] = "Message is too short.";

if (!empty($errors)) {
    $_SESSION['form_errors'] = $errors;
    $_SESSION['form_data'] = $_POST;
    header('Location: contact.php?error=1');
    exit;
}

// 8. PREPARE EMAIL TO ADMIN (YOU)

$subject = "New Inquiry from: " . $name;

// HTML Design
$body = "
<html>
<head>
  <style>
    body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; }
    .container { max-width: 600px; background: #fff; padding: 30px; border-radius: 8px; border: 1px solid #ddd; }
    .header { border-bottom: 2px solid #ff3333; padding-bottom: 15px; margin-bottom: 20px; }
    h2 { margin: 0; color: #333; }
    .field { margin-bottom: 10px; }
    .label { font-weight: bold; color: #555; width: 80px; display: inline-block; }
    .msg-box { background: #f9f9f9; padding: 15px; border-left: 4px solid #ff3333; margin-top: 20px; color: #333; }
  </style>
</head>
<body>
  <div class='container'>
    <div class='header'>
        <h2>New Website Message</h2>
    </div>
    
    <div class='field'><span class='label'>Name:</span> $name</div>
    <div class='field'><span class='label'>Email:</span> $userEmail</div>
    <div class='field'><span class='label'>Date:</span> " . date('d M Y, h:i A') . "</div>
    
    <div class='msg-box'>
        " . nl2br($message) . "
    </div>
  </div>
</body>
</html>
";

// --- HEADERS EXPLAINED ---
$headers  = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";

// 1. FROM: Must be YOUR server email (to pass spam filters)
$headers .= "From: Website Contact <" . SENDER_EMAIL . ">" . "\r\n";

// 2. REPLY-TO: This is the USER'S email. When you click reply, it goes here.
$headers .= "Reply-To: " . $userEmail . "\r\n";

$headers .= "X-Mailer: PHP/" . phpversion();

// 9. Send Email
// The "-f" parameter forces the 'Envelope Sender' to be your domain email. Critical for Hostinger.
if(mail(ADMIN_EMAIL, $subject, $body, $headers, "-f".SENDER_EMAIL)) {
    
    // Optional: Send Auto-Reply to User
    $autoSubject = "We received your message - TechAsia";
    $autoBody = "Hi $name,\n\nThanks for reaching out. We have received your inquiry and will respond shortly.\n\nBest,\nTechAsia Team";
    $autoHeaders = "From: TechAsia <" . SENDER_EMAIL . ">\r\n";
    @mail($userEmail, $autoSubject, $autoBody, $autoHeaders, "-f".SENDER_EMAIL);
    
    header('Location: contact.php?success=1');
} else {
    // Log error if it fails
    error_log("Mail Failed to: " . ADMIN_EMAIL);
    $_SESSION['form_errors'] = ["Server Error: Could not send email. Try again later."];
    header('Location: contact.php?error=1');
}
exit;
?>