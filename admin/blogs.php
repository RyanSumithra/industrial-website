<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) { header("Location: login.php"); exit; }
include '../includes/db.php';

$msg = "";
$msg_type = "";

// --- DELETE LOGIC ---
if (isset($_GET['delete'])) {
    $id = $conn->real_escape_string($_GET['delete']);
    $query = $conn->query("SELECT image FROM blogs WHERE id = $id");
    if ($row = $query->fetch_assoc()) {
        if(file_exists("../uploads/".$row['image'])) unlink("../uploads/".$row['image']);
    }
    $conn->query("DELETE FROM blogs WHERE id = $id");
    $msg = "Article Deleted!";
    $msg_type = "success";
}

// --- CREATE LOGIC ---
if (isset($_POST['add_blog'])) {
    $title = $conn->real_escape_string($_POST['blog_title']);
    $content = $conn->real_escape_string($_POST['blog_content']); 
    
    $target_dir = "../uploads/";
    if (!is_dir($target_dir)) mkdir($target_dir);
    $filename = time() . '_' . basename($_FILES["blog_image"]["name"]);
    
    if (move_uploaded_file($_FILES["blog_image"]["tmp_name"], $target_dir . $filename)) {
        $sql = "INSERT INTO blogs (title, content, image) VALUES ('$title', '$content', '$filename')";
        if($conn->query($sql)) { $msg = "Article Published!"; $msg_type = "success"; }
        else { $msg = "DB Error: " . $conn->error; $msg_type = "error"; }
    } else { $msg = "Upload Failed"; $msg_type = "error"; }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Blogs</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js" referrerpolicy="origin"></script>
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
        
        .container { max-width: 1200px; margin: 0 auto; position: relative; }
        
        /* Toggle Button */
        .theme-toggle {
            position: absolute; top: 0; right: 0;
            background: var(--bg-card); border: 1px solid var(--border-color);
            color: var(--text-main); width: 40px; height: 40px;
            border-radius: 50%; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem; transition: 0.3s; z-index: 100;
        }
        .theme-toggle:hover { border-color: var(--primary); color: var(--primary); }

        /* Header */
        .header { 
            display: flex; flex-direction: column; gap: 15px; 
            margin-bottom: 30px; border-bottom: 1px solid var(--border-color); padding-bottom: 20px; 
        }
        .back-btn { 
            color: var(--text-muted); text-decoration: none; font-weight: 600; 
            display: flex; align-items: center; gap: 8px; transition: 0.3s; width: fit-content;
        }
        .back-btn:hover { color: var(--primary); }

        /* Card */
        .admin-card { 
            background: var(--bg-card); border: 1px solid var(--border-color); 
            padding: 30px; border-radius: 12px; margin-bottom: 40px; 
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        }
        
        .meta-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
        .form-group { margin-bottom: 20px; }
        
        label { 
            display: block; margin-bottom: 8px; color: var(--text-muted); 
            font-size: 0.85rem; font-weight: 700; text-transform: uppercase; 
        }
        
        input { 
            width: 100%; background: var(--bg-input); border: 1px solid var(--border-color); 
            color: var(--text-main); padding: 12px; border-radius: 6px; 
            box-sizing: border-box; transition: 0.3s; font-family: inherit;
        }
        input:focus { 
            border-color: var(--primary); outline: none; 
            box-shadow: 0 0 0 3px rgba(255, 51, 51, 0.1);
        }
        
        /* Submit Button */
        .btn-submit { 
            width: 100%; background: var(--primary); color: white; border: none; 
            padding: 14px; border-radius: 6px; font-weight: 700; cursor: pointer; 
            text-transform: uppercase; margin-top: 10px; font-size: 1rem; transition: 0.3s;
        }
        .btn-submit:hover { opacity: 0.9; transform: translateY(-2px); }

        /* Alerts */
        .alert { padding: 15px; margin-bottom: 20px; border-radius: 6px; text-align: center; font-weight: 600; }
        .alert-success { background: rgba(40, 167, 69, 0.1); border: 1px solid #28a745; color: #28a745; }
        .alert-error { background: rgba(220, 53, 69, 0.1); border: 1px solid #dc3545; color: #dc3545; }

        /* TinyMCE Overrides for Theme consistency */
        .tox-tinymce { border: 1px solid var(--border-color) !important; border-radius: 6px !important; }

        /* Table */
        .table-wrapper { overflow-x: auto; margin-top: 20px; }
        table { width: 100%; border-collapse: collapse; min-width: 600px; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid var(--border-color); }
        th { color: var(--text-muted); text-transform: uppercase; font-size: 0.85rem; font-weight: 700; }
        tr:hover { background: var(--table-hover); }
        
        .action-btn { 
            padding: 6px 12px; border-radius: 4px; text-decoration: none; 
            font-size: 0.85rem; margin-right: 5px; font-weight: 600; transition: 0.3s;
        }
        .edit-btn { background: var(--border-color); color: var(--text-main); }
        .edit-btn:hover { background: var(--text-muted); color: white; }
        .delete-btn { background: rgba(255, 51, 51, 0.1); color: var(--primary); }
        .delete-btn:hover { background: var(--primary); color: white; }

        /* Mobile Adjustments */
        @media (max-width: 768px) {
            body { padding: 20px 15px; }
            .theme-toggle { top: -50px; } /* Adjust position relative to container flow if needed */
            .header { padding-top: 40px; }
            .meta-grid { grid-template-columns: 1fr; }
            .admin-card { padding: 20px; }
            th, td { padding: 10px; font-size: 0.9rem; }
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
            <h2 style="margin:0; font-size: 1.8rem; letter-spacing: -0.5px;">Intelligence Hub</h2>
        </div>

        <?php if($msg): ?><div class="alert <?php echo ($msg_type=='success')?'alert-success':'alert-error'; ?>"><?php echo $msg; ?></div><?php endif; ?>

        <div class="admin-card">
            <form method="POST" enctype="multipart/form-data">
                <div class="meta-grid">
                    <div class="form-group">
                        <label>Article Title</label>
                        <input type="text" name="blog_title" required placeholder="Enter headline...">
                    </div>
                    <div class="form-group">
                        <label>Cover Image</label>
                        <input type="file" name="blog_image" required accept="image/*" style="padding: 10px; background: var(--bg-input);">
                    </div>
                </div>
                <div class="form-group">
                    <textarea id="blog_editor" name="blog_content"></textarea>
                </div>
                <button type="submit" name="add_blog" class="btn-submit">Publish Article ➜</button>
            </form>
        </div>

        <h3 style="color:var(--text-main); padding-bottom:10px; border-bottom:1px solid var(--border-color); margin-top: 40px;">Recent Articles</h3>
        
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th width="60">Image</th>
                        <th>Title</th>
                        <th>Date</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = $conn->query("SELECT * FROM blogs ORDER BY created_at DESC");
                    if ($result && $result->num_rows > 0):
                        while($row = $result->fetch_assoc()):
                    ?>
                    <tr>
                        <td>
                            <?php if (!empty($row['image'])): ?>
                                <img src="../uploads/<?php echo $row['image']; ?>" width="50" height="50" style="border-radius:4px; object-fit: cover;">
                            <?php else: ?>
                                <span style="color:var(--text-muted); font-size:0.8rem;">No Img</span>
                            <?php endif; ?>
                        </td>
                        <td style="font-weight: 600; color: var(--text-main);"><?= htmlspecialchars($row['title']); ?></td>
                        <td style="color: var(--text-muted);"><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                        <td>
                            <a href="edit_blog.php?id=<?php echo $row['id']; ?>" class="action-btn edit-btn">Edit</a>
                            <a href="?delete=<?php echo $row['id']; ?>" class="action-btn delete-btn" onclick="return confirm('Delete this article?');">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="4" style="text-align:center; padding:30px; color:var(--text-muted);">No articles published yet.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // --- THEME LOGIC ---
        const currentTheme = localStorage.getItem('theme');
        const icon = document.getElementById('theme-icon');
        const isLightMode = currentTheme === 'light';
        
        if (isLightMode) {
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
            
            // Reload page to re-initialize TinyMCE with correct skin (optional, but cleaner for editor)
            // location.reload(); 
        }

        // --- TINYMCE INIT ---
        // Dynamically choose skin based on current theme on load
        const skin = isLightMode ? "oxide" : "oxide-dark";
        const contentCss = isLightMode ? "default" : "dark";

        tinymce.init({
            selector: '#blog_editor',
            skin: skin,
            content_css: contentCss,
            height: "500",
            plugins: 'image link lists media table code help wordcount',
            toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | image | code',
            image_title: true,
            automatic_uploads: true,
            file_picker_types: 'image',
            file_picker_callback: function (cb, value, meta) {
                var input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');
                input.onchange = function () {
                    var file = this.files[0];
                    var reader = new FileReader();
                    reader.onload = function () {
                        var id = 'blobid' + (new Date()).getTime();
                        var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                        var base64 = reader.result.split(',')[1];
                        var blobInfo = blobCache.create(id, file, base64);
                        blobCache.add(blobInfo);
                        cb(blobInfo.blobUri(), { title: file.name });
                    };
                    reader.readAsDataURL(file);
                };
                input.click();
            }
        });
    </script>
</body>
</html>