<?php
// process-card-request.php

if (file_exists('includes/config.php')) {
    require_once 'includes/config.php';
}

// -------------------- CONFIGURATION --------------------
define('SENDER_EMAIL', 'info@techasiamechatronics.com'); // Must be your Hostinger email
define('ADMIN_EMAIL', 'patilpouras145@gmail.com'); 
// -------------------------------------------------------

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: business-card.php');
    exit;
}

function sanitize($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

// 1. GET DATA
$name = sanitize($_POST['name'] ?? '');
$contact = sanitize($_POST['contact'] ?? '');
$email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$website = sanitize($_POST['website_url'] ?? '');
$address = sanitize($_POST['address'] ?? '');
$tagline = sanitize($_POST['tagline'] ?? '');

// 2. VALIDATION
$errors = [];
if (empty($name)) $errors[] = "Name is required.";
if (empty($contact)) $errors[] = "Contact number is required.";
if (empty($email)) $errors[] = "Email is required.";

if (!empty($errors)) {
    $_SESSION['card_errors'] = $errors;
    header('Location: business-card.php?error=1#requestForm');
    exit;
}

// 3. HANDLE FILE UPLOADS (Images)
$attachments = [];
$uploadDir = 'uploads/temp/'; // Ensure this folder exists and is writable
if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

// Function to handle single file upload
function handleUpload($fileInputName) {
    global $uploadDir;
    if (isset($_FILES[$fileInputName]) && $_FILES[$fileInputName]['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES[$fileInputName]['tmp_name'];
        $fileName = time() . '_' . basename($_FILES[$fileInputName]['name']);
        $targetPath = $uploadDir . $fileName;
        if (move_uploaded_file($tmpName, $targetPath)) {
            return $targetPath;
        }
    }
    return false;
}

$userImage = handleUpload('user_image');
$logoImage = handleUpload('company_logo');
$bgImage = handleUpload('bg_image');

// 4. PREPARE EMAIL
$subject = "New Digital Card Request: " . $name;

// Boundary for multipart email
$boundary = md5(time());

// Headers
$headers = "From: Card Request <" . SENDER_EMAIL . ">\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";

// Body
$message = "--$boundary\r\n";
$message .= "Content-Type: text/html; charset=UTF-8\r\n";
$message .= "Content-Transfer-Encoding: 7bit\r\n\r\n";

$message .= "
<html>
<body style='font-family: Arial, sans-serif;'>
  <h2>New Digital Business Card Order</h2>
  <p><strong>Name:</strong> $name</p>
  <p><strong>Contact:</strong> $contact</p>
  <p><strong>Email:</strong> $email</p>
  <p><strong>Website:</strong> $website</p>
  <p><strong>Address:</strong><br>" . nl2br($address) . "</p>
  <p><strong>Tagline/Services:</strong><br>" . nl2br($tagline) . "</p>
</body>
</html>
\r\n";

// Attach Files
function attachFile($filePath, $boundary) {
    if ($filePath && file_exists($filePath)) {
        $fileName = basename($filePath);
        $fileData = chunk_split(base64_encode(file_get_contents($filePath)));
        
        $msg = "--$boundary\r\n";
        $msg .= "Content-Type: application/octet-stream; name=\"$fileName\"\r\n";
        $msg .= "Content-Transfer-Encoding: base64\r\n";
        $msg .= "Content-Disposition: attachment; filename=\"$fileName\"\r\n\r\n";
        $msg .= $fileData . "\r\n";
        return $msg;
    }
    return "";
}

$message .= attachFile($userImage, $boundary);
$message .= attachFile($logoImage, $boundary);
$message .= attachFile($bgImage, $boundary);

$message .= "--$boundary--";

// 5. SEND
if (mail(ADMIN_EMAIL, $subject, $message, $headers, "-f".SENDER_EMAIL)) {
    // Cleanup temp files
    if($userImage) unlink($userImage);
    if($logoImage) unlink($logoImage);
    if($bgImage) unlink($bgImage);
    
    header('Location: business-card.php?success=1#requestForm');
} else {
    $_SESSION['card_errors'] = ["Server Error: Could not send request."];
    header('Location: business-card.php?error=1#requestForm');
}
exit;
?>