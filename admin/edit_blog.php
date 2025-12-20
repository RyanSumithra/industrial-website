<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) { header("Location: login.php"); exit; }
include '../includes/db.php';

if (!isset($_GET['id'])) { header("Location: blogs.php"); exit; }
$id = $conn->real_escape_string($_GET['id']);

$result = $conn->query("SELECT * FROM blogs WHERE id = $id");
$blog = $result->fetch_assoc();

if (isset($_POST['update_blog'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);
    
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "../uploads/";
        $filename = time() . '_' . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir . $filename);
        if(file_exists("../uploads/".$blog['image'])) unlink("../uploads/".$blog['image']);
        $update = "UPDATE blogs SET title='$title', content='$content', image='$filename' WHERE id=$id";
    } else {
        $update = "UPDATE blogs SET title='$title', content='$content' WHERE id=$id";
    }

    if($conn->query($update)) {
        header("Location: blogs.php"); 
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Article</title>
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
        
        .container { max-width: 1000px; margin: 0 auto; position: relative; }
        
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
        .header h2 { margin: 0; font-size: 1.8rem; letter-spacing: -0.5px; }
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
        
        /* TinyMCE Overrides */
        .tox-tinymce { border: 1px solid var(--border-color) !important; border-radius: 6px !important; }

        .btn-submit { 
            width: 100%; background: var(--primary); color: white; border: none; 
            padding: 14px; border-radius: 6px; font-weight: 700; cursor: pointer; 
            text-transform: uppercase; margin-top: 20px; font-size: 1rem; transition: 0.3s;
        }
        .btn-submit:hover { opacity: 0.9; transform: translateY(-2px); }
        
        .cancel-link {
            display: block; text-align: center; margin-top: 15px; 
            color: var(--text-muted); text-decoration: none; font-size: 0.9rem;
        }
        .cancel-link:hover { color: var(--text-main); }

        /* Mobile Adjustments */
        @media (max-width: 768px) {
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
            <a href="blogs.php" class="back-btn">&larr; Back to Articles</a>
            <h2 style="margin:0;">Edit Article</h2>
        </div>

        <div class="admin-card">
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Article Title</label>
                    <input type="text" name="title" value="<?php echo htmlspecialchars($blog['title']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Update Cover Image (Optional)</label>
                    <input type="file" name="image" style="padding: 10px; background: var(--bg-input);">
                    <?php if(!empty($blog['image'])): ?>
                        <div style="margin-top:5px; font-size:0.8rem; color:var(--text-muted);">Current: <?php echo htmlspecialchars($blog['image']); ?></div>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label>Content</label>
                    <textarea id="blog_editor" name="content"><?php echo $blog['content']; ?></textarea>
                </div>
                
                <button type="submit" name="update_blog" class="btn-submit">Save Changes</button>
                <a href="blogs.php" class="cancel-link">Cancel</a>
            </form>
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
            
            // Reload to update editor skin is often safest, but we can try dynamic if needed
            // location.reload();
        }

        // --- TINYMCE INIT ---
        const skin = isLightMode ? "oxide" : "oxide-dark";
        const contentCss = isLightMode ? "default" : "dark";

        tinymce.init({
            selector: '#blog_editor',
            skin: skin,
            content_css: contentCss,
            height: "600",
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