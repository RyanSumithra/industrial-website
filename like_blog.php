<?php
include 'includes/db.php';

header('Content-Type: application/json');

if (!isset($_POST['blog_id'])) {
    echo json_encode(['status' => 'error']);
    exit;
}

$blog_id = (int)$_POST['blog_id'];
$user_ip = $_SERVER['REMOTE_ADDR'];

// Check if already liked
$check = $conn->query("SELECT id FROM blog_likes WHERE blog_id=$blog_id AND user_ip='$user_ip'");

if ($check->num_rows > 0) {
    // UNLIKE
    $conn->query("DELETE FROM blog_likes WHERE blog_id=$blog_id AND user_ip='$user_ip'");
    $conn->query("UPDATE blogs SET likes_count = likes_count - 1 WHERE id=$blog_id");

    $count = $conn->query("SELECT likes_count FROM blogs WHERE id=$blog_id")->fetch_assoc()['likes_count'];
    echo json_encode(['liked' => false, 'count' => $count]);
} else {
    // LIKE
    $conn->query("INSERT INTO blog_likes (blog_id, user_ip) VALUES ($blog_id, '$user_ip')");
    $conn->query("UPDATE blogs SET likes_count = likes_count + 1 WHERE id=$blog_id");

    $count = $conn->query("SELECT likes_count FROM blogs WHERE id=$blog_id")->fetch_assoc()['likes_count'];
    echo json_encode(['liked' => true, 'count' => $count]);
}
