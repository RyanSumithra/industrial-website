<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) { header("Location: login.php"); exit; }
include '../includes/db.php';

if (!isset($_GET['id'])) { header("Location: products.php"); exit; }
$id = $conn->real_escape_string($_GET['id']);

// Fetch Existing Data
$sql = "SELECT * FROM products WHERE id = $id";
$result = $conn->query($sql);
$product = $result->fetch_assoc();

if (isset($_POST['update_product'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $price = $conn->real_escape_string($_POST['price']);
    $desc = $conn->real_escape_string($_POST['description']);
    
    // Check if new image uploaded
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "../uploads/";
        $filename = time() . '_' . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir . $filename);
        // Delete old image
        if(file_exists("../uploads/".$product['image'])) unlink("../uploads/".$product['image']);
        // Update query with image
        $update = "UPDATE products SET title='$title', price='$price', description='$desc', image='$filename' WHERE id=$id";
    } else {
        // Update query without image
        $update = "UPDATE products SET title='$title', price='$price', description='$desc' WHERE id=$id";
    }

    if($conn->query($update)) {
        header("Location: products.php"); // Redirect back to list
        exit;
    } else {
        $error = "Update Failed: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        :root { --primary-red: #ff3333; --bg-black: #050505; --card-bg: #111; --border: #2a2a2a; color:white;}
        body { background: var(--bg-black); font-family: 'Inter', sans-serif; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; }
        .admin-card { background: var(--card-bg); border: 1px solid var(--border); padding: 30px; border-radius: 12px; }
        input, textarea { width: 100%; background: #000; border: 1px solid #333; color: white; padding: 12px; margin-bottom: 15px; border-radius: 6px; box-sizing: border-box; }
        label { display: block; margin-bottom: 5px; color: #888; font-weight: bold; }
        .btn-submit { width: 100%; background: var(--primary-red); color: white; border: none; padding: 14px; border-radius: 6px; font-weight: 700; cursor: pointer; }
    </style>
</head>
<body>
    <div class="container">
        <h2 style="border-bottom: 1px solid #333; padding-bottom: 15px;">Edit Product</h2>
        <div class="admin-card">
            <form method="POST" enctype="multipart/form-data">
                <label>Product Name</label>
                <input type="text" name="title" value="<?php echo htmlspecialchars($product['title']); ?>" required>
                
                <label>Price</label>
                <input type="number" step="0.01" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
                
                <label>Description</label>
                <textarea name="description" rows="5"><?php echo htmlspecialchars($product['description']); ?></textarea>
                
                <label>Update Image (Leave empty to keep current)</label>
                <input type="file" name="image">
                <p style="color:#666; font-size:0.8rem;">Current: <?php echo $product['image']; ?></p>
                
                <button type="submit" name="update_product" class="btn-submit">Save Changes</button>
                <a href="products.php" style="display:block; text-align:center; margin-top:15px; color:#888; text-decoration:none;">Cancel</a>
            </form>
        </div>
    </div>
</body>
</html>