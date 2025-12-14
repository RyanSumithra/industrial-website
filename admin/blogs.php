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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js" referrerpolicy="origin"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        :root { --primary-red: #ff3333; --bg-black: #050505; --card-bg: #111; --border: #2a2a2a; color:white;}
        body { background: var(--bg-black); font-family: 'Inter', sans-serif; padding: 20px; overflow-x: hidden; }
        .container { max-width: 98%; margin: 0 auto; } 
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid var(--border); padding-bottom: 20px; }
        .back-btn { color: #888; text-decoration: none; font-weight: 600; font-size: 1.1rem;} .back-btn:hover { color: white; }
        .admin-card { background: var(--card-bg); border: 1px solid var(--border); padding: 20px; border-radius: 12px; margin-bottom: 40px; }
        .meta-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
        .form-group { margin-bottom: 0; }
        label { display: block; margin-bottom: 8px; color: #888; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; }
        input { width: 100%; background: #000; border: 1px solid #333; color: white; padding: 12px; border-radius: 6px; box-sizing: border-box; }
        .btn-submit { width: 100%; background: var(--primary-red); color: white; border: none; padding: 15px; border-radius: 6px; font-weight: 700; cursor: pointer; text-transform: uppercase; margin-top: 20px; font-size: 1rem; }
        .alert { padding: 10px; margin-bottom: 20px; border-radius: 4px; text-align: center; }
        .alert-success { background: rgba(0,255,0,0.1); border: 1px solid green; color: green; }
        .tox-tinymce { border: 1px solid #333 !important; border-radius: 6px !important; }

        /* Table */
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #333; }
        th { color: #888; text-transform: uppercase; }
        tr:hover { background: #161616; }
        .action-btn { padding: 5px 10px; border-radius: 4px; text-decoration: none; font-size: 0.85rem; margin-right: 5px; }
        .edit-btn { background: #333; color: white; }
        .delete-btn { background: rgba(255, 51, 51, 0.2); color: #ff3333; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="dashboard.php" class="back-btn">&larr; Back to Dashboard</a>
            <h2 style="margin:0;">Intelligence Hub</h2>
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
                        <input type="file" name="blog_image" required accept="image/*">
                    </div>
                </div>
                <div class="form-group">
                    <textarea id="blog_editor" name="blog_content"></textarea>
                </div>
                <button type="submit" name="add_blog" class="btn-submit">Publish Article ➜</button>
            </form>
        </div>

        <h3 style="color:white; padding-bottom:10px; border-bottom:1px solid #333;">Recent Articles</h3>
        <table>
            <thead>
                <tr>
                    <th width="60">Image</th>
                    <th>Title</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $conn->query("SELECT * FROM blogs ORDER BY created_at DESC");
                while($row = $result->fetch_assoc()):
                ?>
                <tr>
                    <td><img src="../uploads/<?php echo $row['image']; ?>" width="50" style="border-radius:4px;"></td>
                    <td><?php echo htmlspecialchars($row['title']); ?></td>
                    <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                    <td>
                        <a href="edit_blog.php?id=<?php echo $row['id']; ?>" class="action-btn edit-btn">Edit</a>
                        <a href="?delete=<?php echo $row['id']; ?>" class="action-btn delete-btn" onclick="return confirm('Delete this article?');">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script>
        tinymce.init({
            selector: '#blog_editor',
            skin: "oxide-dark",
            content_css: "dark",
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