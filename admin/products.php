<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) { header("Location: login.php"); exit; }
include '../includes/db.php';

$msg = "";
$msg_type = "";

// --- DELETE LOGIC ---
if (isset($_GET['delete'])) {
    $id = $conn->real_escape_string($_GET['delete']);
    // Get image to unlink
    $query = $conn->query("SELECT image FROM products WHERE id = $id");
    if ($row = $query->fetch_assoc()) {
        if(file_exists("../uploads/".$row['image'])) unlink("../uploads/".$row['image']);
    }
    $conn->query("DELETE FROM products WHERE id = $id");
    $msg = "Product Deleted!";
    $msg_type = "success";
}

// --- CREATE LOGIC ---
if (isset($_POST['add_product'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $price = $conn->real_escape_string($_POST['price']);
    $desc = $conn->real_escape_string($_POST['description']);
    $target_dir = "../uploads/";
    if (!is_dir($target_dir)) mkdir($target_dir);
    $filename = time() . '_' . basename($_FILES["image"]["name"]);
    
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir . $filename)) {
        $sql = "INSERT INTO products (title, price, description, image) VALUES ('$title', '$price', '$desc', '$filename')";
        if($conn->query($sql)) { $msg = "Product Deployed!"; $msg_type = "success"; } 
        else { $msg = "DB Error: " . $conn->error; $msg_type = "error"; }
    } else { $msg = "Upload Failed"; $msg_type = "error"; }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Products</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        :root { --primary-red: #ff3333; --bg-black: #050505; --card-bg: #111; --border: #2a2a2a; color:white;}
        body { background: var(--bg-black); font-family: 'Inter', sans-serif; padding: 20px; }
        .container { max-width: 1000px; margin: 0 auto; }
        
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; border-bottom: 1px solid var(--border); padding-bottom: 20px; }
        .back-btn { color: #888; text-decoration: none; font-weight: 600; } .back-btn:hover { color: white; }

        .admin-card { background: var(--card-bg); border: 1px solid var(--border); padding: 30px; border-radius: 12px; margin-bottom: 40px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; color: #888; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; }
        input, textarea { width: 100%; background: #000; border: 1px solid #333; color: white; padding: 12px; border-radius: 6px; box-sizing: border-box; }
        
        .btn-submit { width: 100%; background: var(--primary-red); color: white; border: none; padding: 14px; border-radius: 6px; font-weight: 700; cursor: pointer; text-transform: uppercase; }
        .alert { padding: 10px; margin-bottom: 20px; border-radius: 4px; text-align: center; }
        .alert-success { background: rgba(0,255,0,0.1); border: 1px solid green; color: green; }
        
        /* Table Styles */
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #333; }
        th { color: #888; font-size: 0.85rem; text-transform: uppercase; }
        tr:hover { background: #161616; }
        .action-btn { padding: 5px 10px; border-radius: 4px; text-decoration: none; font-size: 0.85rem; margin-right: 5px; }
        .edit-btn { background: #333; color: white; }
        .delete-btn { background: rgba(255, 51, 51, 0.2); color: #ff3333; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="dashboard.php" class="back-btn">&larr; Dashboard</a>
            <h2 style="margin:0;">Product Management</h2>
        </div>

        <?php if($msg): ?><div class="alert <?php echo ($msg_type=='success')?'alert-success':'alert-error'; ?>"><?php echo $msg; ?></div><?php endif; ?>

        <div class="admin-card">
            <h3 style="margin-top:0; color:var(--primary-red);">+ Add New Product</h3>
            <form method="POST" enctype="multipart/form-data">
                <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px;">
                    <div class="form-group">
                        <label>Product Name</label>
                        <input type="text" name="title" required>
                    </div>
                    <div class="form-group">
                        <label>Price ($)</label>
                        <input type="number" step="0.01" name="price" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Image</label>
                    <input type="file" name="image" required>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" rows="3"></textarea>
                </div>
                <button type="submit" name="add_product" class="btn-submit">Add Product</button>
            </form>
        </div>

        <h3 style="color:white; border-bottom:1px solid #333; padding-bottom:10px;">Existing Inventory</h3>
        <table>
            <thead>
                <tr>
                    <th width="60">Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $conn->query("SELECT * FROM products ORDER BY id DESC");
                while($row = $result->fetch_assoc()):
                ?>
                <tr>
                    <td><img src="../uploads/<?php echo $row['image']; ?>" width="50" style="border-radius:4px;"></td>
                    <td><?php echo htmlspecialchars($row['title']); ?></td>
                    <td>$<?php echo htmlspecialchars($row['price']); ?></td>
                    <td>
                        <a href="edit_product.php?id=<?php echo $row['id']; ?>" class="action-btn edit-btn">Edit</a>
                        <a href="?delete=<?php echo $row['id']; ?>" class="action-btn delete-btn" onclick="return confirm('Delete this product?');">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>