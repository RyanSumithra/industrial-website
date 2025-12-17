<?php 
// --- SETUP ---
ini_set('display_errors', 1);
error_reporting(E_ALL);

$current_page = 'blogs';
$page_title = 'Latest News - IndustrialTech';

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

$res = $conn->query("SELECT blog_id FROM blog_likes WHERE user_ip='$user_ip'");
while ($r = $res->fetch_assoc()) {
    $likedBlogs[] = $r['blog_id'];
}
?>

<style>
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
    margin: 0;
    overflow-x: hidden;
}

/* HERO */
.blog-hero {
    min-height: 40vh;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 100px 5%;
    text-align: center;
    background: #000;
    border-bottom: 1px solid var(--border);
}

.blog-hero-overlay {
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at 50% 50%, rgba(255, 51, 51, 0.1), rgba(0, 0, 0, 0.95));
}

.blog-hero-content {
    position: relative;
    z-index: 2;
}

.blog-title {
    font-size: clamp(2.5rem, 5vw, 4.5rem);
    font-weight: 900;
    text-transform: uppercase;
}

.blog-title span {
    color: var(--primary);
}

.blog-subtitle {
    color: var(--text-muted);
    max-width: 600px;
    margin: 20px auto 40px;
}

/* SEARCH */
.search-container {
    max-width: 800px;
    margin: 0 auto;
}

.search-form {
    display: flex;
    border: 1px solid var(--border);
    background: var(--surface);
}

.search-input {
    flex: 1;
    padding: 20px;
    background: transparent;
    border: none;
    color: white;
    outline: none;
}

.search-button {
    background: var(--primary);
    border: none;
    padding: 0 40px;
    color: white;
    font-weight: 700;
    cursor: pointer;
}

/* GRID */
.blog-section {
    padding: 100px 5%;
    max-width: 1400px;
    margin: auto;
}

.blog-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
    gap: 30px;
}

.blog-card {
    position: relative;
    background: var(--surface);
    border: 1px solid var(--border);
    transition: 0.4s;
    overflow: hidden;
}

.blog-card:hover {
    transform: translateY(-8px);
    border-color: var(--primary);
}

.blog-image {
    height: 250px;
    background-size: cover;
    background-position: center;
    border-bottom: 1px solid var(--border);
}

.blog-content {
    padding: 30px;
}

.blog-meta {
    display: flex;
    justify-content: space-between;
    font-size: 0.8rem;
}

.blog-category {
    color: var(--primary);
    font-weight: 700;
}

.blog-date {
    color: var(--text-muted);
}

.blog-card-title {
    font-size: 1.5rem;
    margin: 15px 0;
}

.blog-excerpt {
    color: #999;
    margin-bottom: 30px;
}

.blog-read-more {
    color: white;
    text-decoration: none;
    text-transform: uppercase;
    font-weight: 600;
}

/* LIKE */
.blog-like {
    position: absolute;
    bottom: 20px;
    right: 20px;
    display: flex;
    align-items: center;
    gap: 6px;
    cursor: pointer;
}

.blog-like svg {
    width: 22px;
    height: 22px;
    fill: none;
    stroke: #888;
    stroke-width: 2;
    transition: 0.3s;
}

.blog-like svg.liked {
    fill: var(--primary);
    stroke: var(--primary);
    transform: scale(1.1);
}

.like-count {
    font-size: 0.8rem;
    color: #aaa;
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
                    : "background:#111";
        ?>
        <article class="blog-card">
            <div class="blog-image" style="<?php echo $img; ?>"></div>

            <div class="blog-content">
                <div class="blog-meta">
                    <span class="blog-category">Update</span>
                    <span class="blog-date"><?php echo date('M d, Y', strtotime($row['created_at'])); ?></span>
                </div>

                <h3 class="blog-card-title"><?php echo htmlspecialchars($row['title']); ?></h3>
                <p class="blog-excerpt"><?php echo substr(strip_tags($row['content']), 0, 140); ?>...</p>

                <a href="blog-details.php?id=<?php echo $row['id']; ?>" class="blog-read-more">Read Article →</a>
            </div>

            <div class="blog-like" data-id="<?php echo $row['id']; ?>" onclick="toggleLike(this)">
                <svg class="<?php echo in_array($row['id'], $likedBlogs) ? 'liked' : ''; ?>" viewBox="0 0 24 24">
                    <path d="M12 21s-6.7-4.35-9.33-7.07A5.5 5.5 0 0 1 12 5.1a5.5 5.5 0 0 1 9.33 8.83C18.7 16.65 12 21 12 21z"/>
                </svg>
                <span class="like-count"><?php echo $row['likes_count']; ?></span>
            </div>
        </article>
        <?php endwhile; endif; ?>
    </div>
</section>

<script>
function toggleLike(el) {
    const blogId = el.dataset.id;
    const heart = el.querySelector('svg');
    const countEl = el.querySelector('.like-count');

    fetch('like_blog.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'blog_id=' + blogId
    })
    .then(res => res.json())
    .then(data => {
        heart.classList.toggle('liked', data.liked);
        countEl.innerText = data.count;
    });
}
</script>

<?php include 'includes/footer.php'; ?>
