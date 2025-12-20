<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) { header('Location: login.php'); exit; }

require_once '../includes/config.php';
require_once '../includes/db.php';

// Build Query based on GET params (Filters)
$where = [];
if (!empty($_GET['s'])) {
    $s = $conn->real_escape_string($_GET['s']);
    $where[] = "(name LIKE '%$s%' OR email LIKE '%$s%' OR message LIKE '%$s%')";
}
if (!empty($_GET['status'])) {
    $where[] = "status = '" . $conn->real_escape_string($_GET['status']) . "'";
}
if (!empty($_GET['type'])) {
    $where[] = ($_GET['type'] === 'product') ? "product_name != ''" : "product_name = ''";
}

$sql_where = !empty($where) ? "WHERE " . implode(' AND ', $where) : "";
$sql = "SELECT id, name, email, phone, product_name, message, status, created_at FROM inquiries $sql_where ORDER BY created_at DESC";
$result = $conn->query($sql);

// Headers for Download
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="inquiries_export_' . date('Y-m-d') . '.csv"');

// Open Output Stream
$output = fopen('php://output', 'w');

// Add Column Headers
fputcsv($output, ['ID', 'Name', 'Email', 'Phone', 'Product Interest', 'Message', 'Status', 'Date']);

// Add Rows
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, $row);
    }
}

fclose($output);
exit;
?>