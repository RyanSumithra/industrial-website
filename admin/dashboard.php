<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
include '../includes/db.php';

// Handle Product Upload
if (isset($_POST['add_product'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $price = $conn->real_escape_string($_POST['price']);
    $desc = $conn->real_escape_string($_POST['description']);
    
    // Image Upload
    $target_dir = "../uploads/";
    if (!is_dir($target_dir)) mkdir($target_dir); // Create folder if not exists
    $image = time() . '_' . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir . $image);

    $sql = "INSERT INTO products (title, price, description, image) VALUES ('$title', '$price', '$desc', '$image')";
    $conn->query($sql);
    $msg = "Product Added Successfully!";
}

// Handle Blog Upload
if (isset($_POST['add_blog'])) {
    $title = $conn->real_escape_string($_POST['blog_title']);
    $content = $conn->real_escape_string($_POST['blog_content']);
    
    $target_dir = "../uploads/";
    $image = time() . '_' . basename($_FILES["blog_image"]["name"]);
    move_uploaded_file($_FILES["blog_image"]["tmp_name"], $target_dir . $image);

    $sql = "INSERT INTO blogs (title, content, image) VALUES ('$title', '$content', '$image')";
    $conn->query($sql);
    $msg = "Blog Post Published!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - IndustrialTech</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        .dashboard-container { max-width: 1000px; margin: 50px auto; padding: 0 20px; }
        .admin-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; border-bottom: 1px solid #ddd; padding-bottom: 1rem; }
        .grid-forms { display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; }
        .admin-card { background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .alert { background: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 20px; text-align: center; }
        @media(max-width: 768px) { .grid-forms { grid-template-columns: 1fr; } }
    </style>
</head>
<body style="background: var(--gray-100);">

    <div class="dashboard-container">
        <div class="admin-header">
            <h2>Admin Dashboard</h2>
            <a href="logout.php" class="btn btn-secondary">Logout</a>
        </div>

        <?php if(isset($msg)) echo "<div class='alert'>$msg</div>"; ?>

        <div class="grid-forms">
            <div class="admin-card">
                <h3>Add New Product</h3>
                <br>
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Product Name</label>
                        <input type="text" name="title" required>
                    </div>
                    <div class="form-group">
                        <label>Price ($)</label>
                        <input type="number" step="0.01" name="price" required>
                    </div>
                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" name="image" required>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" rows="3"></textarea>
                    </div>
                    <button type="submit" name="add_product" class="btn btn-primary">Add Product</button>
                </form>
            </div>

            <div class="admin-card">
                <h3>Publish Blog Post</h3>
                <br>
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Blog Title</label>
                        <input type="text" name="blog_title" required>
                    </div>
                    <div class="form-group">
                        <label>Featured Image</label>
                        <input type="file" name="blog_image" required>
                    </div>
                    <div class="form-group">
                        <label>Content</label>
                        <textarea name="blog_content" rows="6" required></textarea>
                    </div>
                    <button type="submit" name="add_blog" class="btn btn-primary">Publish Blog</button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>