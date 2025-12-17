<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

require_once '../includes/db.php';

$msg = "";
$msg_type = ""; // To control alert color

// --- DELETE LOGIC ---
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];

    $res = $conn->query("SELECT image_path FROM products WHERE id=$id");
    if ($row = $res->fetch_assoc()) {
        if (!empty($row['image_path']) && file_exists("../uploads/".$row['image_path'])) {
            unlink("../uploads/".$row['image_path']);
        }
    }
    $conn->query("DELETE FROM products WHERE id=$id");
    $msg = "Product deleted successfully";
    $msg_type = "success";
}

// --- ADD LOGIC ---
if (isset($_POST['add_product'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $description = $conn->real_escape_string($_POST['description']);

    $uploadDir = "../uploads/";
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

    $filename = time() . '_' . basename($_FILES['image']['name']);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir.$filename)) {
        $sql = "INSERT INTO products (name, description, image_path)
                VALUES ('$name', '$description', '$filename')";
        if ($conn->query($sql)) {
            $msg = "Product added successfully";
            $msg_type = "success";
        } else {
            $msg = "Database Error: " . $conn->error;
            $msg_type = "error";
        }
    } else {
        $msg = "Failed to upload image";
        $msg_type = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Management</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        :root { --primary-red: #ff3333; --bg-black: #050505; --card-bg: #111; --border: #2a2a2a; color:white; }
        
        body { 
            background: var(--bg-black); 
            font-family: 'Inter', sans-serif; 
            padding: 40px 20px; 
            margin: 0; 
        }
        
        .container { max-width: 1000px; margin: 0 auto; }
        
        /* Header & Navigation */
        .header { 
            display: flex; justify-content: space-between; align-items: center; 
            margin-bottom: 30px; border-bottom: 1px solid var(--border); padding-bottom: 20px; 
        }
        .header h2 { margin: 0; font-size: 1.8rem; letter-spacing: -0.5px; }
        .back-btn { 
            color: #888; text-decoration: none; font-weight: 600; 
            display: flex; align-items: center; gap: 8px; transition: 0.3s;
        }
        .back-btn:hover { color: var(--primary-red); }

        /* Cards */
        .card { 
            background: var(--card-bg); border: 1px solid var(--border); 
            padding: 30px; border-radius: 12px; margin-bottom: 40px; 
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        }
        .card h3 { margin-top: 0; color: var(--primary-red); font-size: 1.2rem; margin-bottom: 20px; }

        /* Forms */
        .form-group { margin-bottom: 20px; }
        label { 
            display: block; margin-bottom: 8px; color: #aaa; 
            font-size: 0.85rem; font-weight: 700; text-transform: uppercase; 
        }
        input, textarea { 
            width: 100%; background: #000; border: 1px solid #333; color: white; 
            padding: 12px; border-radius: 6px; box-sizing: border-box; transition: 0.3s;
            font-family: inherit;
        }
        input:focus, textarea:focus { 
            border-color: var(--primary-red); outline: none; 
            box-shadow: 0 0 10px rgba(255, 51, 51, 0.1);
        }
        
        /* Buttons */
        .btn-submit { 
            width: 100%; background: var(--primary-red); color: white; border: none; 
            padding: 14px; border-radius: 6px; font-weight: 700; cursor: pointer; 
            text-transform: uppercase; letter-spacing: 1px; transition: 0.3s;
        }
        .btn-submit:hover { background: #cc0000; box-shadow: 0 0 15px rgba(255, 51, 51, 0.3); }

        /* Alerts */
        .alert { padding: 15px; margin-bottom: 30px; border-radius: 6px; font-weight: 600; text-align: center; }
        .alert-success { background: rgba(40, 167, 69, 0.1); border: 1px solid #28a745; color: #28a745; }
        .alert-error { background: rgba(220, 53, 69, 0.1); border: 1px solid #dc3545; color: #dc3545; }

        /* Tables */
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #222; }
        th { color: #666; font-size: 0.85rem; text-transform: uppercase; font-weight: 700; }
        tr:hover { background: #161616; }
        
        img.thumb { border-radius: 4px; border: 1px solid #333; object-fit: cover; }
        
        /* Action Links */
        .action-links a { 
            text-decoration: none; font-size: 0.85rem; font-weight: 600; 
            padding: 6px 12px; border-radius: 4px; margin-right: 5px; transition: 0.3s;
        }
        .edit-btn { background: #222; color: #fff; }
        .edit-btn:hover { background: #333; }
        .delete-btn { background: rgba(255, 51, 51, 0.1); color: var(--primary-red); }
        .delete-btn:hover { background: var(--primary-red); color: white; }
    </style>
</head>
<body>

<div class="container">
    
    <div class="header">
        <a href="dashboard.php" class="back-btn">&larr; Back to Dashboard</a>
        <h2>Product Management</h2>
    </div>

    <?php if ($msg): ?>
        <div class="alert <?php echo ($msg_type == 'success') ? 'alert-success' : 'alert-error'; ?>">
            <?php echo $msg; ?>
        </div>
    <?php endif; ?>

    <div class="card">
        <h3>+ Deploy New Product</h3>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Product Name</label>
                <input type="text" name="name" required placeholder="Enter product name...">
            </div>

            <div class="form-group">
                <label>Product Image</label>
                <input type="file" name="image" required>
            </div>

            <div class="form-group">
                <label>Description / Specs</label>
                <textarea name="description" rows="4" placeholder="Enter details..."></textarea>
            </div>

            <button type="submit" name="add_product" class="btn-submit">Add Product to Catalog</button>
        </form>
    </div>

    <h3 style="color:white; border-bottom:1px solid #333; padding-bottom:10px; margin-bottom:0;">Inventory List</h3>
    <table>
        <thead>
            <tr>
                <th width="80">Image</th>
                <th>Product Name</th>
                <th width="150">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $res = $conn->query("SELECT * FROM products ORDER BY id DESC");
            if ($res && $res->num_rows > 0):
                while ($row = $res->fetch_assoc()):
            ?>
            <tr>
                <td>
                    <?php if (!empty($row['image_path'])): ?>
                        <img src="../uploads/<?= $row['image_path'] ?>" width="60" height="60" class="thumb">
                    <?php else: ?>
                        <span style="color:#444; font-size:0.8rem;">No Img</span>
                    <?php endif; ?>
                </td>
                <td style="font-weight: 500; color: #ddd;"><?= htmlspecialchars($row['name']) ?></td>
                <td class="action-links">
                    <a href="edit_product.php?id=<?= $row['id'] ?>" class="edit-btn">Edit</a>
                    <a href="?delete=<?= $row['id'] ?>" class="delete-btn" onclick="return confirm('Permanently delete this product?')">Delete</a>
                </td>
            </tr>
            <?php 
                endwhile; 
            else:
            ?>
            <tr>
                <td colspan="3" style="text-align:center; padding:30px; color:#666;">No products found in database.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

</div>

</body>
</html>