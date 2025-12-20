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
            --table-hover: #161616;
        }
        
        /* Light Mode Override */
        body.light-mode {
            --bg-body: #f4f6f9;
            --bg-card: #ffffff;
            --bg-input: #f8f9fa;
            --border-color: #e0e0e0;
            --text-main: #111111;
            --text-muted: #666666;
            --table-hover: #f1f1f1;
        }
        
        body { 
            background: var(--bg-body); 
            font-family: 'Inter', sans-serif; 
            padding: 40px 20px; 
            margin: 0; 
            color: var(--text-main);
            transition: background 0.3s ease, color 0.3s ease;
        }
        
        .container { max-width: 1000px; margin: 0 auto; position: relative; }
        
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

        /* Header & Navigation */
        .header { 
            display: flex; flex-direction: column; gap: 15px; 
            margin-bottom: 30px; border-bottom: 1px solid var(--border-color); padding-bottom: 20px; 
        }
        .header h2 { margin: 0; font-size: 1.8rem; letter-spacing: -0.5px; }
        .back-btn { 
            color: var(--text-muted); text-decoration: none; font-weight: 600; 
            display: flex; align-items: center; gap: 8px; transition: 0.3s; width: fit-content;
        }
        .back-btn:hover { color: var(--primary); }

        /* Cards */
        .card { 
            background: var(--bg-card); border: 1px solid var(--border-color); 
            padding: 30px; border-radius: 12px; margin-bottom: 40px; 
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        }
        .card h3 { margin-top: 0; color: var(--primary); font-size: 1.2rem; margin-bottom: 20px; }

        /* Forms */
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
        
        /* Buttons */
        .btn-submit { 
            width: 100%; background: var(--primary); color: white; border: none; 
            padding: 14px; border-radius: 6px; font-weight: 700; cursor: pointer; 
            text-transform: uppercase; letter-spacing: 1px; transition: 0.3s;
        }
        .btn-submit:hover { opacity: 0.9; transform: translateY(-2px); }

        /* Alerts */
        .alert { padding: 15px; margin-bottom: 30px; border-radius: 6px; font-weight: 600; text-align: center; }
        .alert-success { background: rgba(40, 167, 69, 0.1); border: 1px solid #28a745; color: #28a745; }
        .alert-error { background: rgba(220, 53, 69, 0.1); border: 1px solid #dc3545; color: #dc3545; }

        /* Responsive Table */
        .table-wrapper { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; min-width: 600px; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid var(--border-color); }
        th { color: var(--text-muted); font-size: 0.85rem; text-transform: uppercase; font-weight: 700; }
        tr:hover { background: var(--table-hover); }
        
        img.thumb { border-radius: 4px; border: 1px solid var(--border-color); object-fit: cover; background: #fff; }
        
        /* Action Links */
        .action-links { display: flex; gap: 8px; }
        .action-links a { 
            text-decoration: none; font-size: 0.8rem; font-weight: 600; 
            padding: 6px 12px; border-radius: 4px; transition: 0.3s;
        }
        .edit-btn { background: var(--border-color); color: var(--text-main); }
        .edit-btn:hover { background: var(--text-muted); color: white; }
        .delete-btn { background: rgba(255, 51, 51, 0.1); color: var(--primary); }
        .delete-btn:hover { background: var(--primary); color: white; }

        /* Mobile Adjustments */
        @media (max-width: 600px) {
            body { padding: 20px 15px; }
            .theme-toggle { top: -50px; } /* Move toggle above header on mobile if needed, or adjust position */
            .header { padding-top: 40px; } /* Make space for toggle */
            .card { padding: 20px; }
            th, td { padding: 10px; font-size: 0.9rem; }
            .action-links { flex-direction: column; gap: 5px; }
            .action-links a { text-align: center; }
        }
    </style>
</head>
<body>

<div class="container">
    
    <button class="theme-toggle" onclick="toggleTheme()" title="Switch Theme">
        <span id="theme-icon">☀</span>
    </button>
    
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
                <input type="file" name="image" required style="padding: 10px; background: var(--bg-input);">
            </div>

            <div class="form-group">
                <label>Description / Specs</label>
                <textarea name="description" rows="4" placeholder="Enter details..."></textarea>
            </div>

            <button type="submit" name="add_product" class="btn-submit">Add Product to Catalog</button>
        </form>
    </div>

    <h3 style="color:var(--text-main); border-bottom:1px solid var(--border-color); padding-bottom:10px; margin-bottom:0;">Inventory List</h3>
    
    <div class="table-wrapper">
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
                            <span style="color:var(--text-muted); font-size:0.8rem;">No Img</span>
                        <?php endif; ?>
                    </td>
                    <td style="font-weight: 600; color: var(--text-main);"><?= htmlspecialchars($row['name']) ?></td>
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
                    <td colspan="3" style="text-align:center; padding:30px; color:var(--text-muted);">No products found in database.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
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