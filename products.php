<?php
// -------------------- SETUP --------------------
ini_set('display_errors', 1);
error_reporting(E_ALL);

$current_page = 'products';
$page_title = 'Our Products | Industrial Intelligence';

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
    /* Product Page Styles matching Homepage */
    .products-hero {
        min-height: 70vh;
        position: relative;
        display: flex;
        align-items: center;
        overflow: hidden;
        border-bottom: 1px solid var(--border);
        padding: 80px 5%;
        background: linear-gradient(180deg, #000 0%, #111 100%);
    }
    
    .products-hero-content {
        position: relative;
        z-index: 10;
        max-width: 1400px;
        margin: 0 auto;
        width: 100%;
        text-align: center;
    }
    
    .search-section {
        padding: 60px 5%;
        background: var(--surface);
        border-bottom: 1px solid var(--border);
    }
    
    .search-container {
        max-width: 800px;
        margin: 0 auto;
        position: relative;
    }
    
    .search-form {
        display: flex;
        gap: 15px;
        align-items: center;
    }
    
    .search-input {
        flex: 1;
        padding: 20px 25px;
        background: var(--bg);
        border: 1px solid var(--border);
        color: var(--text);
        font-family: 'Inter', system-ui, sans-serif;
        font-size: 1rem;
        border-radius: 0;
        transition: 0.3s;
    }
    
    .search-input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 2px rgba(255, 51, 51, 0.1);
    }
    
    .search-btn {
        padding: 20px 40px;
        background: var(--primary);
        color: white;
        font-weight: 700;
        text-transform: uppercase;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: 0.3s;
        font-size: 0.9rem;
        letter-spacing: 1px;
        white-space: nowrap;
    }
    
    .search-btn:hover {
        background: var(--primary-dim);
        box-shadow: 0 0 30px rgba(255, 51, 51, 0.3);
    }
    
    .clear-search {
        padding: 20px 30px;
        background: transparent;
        border: 1px solid var(--border);
        color: var(--text-muted);
        font-weight: 600;
        text-transform: uppercase;
        cursor: pointer;
        transition: 0.3s;
        font-size: 0.9rem;
        letter-spacing: 1px;
    }
    
    .clear-search:hover {
        border-color: var(--primary);
        color: var(--primary);
    }
    
    .search-results-info {
        margin-top: 20px;
        color: var(--text-muted);
        font-size: 0.9rem;
        text-align: center;
    }
    
    .search-results-info strong {
        color: var(--primary);
    }
    
    /* Products Grid - Matching Bento Grid Style */
    .products-section {
        padding: 100px 5%;
        background: var(--bg);
    }
    
    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 30px;
        max-width: 1400px;
        margin: 0 auto;
    }
    
    .product-card {
        background: var(--surface);
        border: 1px solid var(--border);
        position: relative;
        overflow: hidden;
        transition: 0.4s;
        min-height: 400px;
        display: flex;
        flex-direction: column;
    }
    
    .product-card:hover {
        border-color: var(--primary);
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
    }
    
    .product-image {
        height: 250px;
        width: 100%;
        overflow: hidden;
        background: #000;
        position: relative;
    }
    
    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }
    
    .product-card:hover .product-image img {
        transform: scale(1.1);
    }
    
    .product-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(0deg, rgba(0,0,0,0.9) 20%, rgba(0,0,0,0.4) 100%);
        z-index: 1;
    }
    
    .product-content {
        padding: 30px;
        position: relative;
        z-index: 2;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    
    .product-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 15px;
        color: white;
        line-height: 1.3;
    }
    
    .product-description {
        color: #ccc;
        line-height: 1.6;
        font-size: 0.95rem;
        margin-bottom: 20px;
        flex-grow: 1;
    }
    
    .product-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-top: auto;
    }
    
    .btn-details {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 15px;
        background: transparent;
        border: 1px solid var(--border);
        color: white;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: 0.3s;
    }
    
    .btn-details:hover {
        border-color: white;
        background: rgba(255, 255, 255, 0.05);
    }
    
    .btn-enquire {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 15px;
        background: var(--primary);
        border: 1px solid var(--primary);
        color: white;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: 0.3s;
    }
    
    .btn-enquire:hover {
        background: var(--primary-dim);
        border-color: var(--primary-dim);
        box-shadow: 0 0 20px rgba(255, 51, 51, 0.3);
    }
    
    .no-products {
        grid-column: 1 / -1;
        text-align: center;
        padding: 60px;
        border: 1px dashed var(--border);
        border-radius: 8px;
        background: var(--surface);
    }
    
    .no-products h3 {
        color: var(--text-muted);
        font-size: 1.5rem;
        margin-bottom: 10px;
    }
    
    .no-products p {
        color: var(--text-muted);
        opacity: 0.7;
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .products-hero {
            min-height: 50vh;
            padding: 60px 5%;
        }
        
        .search-form {
            flex-direction: column;
        }
        
        .search-input,
        .search-btn,
        .clear-search {
            width: 100%;
            justify-content: center;
            box-sizing: border-box;
        }
        
        .products-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }
        
        .product-actions {
            grid-template-columns: 1fr;
        }
    }
    
    @media (max-width: 1024px) {
        .products-grid {
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        }
    }
</style>

<div class="noise-overlay"></div>

<section class="products-hero">
    <div class="hero-overlay" style="background: radial-gradient(circle at 70% 30%, rgba(20,20,20,0) 0%, var(--bg) 90%);"></div>
    
    <div class="products-hero-content reveal">
        <span class="label-mono">/// OUR CATALOG</span>
        
        <h1 class="display-1" style="font-size: clamp(2rem, 6vw, 4rem); margin-bottom: 1.5rem;">
            INDUSTRIAL<br>
            <span class="outline-text">PRODUCTS</span>
        </h1>
        
        <p class="lead-text" style="margin: 0 auto; max-width: 700px;">
            Explore our range of high-performance components engineered for absolute reliability in advanced automation systems.
        </p>
    </div>
</section>

<section class="search-section">
    <div class="search-container reveal">
        <form method="GET" action="products.php" class="search-form">
            <input 
                type="text" 
                name="search" 
                placeholder="Search products by name or description..." 
                class="search-input"
                value="<?php echo htmlspecialchars($search_query); ?>"
                autocomplete="off"
            >
            <button type="submit" class="search-btn">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 10px;">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                Search
            </button>
            <?php if (!empty($search_query)): ?>
                <button type="button" onclick="window.location.href='products.php'" class="clear-search">
                    Clear Search
                </button>
            <?php endif; ?>
        </form>
        
        <?php if (!empty($search_query)): ?>
            <div class="search-results-info reveal">
                Showing results for: <strong>"<?php echo htmlspecialchars($search_query); ?>"</strong>
            </div>
        <?php endif; ?>
    </div>
</section>

<section class="products-section">
    <div class="reveal" style="margin-bottom: 60px;">
        <span class="label-mono">/// PRODUCT COLLECTION</span>
        <h2 class="display-2">Engineered for<br>Maximum Performance.</h2>
    </div>

    <div class="products-grid reveal">
        <?php
        if (!$conn) {
            echo '<div class="no-products">
                    <h3>Database connection failed</h3>
                    <p>Please try again later</p>
                  </div>';
        } else {
            // Prepare and execute query with search
            if (!empty($where_clause)) {
                $sql = "SELECT id, name, description, image_path FROM products $where_clause ORDER BY id DESC";
                $stmt = $conn->prepare($sql);
                if ($params) {
                    $stmt->bind_param($param_types, ...$params);
                }
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
                    
                    // Highlight search terms in description
                    $desc = htmlspecialchars($row['description']);
                    if (!empty($search_query)) {
                        $desc = preg_replace("/(" . preg_quote($search_query, '/') . ")/i", "<strong style='color: var(--primary);'>$1</strong>", $desc);
                    }
                    
                    // Limit description length
                    if (strlen(strip_tags($desc)) > 150) {
                        $descPreview = substr(strip_tags($desc), 0, 150) . '...';
                        $fullDesc = $desc;
                        $showReadMore = true;
                    } else {
                        $descPreview = $desc;
                        $fullDesc = $desc;
                        $showReadMore = false;
                    }
                    ?>
                    
                    <div class="product-card">
                        <div class="product-image">
                            <div class="product-overlay"></div>
                            <img src="<?php echo $imageUrl; ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" 
                                 onerror="this.src='assets/placeholder.jpg'">
                        </div>
                        
                        <div class="product-content">
                            <h3 class="product-title">
                                <?php 
                                $name = htmlspecialchars($row['name']);
                                if (!empty($search_query)) {
                                    $name = preg_replace("/(" . preg_quote($search_query, '/') . ")/i", "<strong style='color: var(--primary);'>$1</strong>", $name);
                                }
                                echo $name;
                                ?>
                            </h3>
                            
                            <div class="product-description">
                                <?php echo $descPreview; ?>
                                <?php if ($showReadMore): ?>
                                    <span class="read-more" style="color: var(--primary); cursor: pointer;" 
                                          onclick="this.parentElement.innerHTML = '<?php echo addslashes($fullDesc); ?>'">
                                        ... Read more
                                    </span>
                                <?php endif; ?>
                            </div>
                            
                            <div class="product-actions">
                                <a href="product-details.php?id=<?php echo $row['id']; ?>" class="btn-details">
                                    View Details
                                </a>
                                <a href="contact.php?product=<?php echo urlencode($row['name']); ?>" class="btn-enquire">
                                    Request Quote
                                </a>
                            </div>
                        </div>
                    </div>

                    <?php
                }
                
                // Free result
                if (isset($stmt)) {
                    $stmt->close();
                }
            } else {
                ?>
                <div class="no-products">
                    <h3><?php echo empty($search_query) ? 'No products available' : 'No products found'; ?></h3>
                    <p><?php echo empty($search_query) ? 'Check back later for updates to our catalog.' : 'Try different search terms.'; ?></p>
                    <?php if (!empty($search_query)): ?>
                        <a href="products.php" class="btn-details" style="margin-top: 20px; display: inline-block;">
                            View All Products
                        </a>
                    <?php endif; ?>
                </div>
                <?php
            }
        }
        ?>
    </div>
</section>

<script>
    // Scroll Reveal Observer (same as homepage)
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if(entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));

    // Parallax effect for hero
    if (window.innerWidth > 900) {
        window.addEventListener('scroll', () => {
            const scrolled = window.scrollY;
            const heroOverlay = document.querySelector('.products-hero .hero-overlay');
            if(heroOverlay) {
                heroOverlay.style.transform = `translateY(${scrolled * 0.5}px)`;
            }
        });
    }

    // Auto-focus search input if search was performed
    <?php if (!empty($search_query)): ?>
    document.querySelector('input[name="search"]').focus();
    <?php endif; ?>
</script>

<?php include 'includes/footer.php'; ?>