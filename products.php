<?php
// -------------------- SETUP --------------------
ini_set('display_errors', 1);
error_reporting(E_ALL);

$current_page = 'products';
$page_title = 'Our Products | ' . (defined('SITE_NAME') ? SITE_NAME : 'Industrial Intelligence');

// Config
require_once 'includes/config.php';
require_once 'includes/db.php';
include 'includes/header.php';

// Search functionality
$search_query = '';
$where_clause = '';
$params = [];
$param_types = '';

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_query = $conn->real_escape_string($_GET['search']);
    $where_clause = " WHERE name LIKE ? OR description LIKE ? ";
    $params = ["%$search_query%", "%$search_query%"];
    $param_types = "ss";
}
?>

<style>
    /* --- PAGE SPECIFIC STYLES --- */
    
    /* HERO SECTION */
    .products-hero {
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

    /* Background Pattern (Tech Grid) */
    .products-hero::before {
        content: ''; position: absolute; inset: 0;
        background-image: 
            linear-gradient(var(--border-color) 1px, transparent 1px),
            linear-gradient(90deg, var(--border-color) 1px, transparent 1px);
        background-size: 50px 50px;
        opacity: 0.1;
        z-index: 0;
    }

    .products-hero-overlay {
        position: absolute; inset: 0;
        background: radial-gradient(circle at 50% 50%, rgba(255, 51, 51, 0.05), var(--bg-body) 80%);
        z-index: 1;
    }

    .products-hero-content {
        position: relative; z-index: 2;
        width: 100%; max-width: 900px;
    }

    .hero-title {
        font-size: clamp(2.5rem, 6vw, 4.5rem);
        font-weight: 900;
        text-transform: uppercase;
        color: var(--text-main);
        margin-bottom: 15px;
        letter-spacing: -1px;
    }

    .hero-title span { color: var(--primary-red); }

    .hero-subtitle {
        color: var(--text-muted);
        font-size: 1.1rem;
        max-width: 650px;
        margin: 0 auto 40px;
        line-height: 1.6;
    }

    /* SEARCH BAR (Pill Style) */
    .search-container {
        max-width: 700px; margin: 0 auto; position: relative;
    }

    .search-form {
        display: flex;
        border: 1px solid var(--border-color);
        background: var(--bg-surface);
        border-radius: 50px;
        padding: 6px;
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

    .search-btn {
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
        display: flex; align-items: center; gap: 8px;
    }

    .search-btn:hover { background: var(--text-main); color: var(--bg-body); }

    .search-info {
        margin-top: 15px; font-size: 0.9rem; color: var(--text-muted);
    }
    .search-info strong { color: var(--primary-red); }
    .clear-link { color: var(--text-main); text-decoration: underline; margin-left: 10px; font-size: 0.85rem; }

    /* PRODUCTS GRID */
    .products-section {
        padding: 80px 5%;
        background: var(--bg-body);
    }

    .products-grid {
        display: grid;
        /* Responsive: Min 300px width per card */
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 30px;
        max-width: 1400px; margin: 0 auto;
    }

    /* Mobile Grid Adjustment */
    @media (max-width: 480px) {
        .products-grid { grid-template-columns: 1fr; }
    }

    .product-card {
        background: var(--bg-surface-2);
        border: 1px solid var(--border-color);
        border-radius: 6px;
        overflow: hidden;
        display: flex; flex-direction: column;
        transition: 0.4s ease;
        position: relative;
    }

    .product-card:hover {
        transform: translateY(-8px);
        border-color: var(--primary-red);
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    }
    
    /* Light mode shadow fix */
    body.light-mode .product-card:hover { box-shadow: 0 20px 40px rgba(0,0,0,0.1); }

    .product-image {
        height: 240px;
        width: 100%;
        background: #000;
        position: relative;
        overflow: hidden;
        border-bottom: 1px solid var(--border-color);
    }

    .product-image img {
        width: 100%; height: 100%; object-fit: cover;
        transition: transform 0.6s ease;
    }
    
    .product-card:hover .product-image img { transform: scale(1.1); }

    .product-overlay {
        position: absolute; inset: 0;
        background: linear-gradient(0deg, rgba(0,0,0,0.8) 0%, transparent 60%);
        z-index: 1; pointer-events: none;
    }

    .product-content {
        padding: 30px;
        display: flex; flex-direction: column; flex-grow: 1;
    }

    .product-title {
        font-size: 1.4rem; font-weight: 700;
        margin-bottom: 15px; color: var(--text-main);
        line-height: 1.3;
    }

    .product-description {
        color: var(--text-muted);
        font-size: 0.95rem; line-height: 1.6;
        margin-bottom: 25px; flex-grow: 1;
    }

    /* Buttons */
    .product-actions {
        display: grid; grid-template-columns: 1fr 1fr; gap: 15px;
        margin-top: auto;
    }

    .btn-card {
        padding: 12px; text-align: center;
        font-size: 0.8rem; font-weight: 700; text-transform: uppercase;
        border-radius: 4px; text-decoration: none; transition: 0.3s;
        letter-spacing: 0.5px;
    }

    /* Details Button (Outline) */
    .btn-details {
        border: 1px solid var(--border-color); color: var(--text-main);
        background: transparent;
    }
    .btn-details:hover { border-color: var(--text-main); background: var(--bg-surface); }

    /* Enquire Button (Solid) */
    .btn-enquire {
        background: var(--primary-red); color: white; border: 1px solid var(--primary-red);
    }
    .btn-enquire:hover {
        background: transparent; color: var(--primary-red);
    }

    /* Empty State */
    .no-results {
        grid-column: 1 / -1;
        text-align: center; padding: 80px 20px;
        border: 1px dashed var(--border-color);
        background: var(--bg-surface); border-radius: 8px;
    }
    .no-results h3 { color: var(--text-main); margin-bottom: 10px; }
    .no-results p { color: var(--text-muted); }

</style>

<section class="products-hero">
    <div class="products-hero-overlay"></div>
    
    <div class="products-hero-content reveal">
        <h1 class="hero-title">Industrial <span>Catalog</span></h1>
        <p class="hero-subtitle">
            Browse our range of high-performance automation components, PLCs, and custom engineered hardware.
        </p>

        <div class="search-container">
            <form method="GET" action="products.php" class="search-form">
                <input 
                    type="text" 
                    name="search" 
                    class="search-input"
                    placeholder="Search by name or keyword..." 
                    value="<?php echo htmlspecialchars($search_query); ?>"
                    autocomplete="off"
                >
                <button type="submit" class="search-btn">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    Search
                </button>
            </form>
            
            <?php if (!empty($search_query)): ?>
                <div class="search-info">
                    Results for: <strong>"<?php echo htmlspecialchars($search_query); ?>"</strong>
                    <a href="products.php" class="clear-link">Clear Filter</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="products-section">
    <div class="products-grid reveal">
        <?php
        if (!$conn) {
            echo '<div class="no-results"><h3>System Error</h3><p>Database connection unavailable.</p></div>';
        } else {
            // Prepared Statement logic
            if (!empty($where_clause)) {
                $sql = "SELECT id, name, description, image_path FROM products $where_clause ORDER BY id DESC";
                $stmt = $conn->prepare($sql);
                if ($params) $stmt->bind_param($param_types, ...$params);
                $stmt->execute();
                $result = $stmt->get_result();
            } else {
                $sql = "SELECT id, name, description, image_path FROM products ORDER BY id DESC";
                $result = $conn->query($sql);
            }

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $imagePath = 'uploads/' . $row['image_path'];
                    $imageUrl = (!empty($row['image_path']) && file_exists($imagePath)) ? $imagePath : 'assets/placeholder.jpg';
                    
                    // Highlight logic
                    $name = htmlspecialchars($row['name']);
                    $desc = htmlspecialchars($row['description']);
                    
                    if (!empty($search_query)) {
                        $hl = "<strong style='color: var(--primary-red); background: rgba(255,51,51,0.1);'>$1</strong>";
                        $name = preg_replace("/(" . preg_quote($search_query, '/') . ")/i", $hl, $name);
                        $desc = preg_replace("/(" . preg_quote($search_query, '/') . ")/i", $hl, $desc);
                    }
                    
                    // Truncate Description
                    $descPreview = (strlen(strip_tags($row['description'])) > 120) 
                        ? substr(strip_tags($desc), 0, 120) . '...' 
                        : $desc;
                    ?>
                    
                    <div class="product-card">
                        <div class="product-image">
                            <div class="product-overlay"></div>
                            <img src="<?php echo $imageUrl; ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" 
                                 onerror="this.src='assets/placeholder.jpg'">
                        </div>
                        
                        <div class="product-content">
                            <h3 class="product-title"><?php echo $name; ?></h3>
                            <div class="product-description"><?php echo $descPreview; ?></div>
                            
                            <div class="product-actions">
                                <a href="product-details.php?id=<?php echo $row['id']; ?>" class="btn-card btn-details">
                                    Details
                                </a>
                                <a href="contact.php?product=<?php echo urlencode($row['name']); ?>" class="btn-card btn-enquire">
                                    Quote
                                </a>
                            </div>
                        </div>
                    </div>

                    <?php
                }
                if (isset($stmt)) $stmt->close();
            } else {
                ?>
                <div class="no-results">
                    <h3>No Products Found</h3>
                    <p>We couldn't find anything matching your search. <a href="products.php" style="color: var(--primary-red);">View all products</a>.</p>
                </div>
                <?php
            }
        }
        ?>
    </div>
</section>

<script>
    // Scroll Animation
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if(entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));

    // Parallax
    if (window.innerWidth > 900) {
        window.addEventListener('scroll', () => {
            const scrolled = window.scrollY;
            const heroOverlay = document.querySelector('.products-hero-overlay');
            if(heroOverlay) {
                heroOverlay.style.transform = `translateY(${scrolled * 0.4}px)`;
            }
        });
    }
</script>

<?php include 'includes/footer.php'; ?>