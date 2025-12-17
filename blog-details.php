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
            $success_message = "Thank you for your comment! It will be visible after moderation.";
        } else {
            $error_message = "Error submitting comment. Please try again.";
        }
        $stmt->close();
    } else {
        $error_message = "Please fill in all required fields.";
    }
}

// Fetch approved comments for this blog
$comments_sql = "SELECT * FROM comments WHERE blog_id = $id AND is_approved = 1 ORDER BY created_at DESC";
$comments_result = $conn->query($comments_sql);
$comments_count = $comments_result ? $comments_result->num_rows : 0;

// Organize comments into parent-child structure
$comments = [];
if ($comments_result && $comments_result->num_rows > 0) {
    while($comment = $comments_result->fetch_assoc()) {
        if ($comment['parent_id'] == 0) {
            $comments[$comment['id']] = $comment;
            $comments[$comment['id']]['replies'] = [];
        }
    }
    // Reset pointer and fetch again for replies
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
    /* Article Page Styles - Match Home Page */
    :root {
        --primary: #ff3333;
        --primary-dim: #cc0000;
        --bg: #030303;
        --surface: #0a0a0a;
        --border: #222;
        --text: #ffffff;
        --text-muted: #888;
    }

    body {
        background-color: var(--bg);
        color: var(--text);
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
        overflow-x: hidden;
        margin: 0;
    }

    .article-container { 
        max-width: 900px; 
        margin: 0 auto; 
        padding: 60px 20px; 
    }
    
    .article-header { 
        text-align: center; 
        margin-bottom: 60px; 
        border-bottom: 1px solid var(--border); 
        padding-bottom: 40px; 
    }
    
    .article-meta { 
        color: var(--primary); 
        font-size: 0.9rem; 
        font-weight: 700; 
        text-transform: uppercase; 
        letter-spacing: 1px; 
        margin-bottom: 15px; 
        font-family: 'Courier New', monospace;
    }
    
    .article-title { 
        font-size: clamp(2.5rem, 5vw, 3.5rem); 
        font-weight: 900; 
        color: white; 
        line-height: 1.2; 
        margin-bottom: 20px; 
        text-transform: uppercase;
    }
    
    .featured-image { 
        width: 100%; 
        height: 500px; 
        object-fit: cover; 
        margin: 50px 0; 
        border: 1px solid var(--border);
        transition: transform 0.3s ease;
    }
    
    .featured-image:hover {
        transform: scale(1.01);
    }
    
    /* Content Formatting */
    .article-content { 
        color: #ccc; 
        font-size: 1.1rem; 
        line-height: 1.8; 
        margin-bottom: 80px;
    }
    
    .article-content h1, 
    .article-content h2, 
    .article-content h3 { 
        color: white; 
        margin-top: 40px; 
        margin-bottom: 20px; 
        font-weight: 800; 
    }
    
    .article-content p { 
        margin-bottom: 25px; 
    }
    
    .article-content img { 
        max-width: 100%; 
        height: auto; 
        border-radius: 0; 
        margin: 30px 0; 
        border: 1px solid var(--border); 
    }
    
    .article-content ul, 
    .article-content ol { 
        margin-bottom: 25px; 
        padding-left: 20px; 
    }
    
    .article-content li { 
        margin-bottom: 10px; 
    }
    
    .article-content blockquote { 
        border-left: 4px solid var(--primary); 
        padding-left: 20px; 
        font-style: italic; 
        color: white; 
        margin: 40px 0; 
        font-size: 1.2rem;
    }

    /* Back Button */
    .back-btn { 
        display: inline-flex; 
        align-items: center; 
        gap: 10px; 
        color: var(--text-muted); 
        text-decoration: none; 
        font-weight: 600; 
        margin-bottom: 40px; 
        transition: all 0.3s ease;
        padding: 12px 24px;
        border: 1px solid var(--border);
        background: var(--surface);
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.85rem;
    }
    
    .back-btn:hover { 
        color: var(--primary); 
        border-color: var(--primary);
        transform: translateX(-5px); 
    }

    /* Comments Section */
    .comments-section {
        margin-top: 80px;
        border-top: 1px solid var(--border);
        padding-top: 60px;
    }

    .comments-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 40px;
    }

    .comments-title {
        font-size: 2rem;
        font-weight: 800;
        color: white;
        text-transform: uppercase;
    }

    .comments-count {
        color: var(--primary);
        font-weight: 700;
        font-size: 1rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-family: 'Courier New', monospace;
        background: rgba(255, 51, 51, 0.1);
        padding: 8px 16px;
        border: 1px solid var(--primary);
    }

    /* Comment Form */
    .comment-form {
        background: var(--surface);
        border: 1px solid var(--border);
        padding: 40px;
        margin-bottom: 50px;
        transition: all 0.3s ease;
    }

    .comment-form:hover {
        border-color: var(--primary);
    }

    .form-title {
        color: white;
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 30px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-label {
        display: block;
        color: var(--text-muted);
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .form-input {
        width: 100%;
        padding: 15px 20px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid var(--border);
        color: white;
        font-size: 1rem;
        font-family: 'Inter', sans-serif;
        transition: all 0.3s ease;
    }

    .form-input:focus {
        outline: none;
        border-color: var(--primary);
        background: rgba(255, 51, 51, 0.05);
    }

    .form-textarea {
        min-height: 150px;
        resize: vertical;
    }

    .form-required {
        color: var(--primary);
    }

    .submit-button {
        padding: 18px 40px;
        background: var(--primary);
        color: white;
        border: none;
        cursor: pointer;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }

    .submit-button:hover {
        background: var(--primary-dim);
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(255, 51, 51, 0.2);
    }

    /* Messages */
    .message {
        padding: 15px 20px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 0;
        font-weight: 600;
    }

    .success-message {
        background: rgba(0, 200, 0, 0.1);
        border-color: #00cc00;
        color: #00cc00;
    }

    .error-message {
        background: rgba(255, 51, 51, 0.1);
        border-color: var(--primary);
        color: var(--primary);
    }

    /* Comments List */
    .comments-list {
        margin-top: 40px;
    }

    .comment {
        background: var(--surface);
        border: 1px solid var(--border);
        padding: 30px;
        margin-bottom: 25px;
        transition: all 0.3s ease;
        position: relative;
    }

    .comment:hover {
        border-color: var(--primary);
        transform: translateX(5px);
    }

    .comment-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .comment-author {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .author-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary) 0%, #ff6666 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1.2rem;
        text-transform: uppercase;
    }

    .author-info {
        flex: 1;
    }

    .author-name {
        color: white;
        font-weight: 700;
        font-size: 1.1rem;
        margin-bottom: 5px;
    }

    .comment-date {
        color: var(--text-muted);
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }

    .comment-content {
        color: #ccc;
        line-height: 1.7;
        margin-bottom: 20px;
        padding-left: 65px;
    }

    .reply-button {
        color: var(--primary);
        background: none;
        border: 1px solid var(--primary);
        padding: 8px 20px;
        cursor: pointer;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.8rem;
        transition: all 0.3s ease;
        margin-left: 65px;
    }

    .reply-button:hover {
        background: var(--primary);
        color: white;
    }

    /* Replies */
    .replies {
        margin-left: 65px;
        margin-top: 25px;
        padding-left: 25px;
        border-left: 2px solid var(--border);
    }

    .reply {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.1);
        padding: 20px;
        margin-bottom: 15px;
    }

    .reply:hover {
        border-color: var(--primary);
    }

    /* No Comments */
    .no-comments {
        text-align: center;
        padding: 60px 20px;
        border: 2px dashed var(--border);
        margin: 40px 0;
    }

    .no-comments h3 {
        color: #666;
        font-size: 1.5rem;
        margin-bottom: 15px;
        font-weight: 600;
    }

    .no-comments p {
        color: #888;
        margin-bottom: 25px;
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
    }

    /* Continue Reading */
    .continue-reading {
        border-top: 1px solid var(--border);
        padding: 80px 0;
        background: rgba(0, 0, 0, 0.5);
        margin-top: 80px;
        text-align: center;
    }

    .continue-title {
        color: white;
        font-size: 1.8rem;
        font-weight: 800;
        margin-bottom: 30px;
        text-transform: uppercase;
    }

    .continue-button {
        background: var(--primary);
        color: white;
        padding: 18px 45px;
        text-decoration: none;
        border: none;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        display: inline-flex;
        align-items: center;
        gap: 15px;
        transition: all 0.3s ease;
    }

    .continue-button:hover {
        background: var(--primary-dim);
        gap: 20px;
        transform: translateY(-2px);
        box-shadow: 0 15px 30px rgba(255, 51, 51, 0.3);
    }

    @media (max-width: 768px) {
        .article-container {
            padding: 40px 15px;
        }
        
        .article-title {
            font-size: 2rem;
        }
        
        .featured-image {
            height: 300px;
        }
        
        .comment-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .comment-content {
            padding-left: 0;
        }
        
        .reply-button {
            margin-left: 0;
        }
        
        .replies {
            margin-left: 20px;
            padding-left: 15px;
        }
    }
</style>

<div class="article-container">
    <a href="blogs.php" class="back-btn">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="15 18 9 12 15 6"></polyline>
        </svg>
        Back to Intelligence Hub
    </a>

    <div class="article-header">
        <div class="article-meta"><?php echo date('F j, Y', strtotime($row['created_at'])); ?></div>
        <h1 class="article-title"><?php echo htmlspecialchars($row['title']); ?></h1>
    </div>

    <?php 
        $imgFile = 'uploads/' . $row['image'];
        if(file_exists($imgFile) && !empty($row['image'])) {
            echo '<img src="'.$imgFile.'" class="featured-image" alt="'.htmlspecialchars($row['title']).'">';
        }
    ?>

    <div class="article-content">
        <?php echo $row['content']; ?>
    </div>

    <!-- Comments Section -->
    <div class="comments-section">
        <div class="comments-header">
            <h2 class="comments-title">Discussion</h2>
            <span class="comments-count"><?php echo $comments_count; ?> Comment<?php echo $comments_count != 1 ? 's' : ''; ?></span>
        </div>

        <!-- Comment Form -->
        <div class="comment-form">
            <h3 class="form-title">Leave a Comment</h3>
            
            <?php if (isset($success_message)): ?>
                <div class="message success-message"><?php echo $success_message; ?></div>
            <?php endif; ?>
            
            <?php if (isset($error_message)): ?>
                <div class="message error-message"><?php echo $error_message; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="name" class="form-label">Name <span class="form-required">*</span></label>
                    <input type="text" id="name" name="name" class="form-input" required 
                           placeholder="Enter your name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-input" 
                           placeholder="Enter your email (optional)" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label for="comment" class="form-label">Comment <span class="form-required">*</span></label>
                    <textarea id="comment" name="comment" class="form-input form-textarea" required 
                              placeholder="Share your thoughts..."><?php echo isset($_POST['comment']) ? htmlspecialchars($_POST['comment']) : ''; ?></textarea>
                </div>
                
                <input type="hidden" name="parent_id" id="parent_id" value="0">
                <input type="hidden" name="blog_id" value="<?php echo $id; ?>">
                
                <button type="submit" name="submit_comment" class="submit-button">
                    Post Comment
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="22" y1="2" x2="11" y2="13"></line>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                    </svg>
                </button>
            </form>
        </div>

        <!-- Comments List -->
        <div class="comments-list">
            <?php if (empty($comments)): ?>
                <div class="no-comments">
                    <h3>No comments yet</h3>
                    <p>Be the first to share your thoughts on this article.</p>
                </div>
            <?php else: ?>
                <?php foreach ($comments as $comment): ?>
                    <div class="comment" id="comment-<?php echo $comment['id']; ?>">
                        <div class="comment-header">
                            <div class="comment-author">
                                <div class="author-avatar">
                                    <?php echo strtoupper(substr($comment['name'], 0, 1)); ?>
                                </div>
                                <div class="author-info">
                                    <div class="author-name"><?php echo htmlspecialchars($comment['name']); ?></div>
                                    <div class="comment-date"><?php echo date('F j, Y \a\t g:i a', strtotime($comment['created_at'])); ?></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="comment-content">
                            <?php echo nl2br(htmlspecialchars($comment['comment'])); ?>
                        </div>
                        
                        <button class="reply-button" onclick="setReplyTo(<?php echo $comment['id']; ?>, '<?php echo htmlspecialchars($comment['name']); ?>')">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="9 17 4 12 9 7"></polyline>
                                <path d="M20 18v-2a4 4 0 0 0-4-4H4"></path>
                            </svg>
                            Reply
                        </button>
                        
                        <?php if (!empty($comment['replies'])): ?>
                            <div class="replies">
                                <?php foreach ($comment['replies'] as $reply): ?>
                                    <div class="comment reply" id="comment-<?php echo $reply['id']; ?>">
                                        <div class="comment-header">
                                            <div class="comment-author">
                                                <div class="author-avatar" style="width: 40px; height: 40px; font-size: 1rem;">
                                                    <?php echo strtoupper(substr($reply['name'], 0, 1)); ?>
                                                </div>
                                                <div class="author-info">
                                                    <div class="author-name"><?php echo htmlspecialchars($reply['name']); ?></div>
                                                    <div class="comment-date"><?php echo date('F j, Y \a\t g:i a', strtotime($reply['created_at'])); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="comment-content">
                                            <?php echo nl2br(htmlspecialchars($reply['comment'])); ?>
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

<!-- Continue Reading Section -->
<div class="continue-reading">
    <div class="container" style="max-width: 900px; margin: 0 auto;">
        <h3 class="continue-title">Continue Reading</h3>
        <a href="blogs.php" class="continue-button">
            View All Articles
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="5" y1="12" x2="19" y2="12"></line>
                <polyline points="12 5 19 12 12 19"></polyline>
            </svg>
        </a>
    </div>
</div>

<script>
    // Function to set reply target
    function setReplyTo(commentId, authorName) {
        document.getElementById('parent_id').value = commentId;
        document.getElementById('comment').focus();
        document.getElementById('comment').placeholder = 'Reply to ' + authorName + '...';
        
        // Scroll to comment form
        document.querySelector('.comment-form').scrollIntoView({ 
            behavior: 'smooth',
            block: 'start'
        });
        
        // Highlight the form
        document.querySelector('.comment-form').style.borderColor = 'var(--primary)';
        document.querySelector('.comment-form').style.boxShadow = '0 0 0 2px rgba(255, 51, 51, 0.2)';
        
        // Remove highlight after 2 seconds
        setTimeout(function() {
            document.querySelector('.comment-form').style.borderColor = 'var(--border)';
            document.querySelector('.comment-form').style.boxShadow = 'none';
        }, 2000);
    }

    // Reset reply if clicking in comment field
    document.getElementById('comment').addEventListener('focus', function() {
        if (this.placeholder.includes('Reply to')) {
            this.placeholder = 'Share your thoughts...';
            document.getElementById('parent_id').value = 0;
        }
    });

    // Form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const name = document.getElementById('name').value.trim();
        const comment = document.getElementById('comment').value.trim();
        
        if (!name || !comment) {
            e.preventDefault();
            alert('Please fill in all required fields.');
            return false;
        }
    });

    // Scroll reveal animation for comments
    const commentObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.1 });

    // Apply animation to comments
    document.querySelectorAll('.comment').forEach(comment => {
        comment.style.opacity = '0';
        comment.style.transform = 'translateY(20px)';
        comment.style.transition = 'all 0.6s ease';
        commentObserver.observe(comment);
    });
</script>

<?php include 'includes/footer.php'; ?>