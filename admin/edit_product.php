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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        /* --- VARIABLES --- */
        :root { 
            --primary: #ff3333; 
            --bg-body: #050505; 
            --bg-card: #111111; 
            --bg-input: #000000;
            --border-color: #2a2a2a; 
            --text-main: #ffffff;
            --text-muted: #888888;
        }
        
        /* Light Mode Override */
        body.light-mode {
            --bg-body: #f4f6f9;
            --bg-card: #ffffff;
            --bg-input: #f8f9fa;
            --border-color: #e0e0e0;
            --text-main: #111111;
            --text-muted: #666666;
        }
        
        body { 
            background: var(--bg-body); 
            font-family: 'Inter', sans-serif; 
            padding: 40px 20px; 
            margin: 0; 
            color: var(--text-main);
            transition: background 0.3s ease, color 0.3s ease;
        }
        
        .container { max-width: 600px; margin: 0 auto; position: relative; }
        
        /* Toggle Button */
        .theme-toggle {
            position: absolute; top: 0; right: 0;
            background: var(--bg-card); border: 1px solid var(--border-color);
            color: var(--text-main); width: 40px; height: 40px;
            border-radius: 50%; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem; transition: 0.3s;
        }
        .theme-toggle:hover { border-color: var(--primary); color: var(--primary); }

        /* Header */
        .header { 
            display: flex; flex-direction: column; gap: 15px; 
            margin-bottom: 30px; border-bottom: 1px solid var(--border-color); padding-bottom: 20px; 
        }
        .header h2 { margin: 0; font-size: 1.5rem; letter-spacing: -0.5px; }
        
        .back-btn { 
            color: var(--text-muted); text-decoration: none; font-weight: 600; 
            display: flex; align-items: center; gap: 8px; transition: 0.3s; width: fit-content;
        }
        .back-btn:hover { color: var(--primary); }

        /* Card & Forms */
        .admin-card { 
            background: var(--bg-card); border: 1px solid var(--border-color); 
            padding: 30px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        }
        
        .form-group { margin-bottom: 20px; }
        
        label { 
            display: block; margin-bottom: 8px; color: var(--text-muted); 
            font-size: 0.85rem; font-weight: 700; text-transform: uppercase; 
        }
        
        input, textarea { 
            width: 100%; background: var(--bg-input); border: 1px solid var(--border-color); 
            color: var(--text-main); padding: 12px; border-radius: 6px; 
            box-sizing: border-box; transition: 0.3s; font-family: inherit;
        }
        input:focus, textarea:focus { 
            border-color: var(--primary); outline: none; 
            box-shadow: 0 0 0 3px rgba(255, 51, 51, 0.1);
        }
        
        .btn-submit { 
            width: 100%; background: var(--primary); color: white; border: none; 
            padding: 14px; border-radius: 6px; font-weight: 700; cursor: pointer; 
            text-transform: uppercase; letter-spacing: 1px; transition: 0.3s; margin-top: 10px;
        }
        .btn-submit:hover { opacity: 0.9; transform: translateY(-2px); }

        /* Error/Info styling */
        .error-msg { 
            color: var(--primary); background: rgba(255, 51, 51, 0.1); 
            padding: 10px; border-radius: 4px; margin-bottom: 20px; border: 1px solid rgba(255, 51, 51, 0.2);
        }
        .current-img-info { font-size: 0.85rem; color: var(--text-muted); margin-top: 8px; font-style: italic; }

        /* Mobile Adjustments */
        @media (max-width: 600px) {
            body { padding: 20px 15px; }
            .theme-toggle { top: -50px; }
            .header { padding-top: 40px; }
            .admin-card { padding: 20px; }
        }
    </style>
</head>
<body>

<div class="container">
    
    <button class="theme-toggle" onclick="toggleTheme()" title="Switch Theme">
        <span id="theme-icon">☀</span>
    </button>
    
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
                <input type="file" name="image" style="padding: 10px; background: var(--bg-input);">
                <div class="current-img-info">Current File: <?= htmlspecialchars($product['image_path']) ?></div>
            </div>

            <button type="submit" name="update_product" class="btn-submit">Save Changes</button>
            
        </form>
    </div>

</div>

<script>
    // Theme Logic
    const currentTheme = localStorage.getItem('theme');
    const icon = document.getElementById('theme-icon');
    
    if (currentTheme === 'light') {
        document.body.classList.add('light-mode');
        icon.innerText = '🌙';
    } else {
        icon.innerText = '☀';
    }

    function toggleTheme() {
        document.body.classList.toggle('light-mode');
        const isLight = document.body.classList.contains('light-mode');
        localStorage.setItem('theme', isLight ? 'light' : 'dark');
        icon.innerText = isLight ? '🌙' : '☀';
    }
</script>

</body>
</html>