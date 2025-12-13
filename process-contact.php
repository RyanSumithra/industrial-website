<?php
require_once 'includes/config.php';

// Start session
session_start();

// Only process POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: contact.php');
    exit;
}

// Enable error reporting for debugging (remove in production)
error_reporting(0);
ini_set('display_errors', 0);

// Sanitize input data
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

// Get and sanitize form data
$name = sanitize_input($_POST['name'] ?? '');
$email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$phone = sanitize_input($_POST['phone'] ?? '');
$company = sanitize_input($_POST['company'] ?? '');
$service = sanitize_input($_POST['service'] ?? '');
$message = sanitize_input($_POST['message'] ?? '');
$newsletter = isset($_POST['newsletter']) ? 1 : 0;
$honeypot = $_POST['website'] ?? ''; // Honeypot field

// Honeypot check (if bot fills this field, show success but don't process)
if (!empty($honeypot)) {
    header('Location: contact.php?success=1');
    exit;
}

// Validate required fields
$errors = [];

if (empty($name)) {
    $errors[] = 'Full name is required';
} elseif (strlen($name) < 2) {
    $errors[] = 'Name must be at least 2 characters';
}

if (empty($email)) {
    $errors[] = 'Email address is required';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Please enter a valid email address';
}

if (empty($message)) {
    $errors[] = 'Message is required';
} elseif (strlen($message) < 10) {
    $errors[] = 'Message must be at least 10 characters';
}

if (strlen($message) > 1000) {
    $errors[] = 'Message must be less than 1000 characters';
}

if (!empty($phone) && !preg_match('/^[\+]?[1-9][\d]{0,15}$/', str_replace([' ', '-', '(', ')'], '', $phone))) {
    $errors[] = 'Please enter a valid phone number';
}

// If there are errors, store them in session and redirect back
if (!empty($errors)) {
    $_SESSION['form_errors'] = $errors;
    $_SESSION['form_data'] = [
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'company' => $company,
        'service' => $service,
        'message' => $message,
        'newsletter' => $newsletter
    ];
    header('Location: contact.php?error=1');
    exit;
}

// Prepare email content
$to = SITE_EMAIL;
$subject = "New Contact Form Submission: " . $name . " - " . date('Y-m-d H:i:s');
$email_content = "New Contact Form Submission\n";
$email_content .= "==========================\n\n";
$email_content .= "Name: " . $name . "\n";
$email_content .= "Email: " . $email . "\n";
$email_content .= "Phone: " . ($phone ?: 'Not provided') . "\n";
$email_content .= "Company: " . ($company ?: 'Not provided') . "\n";
$email_content .= "Service Interest: " . ($service ?: 'Not specified') . "\n";
$email_content .= "Newsletter Opt-in: " . ($newsletter ? 'Yes' : 'No') . "\n\n";
$email_content .= "Message:\n" . $message . "\n\n";
$email_content .= "---\n";
$email_content .= "Submitted: " . date('F j, Y, g:i a') . "\n";
$email_content .= "IP Address: " . $_SERVER['REMOTE_ADDR'] . "\n";

$headers = "From: " . SITE_NAME . " <" . SITE_EMAIL . ">\r\n";
$headers .= "Reply-To: " . $email . "\r\n";
$headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// Send email notification to site admin
$mail_sent = mail($to, $subject, $email_content, $headers);

// Send auto-reply to user if email is valid
if ($mail_sent && filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $auto_subject = "Thank you for contacting " . SITE_NAME;
    $auto_message = "Dear " . $name . ",\n\n";
    $auto_message .= "Thank you for contacting " . SITE_NAME . "!\n\n";
    $auto_message .= "We have received your message regarding \"" . ($service ?: 'your inquiry') . "\". ";
    $auto_message .= "Our team will review your request and get back to you within 24 hours.\n\n";
    $auto_message .= "Here's a summary of your submission:\n";
    $auto_message .= "- Name: " . $name . "\n";
    $auto_message .= "- Email: " . $email . "\n";
    if ($phone) $auto_message .= "- Phone: " . $phone . "\n";
    if ($company) $auto_message .= "- Company: " . $company . "\n";
    $auto_message .= "- Service: " . ($service ?: 'Not specified') . "\n\n";
    $auto_message .= "If you need immediate assistance, please call us at " . SITE_PHONE . ".\n\n";
    $auto_message .= "Best regards,\n";
    $auto_message .= SITE_NAME . " Team\n";
    $auto_message .= SITE_PHONE . "\n";
    $auto_message .= SITE_EMAIL . "\n";
    
    $auto_headers = "From: " . SITE_NAME . " <" . SITE_EMAIL . ">\r\n";
    $auto_headers .= "Reply-To: " . SITE_EMAIL . "\r\n";
    
    mail($email, $auto_subject, $auto_message, $auto_headers);
}

// Log submission to file (for backup)
$log_entry = "[" . date('Y-m-d H:i:s') . "] " . $_SERVER['REMOTE_ADDR'] . " | " . $email . " | " . $name . " | " . ($service ?: 'N/A') . "\n";
$log_file = 'contact_submissions.log';
file_put_contents($log_file, $log_entry, FILE_APPEND | LOCK_EX);

// Log to database (if database is set up)
// Uncomment and configure if you have a database
/*
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt = $pdo->prepare("INSERT INTO contact_submissions (name, email, phone, company, service, message, newsletter, ip_address, submitted_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->execute([$name, $email, $phone, $company, $service, $message, $newsletter, $_SERVER['REMOTE_ADDR']]);
} catch (PDOException $e) {
    // Log database error but don't show to user
    error_log("Database error: " . $e->getMessage());
}
*/

// Store in session for success message
$_SESSION['form_success'] = true;

// Redirect to success page
header('Location: contact.php?success=1');
exit;
?>