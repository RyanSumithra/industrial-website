<?php
session_start();
require_once 'includes/config.php';
require_once 'includes/db.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

// Check if ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid inquiry ID']);
    exit;
}

$id = (int)$_GET['id'];

// Fetch inquiry from database
$stmt = $conn->prepare("SELECT * FROM inquiries WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'Inquiry not found']);
    exit;
}

$inquiry = $result->fetch_assoc();

// Mark as read
$updateStmt = $conn->prepare("UPDATE inquiries SET is_read = 1 WHERE id = ?");
$updateStmt->bind_param("i", $id);
$updateStmt->execute();
$updateStmt->close();

// Return inquiry data
echo json_encode([
    'success' => true,
    'id' => $inquiry['id'],
    'name' => htmlspecialchars($inquiry['name']),
    'email' => htmlspecialchars($inquiry['email']),
    'product' => $inquiry['product'] ? htmlspecialchars($inquiry['product']) : null,
    'message' => nl2br(htmlspecialchars($inquiry['message'])),
    'date' => date('F j, Y \a\t g:i A', strtotime($inquiry['submitted_at'])),
    'ip_address' => $inquiry['ip_address'],
    'is_read' => $inquiry['is_read']
]);

$stmt->close();
?>