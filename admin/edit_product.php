<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

require_once '../includes/db.php';

if (!isset($_GET['id'])) {
    header("Location: products.php");
    exit;
}

$id = (int) $_GET['id'];

// Fetch product
$result = $conn->query("SELECT * FROM products WHERE id = $id");
if (!$result || $result->num_rows === 0) {
    header("Location: products.php");
    exit;
}
$product = $result->fetch_assoc();

if (isset($_POST['update_product'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $description = $conn->real_escape_string($_POST['description']);

    // Image upload check
    if (!empty($_FILES['image']['name'])) {
        $uploadDir = "../uploads/";
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

        $filename = time() . '_' . basename($_FILES['image']['name']);
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $filename)) {
            // delete old image
            if (!empty($product['image_path']) && file_exists($uploadDir . $product['image_path'])) {
                unlink($uploadDir . $product['image_path']);
            }

            $sql = "UPDATE products 
                    SET name='$name', description='$description', image_path='$filename' 
                    WHERE id=$id";
        }
    } else {
        $sql = "UPDATE products 
                SET name='$name', description='$description' 
                WHERE id=$id";
    }

    if (isset($sql) && $conn->query($sql)) {
        header("Location: products.php");
        exit;
    } else {
        $error = $conn->error;
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
        :root { --primary-red: #ff3333; --bg-black: #050505; --card-bg: #111; --border: #2a2a2a; color:white; }
        
        body { 
            background: var(--bg-black); 
            font-family: 'Inter', sans-serif; 
            padding: 40px 20px; 
            margin: 0; 
        }
        
        .container { max-width: 600px; margin: 0 auto; }
        
        /* Header */
        .header { 
            display: flex; justify-content: space-between; align-items: center; 
            margin-bottom: 30px; border-bottom: 1px solid var(--border); padding-bottom: 20px; 
        }
        .header h2 { margin: 0; font-size: 1.5rem; letter-spacing: -0.5px; }
        
        .back-btn { 
            color: #888; text-decoration: none; font-weight: 600; 
            display: flex; align-items: center; gap: 8px; transition: 0.3s;
        }
        .back-btn:hover { color: var(--primary-red); }

        /* Card & Forms */
        .admin-card { 
            background: var(--card-bg); border: 1px solid var(--border); 
            padding: 30px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        }
        
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
        
        .btn-submit { 
            width: 100%; background: var(--primary-red); color: white; border: none; 
            padding: 14px; border-radius: 6px; font-weight: 700; cursor: pointer; 
            text-transform: uppercase; letter-spacing: 1px; transition: 0.3s; margin-top: 10px;
        }
        .btn-submit:hover { background: #cc0000; box-shadow: 0 0 15px rgba(255, 51, 51, 0.3); }

        /* Error/Info styling */
        .error-msg { color: #ff3333; background: rgba(255, 51, 51, 0.1); padding: 10px; border-radius: 4px; margin-bottom: 20px; }
        .current-img-info { font-size: 0.85rem; color: #666; margin-top: 5px; }
    </style>
</head>
<body>

<div class="container">
    
    <div class="header">
        <a href="products.php" class="back-btn">&larr; Back to Products</a>
        <h2>Edit Product</h2>
    </div>

    <?php if (!empty($error)): ?>
        <div class="error-msg"><?php echo $error; ?></div>
    <?php endif; ?>

    <div class="admin-card">
        <form method="POST" enctype="multipart/form-data">
            
            <div class="form-group">
                <label>Product Name</label>
                <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="5"><?= htmlspecialchars($product['description']) ?></textarea>
            </div>

            <div class="form-group">
                <label>Change Image (Optional)</label>
                <input type="file" name="image">
                <div class="current-img-info">Current File: <?= htmlspecialchars($product['image_path']) ?></div>
            </div>

            <button type="submit" name="update_product" class="btn-submit">Save Changes</button>
            
        </form>
    </div>

</div>

</body>
</html>