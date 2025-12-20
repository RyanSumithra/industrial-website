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
$page_title = $row['title'] . ' | ' . (defined('SITE_NAME') ? SITE_NAME : 'Industrial Intelligence');

// Handle comment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_comment'])) {
    $name = $conn->real_escape_string(trim($_POST['name']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $comment = $conn->real_escape_string(trim($_POST['comment']));
    $parent_id = isset($_POST['parent_id']) ? (int)$_POST['parent_id'] : 0;
    
    if (!empty($name) && !empty($comment)) {
        $stmt = $conn->prepare("INSERT INTO comments (blog_id, name, email, comment, parent_id, is_approved) VALUES (?, ?, ?, ?, ?, 1)");
        $stmt->bind_param("isssi", $id, $name, $email, $comment, $parent_id);
        
        if ($stmt->execute()) {
            $success_message = "Comment posted successfully.";
        } else {
            $error_message = "Error submitting comment.";
        }
        $stmt->close();
    } else {
        $error_message = "Please fill in all required fields.";
    }
}

// Fetch comments
$comments_sql = "SELECT * FROM comments WHERE blog_id = $id AND is_approved = 1 ORDER BY created_at DESC";
$comments_result = $conn->query($comments_sql);
$comments_count = $comments_result ? $comments_result->num_rows : 0;

// Organize comments
$comments = [];
if ($comments_result && $comments_result->num_rows > 0) {
    while($comment = $comments_result->fetch_assoc()) {
        if ($comment['parent_id'] == 0) {
            $comments[$comment['id']] = $comment;
            $comments[$comment['id']]['replies'] = [];
        }
    }
    $comments_result->data_seek(0);
    while($comment = $comments_result->fetch_assoc()) {
        if ($comment['parent_id'] != 0 && isset($comments[$comment['parent_id']])) {
            $comments[$comment['parent_id']]['replies'][] = $comment;
        }
    }
}

include 'includes/header.php'; 
?>

<style>
    /* --- PAGE SPECIFIC STYLES --- */
    
    /* 1. HERO SECTION */
    .article-hero {
        min-height: 40vh;
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        padding: 120px 5% 60px;
        background: var(--bg-body);
        border-bottom: 1px solid var(--border-color);
        overflow: hidden;
    }

    /* Tech Grid Pattern */
    .article-hero::before {
        content: ''; position: absolute; inset: 0;
        background-image: 
            linear-gradient(var(--border-color) 1px, transparent 1px),
            linear-gradient(90deg, var(--border-color) 1px, transparent 1px);
        background-size: 50px 50px;
        opacity: 0.1;
        z-index: 0;
    }

    .hero-overlay {
        position: absolute; inset: 0;
        background: radial-gradient(circle at 50% 30%, rgba(255, 51, 51, 0.05), var(--bg-body) 80%);
        z-index: 1;
    }

    /* Light Mode Hero Overlay: Brighter */
    body.light-mode .hero-overlay {
        background: radial-gradient(circle at 50% 30%, rgba(255, 255, 255, 0.9), transparent 70%);
    }

    .article-hero-content {
        position: relative; z-index: 10;
        max-width: 900px; width: 100%;
    }

    .article-meta { 
        color: var(--primary-red); 
        font-family: 'Courier New', monospace; 
        font-weight: 700; font-size: 0.9rem; letter-spacing: 2px; 
        margin-bottom: 20px; display: inline-block;
        text-transform: uppercase;
        background: rgba(255, 51, 51, 0.1);
        padding: 6px 12px; border-radius: 4px;
    }

    .article-title { 
        font-size: clamp(2rem, 5vw, 3.5rem); 
        font-weight: 900; color: var(--text-main); 
        line-height: 1.1; margin-bottom: 20px; 
        letter-spacing: -1px;
    }
    
    /* Force Title Black in Light Mode */
    body.light-mode .article-title { color: #000000 !important; }

    /* 2. CONTENT CONTAINER */
    .article-container { 
        max-width: 800px; 
        margin: 0 auto; 
        padding: 60px 5%; 
        background: var(--bg-body);
    }
    
    /* Back Button */
    .btn-back {
        display: inline-flex; align-items: center; gap: 8px;
        color: var(--text-muted); text-decoration: none;
        font-weight: 600; font-size: 0.9rem; margin-bottom: 40px;
        transition: 0.3s;
    }
    .btn-back:hover { color: var(--primary-red); transform: translateX(-5px); }

    /* Featured Image */
    .featured-image-wrapper {
        position: relative;
        margin-bottom: 60px;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid var(--border-color);
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    }
    body.light-mode .featured-image-wrapper { box-shadow: 0 20px 40px rgba(0,0,0,0.1); }

    .featured-image { 
        width: 100%; height: auto; display: block;
        transition: transform 0.3s;
    }

    /* Typography & Content */
    .article-content { 
        color: var(--text-muted); 
        font-size: 1.125rem; 
        line-height: 1.8; 
    }
    
    /* --- FIX: Make text Dark in Light Mode --- */
    body.light-mode .article-content {
        color: #222222 !important; /* Nearly Black */
    }
    body.light-mode .article-content p {
        color: #333333 !important; /* Dark Grey */
    }
    
    .article-content p { margin-bottom: 1.5rem; }
    
    .article-content h2, .article-content h3 { 
        color: var(--text-main); 
        margin: 3rem 0 1rem; 
        font-weight: 800; line-height: 1.2;
    }
    /* Force Headings Black in Light Mode */
    body.light-mode .article-content h2, 
    body.light-mode .article-content h3 {
        color: #000000 !important;
    }

    .article-content h2 { font-size: 2rem; }
    .article-content h3 { font-size: 1.5rem; }

    .article-content ul, .article-content ol { 
        margin-bottom: 1.5rem; padding-left: 1.5rem; 
    }
    .article-content li { margin-bottom: 0.5rem; }

    .article-content blockquote { 
        border-left: 4px solid var(--primary-red); 
        margin: 2rem 0; padding: 1rem 2rem; 
        font-style: italic; color: var(--text-main); 
        background: var(--bg-surface-2);
        border-radius: 0 8px 8px 0;
    }
    /* Light Mode Quote */
    body.light-mode .article-content blockquote {
        background: #f0f0f0;
        color: #222 !important;
    }
    
    .article-content img {
        max-width: 100%; height: auto;
        border-radius: 8px; margin: 2rem 0;
    }

    /* 3. COMMENTS SECTION */
    .comments-section {
        margin-top: 80px; padding-top: 60px;
        border-top: 1px solid var(--border-color);
    }

    .comments-header {
        display: flex; justify-content: space-between; align-items: center;
        margin-bottom: 40px; flex-wrap: wrap; gap: 15px;
    }

    .comments-title { 
        font-size: 1.8rem; font-weight: 800; color: var(--text-main); margin: 0;
    }
    body.light-mode .comments-title { color: #000 !important; }

    .comments-count-badge {
        background: var(--bg-surface-2); border: 1px solid var(--border-color);
        color: var(--text-main); font-weight: 700;
        padding: 5px 15px; border-radius: 50px; font-size: 0.9rem;
    }

    /* Form Styles */
    .comment-form-card {
        background: var(--bg-surface-2);
        border: 1px solid var(--border-color);
        padding: 40px; border-radius: 8px;
        margin-bottom: 60px;
    }
    
    .form-group { margin-bottom: 20px; }
    
    .form-label { 
        display: block; color: var(--text-muted); font-size: 0.85rem; 
        font-weight: 700; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 1px;
    }
    
    .form-input {
        width: 100%; padding: 14px;
        background: var(--bg-body); border: 1px solid var(--border-color);
        color: var(--text-main); font-family: 'Inter', sans-serif; font-size: 1rem;
        border-radius: 4px; transition: 0.3s;
    }
    /* Light Mode Input: White background, Dark Text */
    body.light-mode .form-input {
        background: #ffffff;
        color: #000;
        border-color: #ccc;
    }
    
    .form-input:focus {
        outline: none; border-color: var(--primary-red);
        box-shadow: 0 0 0 3px rgba(255, 51, 51, 0.1);
    }
    
    textarea.form-input { min-height: 120px; resize: vertical; }

    .btn-submit {
        background: var(--primary-red); color: white;
        border: none; padding: 14px 30px;
        font-weight: 700; text-transform: uppercase; letter-spacing: 1px;
        border-radius: 4px; cursor: pointer; transition: 0.3s;
        display: inline-flex; align-items: center; gap: 10px;
    }
    .btn-submit:hover { 
        background: var(--text-main); transform: translateY(-2px); 
    }

    /* Messages */
    .msg { padding: 15px; border-radius: 4px; margin-bottom: 20px; font-weight: 600; }
    .msg-success { background: rgba(0, 200, 0, 0.1); color: #00b300; border: 1px solid #00b300; }
    .msg-error { background: rgba(255, 0, 0, 0.1); color: #ff3333; border: 1px solid #ff3333; }

    /* Comment List */
    .comment-item {
        margin-bottom: 30px;
        position: relative;
    }
    
    .comment-box {
        background: var(--bg-surface);
        border: 1px solid var(--border-color);
        padding: 25px; border-radius: 8px;
        transition: 0.3s;
    }
    .comment-box:hover { border-color: var(--text-muted); }

    .comment-meta {
        display: flex; align-items: center; gap: 15px; margin-bottom: 15px;
    }
    
    .avatar {
        width: 45px; height: 45px; border-radius: 50%;
        background: linear-gradient(135deg, var(--bg-surface-2), var(--border-color));
        color: var(--primary-red); font-weight: 700;
        display: flex; align-items: center; justify-content: center;
        border: 1px solid var(--border-color);
        font-size: 1.1rem;
    }
    
    .meta-info h4 { margin: 0; color: var(--text-main); font-size: 1rem; }
    /* Force Name Dark in Light Mode */
    body.light-mode .meta-info h4 { color: #000 !important; }

    .meta-info span { font-size: 0.8rem; color: var(--text-muted); }
    
    .comment-text { color: var(--text-muted); line-height: 1.6; margin-bottom: 15px; }
    /* Darker comment text in light mode */
    body.light-mode .comment-text { color: #333 !important; }
    
    .btn-reply {
        background: transparent; border: 1px solid var(--border-color);
        color: var(--text-muted); padding: 5px 15px; border-radius: 50px;
        font-size: 0.75rem; font-weight: 600; cursor: pointer; transition: 0.3s;
        text-transform: uppercase;
    }
    .btn-reply:hover { border-color: var(--primary-red); color: var(--primary-red); }

    /* Replies */
    .replies-container {
        margin-left: 30px; margin-top: 15px;
        border-left: 2px solid var(--border-color);
        padding-left: 20px;
    }
    
    @media (max-width: 600px) {
        .replies-container { margin-left: 10px; padding-left: 15px; }
        .article-hero { padding: 100px 20px 40px; }
        .article-container { padding: 40px 20px; }
    }
</style>

<div class="noise-overlay"></div>

<section class="article-hero">
    <div class="hero-overlay"></div>
    <div class="article-hero-content reveal">
        <div class="article-meta">
            <?php echo date('F d, Y', strtotime($row['created_at'])); ?>
        </div>
        <h1 class="article-title"><?php echo htmlspecialchars($row['title']); ?></h1>
    </div>
</section>

<div class="article-container">
    <a href="blogs.php" class="btn-back">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
        Back to Intelligence Hub
    </a>

    <?php 
        $imgFile = 'uploads/' . $row['image'];
        if(file_exists($imgFile) && !empty($row['image'])) {
            echo '<div class="featured-image-wrapper reveal"><img src="'.$imgFile.'" class="featured-image" alt="'.htmlspecialchars($row['title']).'"></div>';
        }
    ?>

    <article class="article-content reveal">
        <?php echo $row['content']; ?>
    </article>

    <div class="comments-section reveal">
        <div class="comments-header">
            <h2 class="comments-title">Discussion</h2>
            <span class="comments-count-badge"><?php echo $comments_count; ?> Comments</span>
        </div>

        <div class="comment-form-card">
            <h3 style="color: var(--text-main); margin-bottom: 20px;">Join the Conversation</h3>
            
            <?php if (isset($success_message)): ?>
                <div class="msg msg-success"><?php echo $success_message; ?></div>
            <?php endif; ?>
            <?php if (isset($error_message)): ?>
                <div class="msg msg-error"><?php echo $error_message; ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div>
                        <label class="form-label">Name *</label>
                        <input type="text" name="name" class="form-input" required placeholder="John Doe">
                    </div>
                    <div>
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-input" placeholder="john@example.com">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Comment *</label>
                    <textarea name="comment" id="comment" class="form-input" required placeholder="Share your insights..."></textarea>
                </div>
                
                <input type="hidden" name="parent_id" id="parent_id" value="0">
                
                <button type="submit" name="submit_comment" class="btn-submit">
                    Post Comment
                </button>
            </form>
        </div>

        <div class="comments-list">
            <?php if (empty($comments)): ?>
                <div style="text-align: center; padding: 40px; border: 1px dashed var(--border-color); color: var(--text-muted); border-radius: 8px;">
                    No comments yet. Be the first to start the discussion!
                </div>
            <?php else: ?>
                <?php foreach ($comments as $comment): ?>
                    <div class="comment-item">
                        <div class="comment-box">
                            <div class="comment-meta">
                                <div class="avatar"><?php echo strtoupper(substr($comment['name'], 0, 1)); ?></div>
                                <div class="meta-info">
                                    <h4><?php echo htmlspecialchars($comment['name']); ?></h4>
                                    <span><?php echo date('M d, Y', strtotime($comment['created_at'])); ?></span>
                                </div>
                            </div>
                            <div class="comment-text">
                                <?php echo nl2br(htmlspecialchars($comment['comment'])); ?>
                            </div>
                            <button class="btn-reply" onclick="replyTo(<?php echo $comment['id']; ?>, '<?php echo htmlspecialchars($comment['name']); ?>')">Reply</button>
                        </div>

                        <?php if (!empty($comment['replies'])): ?>
                            <div class="replies-container">
                                <?php foreach ($comment['replies'] as $reply): ?>
                                    <div class="comment-item" style="margin-bottom: 15px;">
                                        <div class="comment-box" style="background: var(--bg-body);">
                                            <div class="comment-meta">
                                                <div class="avatar" style="width: 35px; height: 35px; font-size: 0.9rem;"><?php echo strtoupper(substr($reply['name'], 0, 1)); ?></div>
                                                <div class="meta-info">
                                                    <h4 style="font-size: 0.95rem;"><?php echo htmlspecialchars($reply['name']); ?></h4>
                                                    <span><?php echo date('M d, Y', strtotime($reply['created_at'])); ?></span>
                                                </div>
                                            </div>
                                            <div class="comment-text" style="font-size: 0.95rem;">
                                                <?php echo nl2br(htmlspecialchars($reply['comment'])); ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    // Scroll Reveal
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if(entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
    }, { threshold: 0.1 });
    document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));

    // Reply Logic
    function replyTo(id, name) {
        document.getElementById('parent_id').value = id;
        const textarea = document.getElementById('comment');
        textarea.focus();
        textarea.placeholder = "Replying to " + name + "...";
        document.querySelector('.comment-form-card').scrollIntoView({behavior: 'smooth'});
    }
</script>

<?php include 'includes/footer.php'; ?>