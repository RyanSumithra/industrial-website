<?php 
// --- SETUP ---
ini_set('display_errors', 1);
error_reporting(E_ALL);

$current_page = 'blogs';
$page_title = 'Latest News - ' . (defined('SITE_NAME') ? SITE_NAME : 'IndustrialTech');

if (file_exists('includes/config.php')) include 'includes/config.php';
if (!defined('BASE_URL')) define('BASE_URL', 'http://localhost/asiaTech-website/');
if (!file_exists('includes/db.php')) die("Error: DB file missing.");

include 'includes/db.php';
include 'includes/header.php'; 

// --- SEARCH FUNCTIONALITY ---
$search_query = '';
$where_clause = '';

if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
    $search_query = $conn->real_escape_string(trim($_GET['search']));
    $where_clause = "WHERE title LIKE '%$search_query%' OR content LIKE '%$search_query%'";
}

// --- LIKE DATA ---
$user_ip = $_SERVER['REMOTE_ADDR'];
$likedBlogs = [];

// Check if table exists before querying to prevent fatal errors on fresh installs
$checkTable = $conn->query("SHOW TABLES LIKE 'blog_likes'");
if($checkTable && $checkTable->num_rows > 0) {
    $res = $conn->query("SELECT blog_id FROM blog_likes WHERE user_ip='$user_ip'");
    if($res) {
        while ($r = $res->fetch_assoc()) {
            $likedBlogs[] = $r['blog_id'];
        }
    }
}
?>

<style>
/* --- PAGE SPECIFIC STYLES --- */
/* Note: Core colors come from header.php variables */

/* HERO SECTION */
.blog-hero {
    min-height: 40vh;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 120px 5% 80px;
    text-align: center;
    background: var(--bg-body);
    border-bottom: 1px solid var(--border-color);
    overflow: hidden;
}

/* Background Pattern */
.blog-hero::before {
    content: ''; position: absolute; inset: 0;
    background-image: 
        linear-gradient(var(--border-color) 1px, transparent 1px),
        linear-gradient(90deg, var(--border-color) 1px, transparent 1px);
    background-size: 50px 50px;
    opacity: 0.1;
    z-index: 0;
}

.blog-hero-overlay {
    position: absolute;
    inset: 0;
    /* Adaptive Gradient */
    background: radial-gradient(circle at 50% 50%, rgba(255, 51, 51, 0.05), var(--bg-body) 80%);
    z-index: 1;
}

.blog-hero-content {
    position: relative;
    z-index: 2;
    width: 100%;
    max-width: 800px;
}

.blog-title {
    font-size: clamp(2.5rem, 6vw, 4.5rem);
    font-weight: 900;
    text-transform: uppercase;
    color: var(--text-main);
    margin-bottom: 10px;
    letter-spacing: -1px;
}

.blog-title span {
    color: var(--primary-red);
}

.blog-subtitle {
    color: var(--text-muted);
    font-size: 1.1rem;
    max-width: 600px;
    margin: 0 auto 40px;
    line-height: 1.6;
}

/* SEARCH BAR */
.search-container {
    max-width: 600px;
    margin: 0 auto;
    position: relative;
}

.search-form {
    display: flex;
    border: 1px solid var(--border-color);
    background: var(--bg-surface);
    border-radius: 50px;
    padding: 5px;
    transition: 0.3s;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.search-form:focus-within {
    border-color: var(--primary-red);
    box-shadow: 0 10px 30px rgba(255, 51, 51, 0.15);
}

.search-input {
    flex: 1;
    padding: 15px 25px;
    background: transparent;
    border: none;
    color: var(--text-main);
    font-size: 1rem;
    outline: none;
}

.search-button {
    background: var(--primary-red);
    border: none;
    padding: 0 35px;
    color: white;
    font-weight: 700;
    border-radius: 50px;
    cursor: pointer;
    transition: 0.3s;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 1px;
}

.search-button:hover {
    background: var(--text-main);
    color: var(--bg-body);
}

/* BLOG GRID SECTION */
.blog-section {
    padding: 80px 5%;
    max-width: 1400px;
    margin: auto;
    background: var(--bg-body);
}

.blog-grid {
    display: grid;
    /* Responsive Grid: Cards shrink to 280px before stacking */
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 30px;
}

/* Mobile Adjustment for Grid */
@media (max-width: 480px) {
    .blog-grid {
        grid-template-columns: 1fr;
    }
}

.blog-card {
    position: relative;
    background: var(--bg-surface-2);
    border: 1px solid var(--border-color);
    transition: all 0.4s ease;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    border-radius: 4px;
}

.blog-card:hover {
    transform: translateY(-8px);
    border-color: var(--primary-red);
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
}

/* Light Mode Shadow Adjustment */
body.light-mode .blog-card:hover {
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
}

.blog-image {
    height: 220px;
    background-size: cover;
    background-position: center;
    border-bottom: 1px solid var(--border-color);
    position: relative;
}

.blog-image::after {
    content: '';
    position: absolute; inset: 0;
    background: rgba(0,0,0,0.2); /* Slight overlay on images */
    transition: 0.3s;
}
.blog-card:hover .blog-image::after { opacity: 0; }

.blog-content {
    padding: 30px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.blog-meta {
    display: flex;
    justify-content: space-between;
    font-size: 0.75rem;
    margin-bottom: 15px;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-weight: 600;
}

.blog-category {
    color: var(--primary-red);
}

.blog-date {
    color: var(--text-muted);
}

.blog-card-title {
    font-size: 1.35rem;
    margin: 0 0 15px 0;
    color: var(--text-main);
    line-height: 1.3;
    font-weight: 800;
}

.blog-excerpt {
    color: var(--text-muted);
    margin-bottom: 30px;
    font-size: 0.95rem;
    line-height: 1.6;
    flex: 1;
}

.blog-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: auto;
    padding-top: 20px;
    border-top: 1px solid var(--border-color);
}

.blog-read-more {
    color: var(--text-main);
    text-decoration: none;
    text-transform: uppercase;
    font-weight: 700;
    font-size: 0.8rem;
    letter-spacing: 1px;
    transition: 0.3s;
}

.blog-read-more:hover {
    color: var(--primary-red);
}

/* LIKE BUTTON */
.blog-like {
    display: flex;
    align-items: center;
    gap: 6px;
    cursor: pointer;
    padding: 5px 10px;
    border-radius: 20px;
    transition: 0.3s;
}

.blog-like:hover {
    background: rgba(255, 51, 51, 0.1);
}

.blog-like svg {
    width: 20px;
    height: 20px;
    fill: none;
    stroke: var(--text-muted);
    stroke-width: 2;
    transition: 0.3s;
}

.blog-like svg.liked {
    fill: var(--primary-red);
    stroke: var(--primary-red);
    transform: scale(1.1);
}

.like-count {
    font-size: 0.85rem;
    color: var(--text-muted);
    font-weight: 600;
}

/* Mobile Responsive Tweaks */
@media (max-width: 768px) {
    .blog-hero { padding: 100px 5% 60px; }
    .search-input { padding: 12px 20px; font-size: 0.9rem; }
    .search-button { padding: 0 25px; font-size: 0.8rem; }
    .blog-section { padding: 40px 5%; }
}
</style>

<section class="blog-hero">
    <div class="blog-hero-overlay"></div>
    <div class="blog-hero-content">
        <h1 class="blog-title">INTELLIGENCE <span>HUB</span></h1>
        <p class="blog-subtitle">Technical breakdowns, automation insights, and industrial intelligence.</p>

        <div class="search-container">
            <form method="GET" class="search-form">
                <input type="text" name="search" class="search-input" placeholder="Search articles..." value="<?php echo htmlspecialchars($search_query); ?>">
                <button class="search-button">Search</button>
            </form>
        </div>
    </div>
</section>

<section class="blog-section">
    <div class="blog-grid">
        <?php
        $sql = "SELECT * FROM blogs $where_clause ORDER BY created_at DESC";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0):
            while ($row = $result->fetch_assoc()):
                $img = (!empty($row['image']) && file_exists('uploads/'.$row['image']))
                    ? "background-image:url('uploads/{$row['image']}')"
                    : "background-image: linear-gradient(135deg, #111, #333)"; // Fallback gradient
                
                // Get clean excerpt
                $excerpt = strip_tags($row['content']);
                if(strlen($excerpt) > 120) $excerpt = substr($excerpt, 0, 120) . '...';
        ?>
        <article class="blog-card">
            <div class="blog-image" style="<?php echo $img; ?>"></div>

            <div class="blog-content">
                <div class="blog-meta">
                    <span class="blog-category">Update</span>
                    <span class="blog-date"><?php echo date('M d, Y', strtotime($row['created_at'])); ?></span>
                </div>

                <h3 class="blog-card-title"><?php echo htmlspecialchars($row['title']); ?></h3>
                <p class="blog-excerpt"><?php echo $excerpt; ?></p>

                <div class="blog-footer">
                    <a href="blog-details.php?id=<?php echo $row['id']; ?>" class="blog-read-more">Read Article →</a>
                    
                    <div class="blog-like" data-id="<?php echo $row['id']; ?>" onclick="toggleLike(this)">
                        <svg class="<?php echo in_array($row['id'], $likedBlogs) ? 'liked' : ''; ?>" viewBox="0 0 24 24">
                            <path d="M12 21s-6.7-4.35-9.33-7.07A5.5 5.5 0 0 1 12 5.1a5.5 5.5 0 0 1 9.33 8.83C18.7 16.65 12 21 12 21z"/>
                        </svg>
                        <span class="like-count"><?php echo $row['likes_count']; ?></span>
                    </div>
                </div>
            </div>
        </article>
        <?php endwhile; ?>
        <?php else: ?>
            <div style="grid-column: 1/-1; text-align: center; padding: 60px; border: 1px dashed var(--border-color); color: var(--text-muted);">
                <h3 style="margin-bottom: 10px; color: var(--text-main);">No Articles Found</h3>
                <p>Try adjusting your search criteria or check back later.</p>
                <?php if(!empty($search_query)): ?>
                    <a href="blogs.php" style="color: var(--primary-red); text-decoration: none; font-weight: bold; margin-top: 10px; display: inline-block;">Clear Search</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<script>
function toggleLike(el) {
    const blogId = el.dataset.id;
    const heart = el.querySelector('svg');
    const countEl = el.querySelector('.like-count');

    // Optimistic UI update
    const isLiked = heart.classList.contains('liked');
    let currentCount = parseInt(countEl.innerText);
    
    heart.classList.toggle('liked');
    countEl.innerText = isLiked ? currentCount - 1 : currentCount + 1;

    fetch('like_blog.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'blog_id=' + blogId
    })
    .then(res => res.json())
    .then(data => {
        // Sync with server source of truth
        if(data.success) {
            heart.classList.toggle('liked', data.liked);
            countEl.innerText = data.count;
        }
    })
    .catch(err => {
        console.error('Like error:', err);
        // Revert on error
        heart.classList.toggle('liked');
        countEl.innerText = currentCount;
    });
}
</script>

<?php include 'includes/footer.php'; ?>