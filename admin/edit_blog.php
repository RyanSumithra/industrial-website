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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js" referrerpolicy="origin"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        :root { --primary-red: #ff3333; --bg-black: #050505; --card-bg: #111; --border: #2a2a2a; color:white;}
        body { background: var(--bg-black); font-family: 'Inter', sans-serif; padding: 20px; }
        .container { max-width: 98%; margin: 0 auto; }
        .admin-card { background: var(--card-bg); border: 1px solid var(--border); padding: 20px; border-radius: 12px; }
        input { width: 100%; background: #000; border: 1px solid #333; color: white; padding: 12px; border-radius: 6px; box-sizing: border-box; margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; color: #888; font-weight: bold; }
        .btn-submit { width: 100%; background: var(--primary-red); color: white; border: none; padding: 15px; border-radius: 6px; font-weight: 700; cursor: pointer; margin-top: 20px; }
        .tox-tinymce { border: 1px solid #333 !important; }
    </style>
</head>
<body>
    <div class="container">
        <h2 style="border-bottom: 1px solid #333; padding-bottom: 15px;">Edit Article</h2>
        <div class="admin-card">
            <form method="POST" enctype="multipart/form-data">
                <label>Article Title</label>
                <input type="text" name="title" value="<?php echo htmlspecialchars($blog['title']); ?>" required>
                
                <label>Update Cover Image (Optional)</label>
                <input type="file" name="image">
                
                <label>Content</label>
                <textarea id="blog_editor" name="content"><?php echo $blog['content']; ?></textarea>
                
                <button type="submit" name="update_blog" class="btn-submit">Save Changes</button>
                <a href="blogs.php" style="display:block; text-align:center; margin-top:15px; color:#888; text-decoration:none;">Cancel</a>
            </form>
        </div>
    </div>

    <script>
        tinymce.init({
            selector: '#blog_editor',
            skin: "oxide-dark",
            content_css: "dark",
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