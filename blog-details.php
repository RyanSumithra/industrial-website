<?php 
require_once 'includes/config.php';
include 'includes/db.php';

// Check for ID
if (!isset($_GET['id'])) {
    header("Location: blogs.php");
    exit;
}

$id = $conn->real_escape_string($_GET['id']);
$sql = "SELECT * FROM blogs WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    header("Location: blogs.php");
    exit;
}

$row = $result->fetch_assoc();
$page_title = $row['title'] . ' | ' . SITE_NAME;

include 'includes/header.php'; 
?>

<style>
    /* Article Page Styles */
    .article-container { max-width: 800px; margin: 0 auto; padding: 60px 20px; }
    
    .article-header { text-align: center; margin-bottom: 40px; border-bottom: 1px solid #222; padding-bottom: 40px; }
    .article-meta { color: var(--primary-red); font-size: 0.9rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px; }
    .article-title { font-size: 3rem; font-weight: 900; color: white; line-height: 1.2; margin-bottom: 20px; }
    
    .featured-image { width: 100%; height: 400px; object-fit: cover; border-radius: 12px; margin-bottom: 50px; border: 1px solid #333; }
    
    /* Content Formatting (Rich Text) */
    .article-content { color: #ccc; font-size: 1.1rem; line-height: 1.8; }
    
    /* Handle HTML tags from Editor */
    .article-content h1, .article-content h2, .article-content h3 { color: white; margin-top: 40px; margin-bottom: 20px; font-weight: 800; }
    .article-content p { margin-bottom: 20px; }
    .article-content img { max-width: 100%; height: auto; border-radius: 8px; margin: 20px 0; border: 1px solid #333; }
    .article-content ul, .article-content ol { margin-bottom: 20px; padding-left: 20px; }
    .article-content li { margin-bottom: 10px; }
    .article-content blockquote { border-left: 4px solid var(--primary-red); padding-left: 20px; font-style: italic; color: white; margin: 30px 0; }

    .back-btn { display: inline-flex; align-items: center; gap: 10px; color: #888; text-decoration: none; font-weight: 600; margin-bottom: 30px; transition: 0.3s; }
    .back-btn:hover { color: var(--primary-red); transform: translateX(-5px); }
</style>

<div style="background: #050505; min-height: 100vh;">
    
    <div class="article-container">
        <a href="blogs.php" class="back-btn">&larr; Back to Intelligence Hub</a>

        <div class="article-header">
            <div class="article-meta"><?php echo date('F j, Y', strtotime($row['created_at'])); ?></div>
            <h1 class="article-title"><?php echo htmlspecialchars($row['title']); ?></h1>
        </div>

        <?php 
            $imgFile = 'uploads/' . $row['image'];
            if(file_exists($imgFile) && !empty($row['image'])) {
                echo '<img src="'.$imgFile.'" class="featured-image" alt="Featured Image">';
            }
        ?>

        <div class="article-content">
            <?php echo $row['content']; ?>
        </div>

    </div>

    <div style="border-top: 1px solid #222; padding: 60px 0; background: #080808;">
        <div class="container" style="text-align: center;">
            <h3 style="color: white; margin-bottom: 20px;">Continue Reading</h3>
            <a href="blogs.php" class="btn-primary" style="background:#ff3333; color:white; padding: 12px 30px; text-decoration: none; border-radius: 4px; font-weight:700;">View All Articles</a>
        </div>
    </div>

</div>

<?php include 'includes/footer.php'; ?>