<?php
session_start();
// Security Check
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

// Database Connection
if(file_exists('../includes/db.php')) {
    include '../includes/db.php';
} else {
    die("Error: DB connection missing.");
}

$msg = "";
$msg_type = ""; // success or error

// --- 1. Handle Product Upload ---
if (isset($_POST['add_product'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $price = $conn->real_escape_string($_POST['price']);
    $desc = $conn->real_escape_string($_POST['description']);
    
    // Image Upload Logic
    $target_dir = "../uploads/";
    if (!is_dir($target_dir)) mkdir($target_dir);
    
    $filename = time() . '_' . basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $filename;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    
    // Basic validation
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        $msg = "Error: Only JPG, JPEG, PNG files are allowed.";
        $msg_type = "error";
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $sql = "INSERT INTO products (title, price, description, image) VALUES ('$title', '$price', '$desc', '$filename')";
            if($conn->query($sql)) {
                $msg = "Product System Updated Successfully!";
                $msg_type = "success";
            } else {
                $msg = "Database Error: " . $conn->error;
                $msg_type = "error";
            }
        } else {
            $msg = "Error uploading file.";
            $msg_type = "error";
        }
    }
}

// --- 2. Handle Blog Upload ---
if (isset($_POST['add_blog'])) {
    $title = $conn->real_escape_string($_POST['blog_title']);
    $content = $conn->real_escape_string($_POST['blog_content']);
    
    $target_dir = "../uploads/";
    if (!is_dir($target_dir)) mkdir($target_dir);

    $filename = time() . '_' . basename($_FILES["blog_image"]["name"]);
    $target_file = $target_dir . $filename;
    
    if (move_uploaded_file($_FILES["blog_image"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO blogs (title, content, image) VALUES ('$title', '$content', '$filename')";
        if($conn->query($sql)) {
            $msg = "Intel Hub Updated Successfully!";
            $msg_type = "success";
        } else {
            $msg = "Database Error: " . $conn->error;
            $msg_type = "error";
        }
    } else {
        $msg = "Error uploading file.";
        $msg_type = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Command Center - IndustrialTech</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-red: #ff3333;
            --dark-red: #cc0000;
            --bg-black: #050505;
            --card-bg: #111111;
            --border: #2a2a2a;
            --text-main: #ffffff;
            --text-muted: #888888;
        }

        body {
            background-color: var(--bg-black);
            background-image: 
                linear-gradient(rgba(0,0,0,0.9), rgba(0,0,0,0.9)),
                repeating-linear-gradient(0deg, transparent, transparent 1px, rgba(50, 50, 50, 0.1) 1px, rgba(50, 50, 50, 0.1) 2px);
            color: var(--text-main);
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding-bottom: 50px;
        }

        /* Top Navigation */
        .admin-nav {
            background: rgba(17, 17, 17, 0.95);
            border-bottom: 1px solid var(--border);
            padding: 1rem 0;
            backdrop-filter: blur(10px);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand {
            font-weight: 800;
            font-size: 1.5rem;
            letter-spacing: -0.5px;
        }
        .brand span { color: var(--primary-red); }

        .btn-logout {
            background: transparent;
            border: 1px solid var(--border);
            color: var(--text-muted);
            padding: 8px 16px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 0.9rem;
            transition: 0.3s;
        }
        .btn-logout:hover {
            border-color: var(--primary-red);
            color: white;
        }

        /* Dashboard Layout */
        .dashboard-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .page-header {
            margin-bottom: 2rem;
        }
        .page-header h2 { font-size: 2rem; margin-bottom: 0.5rem; }
        .page-header p { color: var(--text-muted); margin: 0; }

        /* Alerts */
        .alert {
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 30px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideIn 0.4s ease-out;
        }
        .alert-success { background: rgba(40, 167, 69, 0.1); border: 1px solid #28a745; color: #28a745; }
        .alert-error { background: rgba(220, 53, 69, 0.1); border: 1px solid #dc3545; color: #dc3545; }

        /* Grid System */
        .grid-forms {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }
        @media(max-width: 800px) { .grid-forms { grid-template-columns: 1fr; } }

        /* Cards */
        .admin-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 2rem;
            position: relative;
            overflow: hidden;
            transition: 0.3s;
        }
        .admin-card:hover {
            border-color: #444;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }
        /* Color strip on top */
        .admin-card::before {
            content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 3px;
            background: linear-gradient(90deg, #333, var(--primary-red));
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .card-icon { color: var(--primary-red); }

        /* Form Styling */
        .form-group { margin-bottom: 1.5rem; }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-size: 0.85rem;
            color: #ccc;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        input[type="text"],
        input[type="number"],
        textarea,
        input[type="file"] {
            width: 100%;
            background: #0a0a0a;
            border: 1px solid #333;
            color: white;
            padding: 12px;
            border-radius: 6px;
            font-family: inherit;
            box-sizing: border-box;
            transition: 0.3s;
        }

        input:focus, textarea:focus {
            outline: none;
            border-color: var(--primary-red);
            box-shadow: 0 0 10px rgba(255, 51, 51, 0.1);
        }

        /* Custom File Input Styling */
        input[type="file"] {
            padding: 10px;
            cursor: pointer;
        }
        input[type="file"]::file-selector-button {
            background: #222;
            color: white;
            border: 1px solid #444;
            padding: 5px 10px;
            border-radius: 4px;
            margin-right: 10px;
            cursor: pointer;
        }

        .btn-submit {
            width: 100%;
            background: var(--primary-red);
            color: white;
            border: none;
            padding: 14px;
            font-weight: 700;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.3s;
        }
        .btn-submit:hover {
            background: var(--dark-red);
            box-shadow: 0 5px 15px rgba(255, 51, 51, 0.2);
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

    <nav class="admin-nav">
        <div class="nav-container">
            <div class="brand">
                INDUSTRIAL<span>TECH</span>
            </div>
            <div style="display:flex; gap:15px; align-items:center;">
                <a href="../index.php" style="color:#666; text-decoration:none; font-size:0.9rem;">View Site</a>
                <a href="logout.php" class="btn-logout">Sign Out</a>
            </div>
        </div>
    </nav>

    <div class="dashboard-container">
        
        <div class="page-header">
            <h2>Command Center</h2>
            <p>Manage inventory and intelligence feeds.</p>
        </div>

        <?php if($msg): ?>
            <div class="alert <?php echo ($msg_type == 'success') ? 'alert-success' : 'alert-error'; ?>">
                <?php echo ($msg_type == 'success') ? '✓' : '⚠️'; ?> 
                <?php echo $msg; ?>
            </div>
        <?php endif; ?>

        <div class="grid-forms">
            
            <div class="admin-card">
                <div class="card-title">
                    <span class="card-icon">📦</span> Product Uplink
                </div>
                
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Product Name</label>
                        <input type="text" name="title" required placeholder="e.g. Siemens S7-1200 PLC">
                    </div>
                    <div class="form-group">
                        <label>Unit Price ($)</label>
                        <input type="number" step="0.01" name="price" required placeholder="0.00">
                    </div>
                    <div class="form-group">
                        <label>Product Image</label>
                        <input type="file" name="image" required accept="image/*">
                    </div>
                    <div class="form-group">
                        <label>Technical Specs</label>
                        <textarea name="description" rows="4" placeholder="Enter product details..."></textarea>
                    </div>
                    <button type="submit" name="add_product" class="btn-submit">Deploy Product ➜</button>
                </form>
            </div>

            <div class="admin-card">
                <div class="card-title">
                    <span class="card-icon">📰</span> Intelligence Feed
                </div>
                
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Article Title</label>
                        <input type="text" name="blog_title" required placeholder="e.g. Future of IoT">
                    </div>
                    <div class="form-group">
                        <label>Cover Image</label>
                        <input type="file" name="blog_image" required accept="image/*">
                    </div>
                    <div class="form-group">
                        <label>Article Content</label>
                        <textarea name="blog_content" rows="8" required placeholder="Write your article here..."></textarea>
                    </div>
                    <button type="submit" name="add_blog" class="btn-submit">Publish Update ➜</button>
                </form>
            </div>

        </div>
    </div>

</body>
</html>