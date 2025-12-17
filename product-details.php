<?php
require_once 'includes/config.php';
require_once 'includes/db.php';

// Validate ID
if (!isset($_GET['id'])) {
    header("Location: products.php");
    exit;
}

$id = (int) $_GET['id'];
$result = $conn->query("SELECT * FROM products WHERE id = $id");

if (!$result || $result->num_rows === 0) {
    header("Location: products.php");
    exit;
}

$product = $result->fetch_assoc();
$page_title = $product['name'] . ' | Industrial Intelligence';

include 'includes/header.php';
?>

<style>
    .product-details-hero {
        min-height: 60vh;
        position: relative;
        display: flex;
        align-items: center;
        overflow: hidden;
        border-bottom: 1px solid var(--border);
        padding: 80px 5%;
        background: linear-gradient(180deg, #000 0%, #111 100%);
    }
    
    .product-details-hero-content {
        position: relative;
        z-index: 10;
        max-width: 1400px;
        margin: 0 auto;
        width: 100%;
    }
    
    .product-details-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 80px 5%;
        background: var(--bg);
    }
    
    .product-details-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: start;
    }
    
    .product-image-wrapper {
        position: relative;
        overflow: hidden;
        border: 1px solid var(--border);
        border-radius: 12px;
        background: #000;
    }
    
    .product-detail-image {
        width: 100%;
        height: 500px;
        object-fit: cover;
        transition: transform 0.6s ease;
    }
    
    .product-image-wrapper:hover .product-detail-image {
        transform: scale(1.05);
    }
    
    .product-info {
        display: flex;
        flex-direction: column;
        gap: 30px;
    }
    
    .product-detail-title {
        font-size: 3rem;
        font-weight: 900;
        color: white;
        line-height: 1.1;
        margin-bottom: 10px;
    }
    
    .product-detail-description {
        color: #ccc;
        font-size: 1.1rem;
        line-height: 1.8;
        white-space: pre-wrap;
    }
    
    .product-actions-row {
        display: flex;
        gap: 20px;
        margin-top: 30px;
    }
    
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 20px 40px;
        background: transparent;
        border: 1px solid var(--border);
        color: var(--text);
        text-decoration: none;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: 0.3s;
    }
    
    .btn-back:hover {
        border-color: var(--primary);
        color: var(--primary);
        gap: 15px;
    }
    
    .btn-enquire-large {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 20px 40px;
        background: var(--primary);
        border: 1px solid var(--primary);
        color: white;
        text-decoration: none;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: 0.3s;
    }
    
    .btn-enquire-large:hover {
        background: var(--primary-dim);
        border-color: var(--primary-dim);
        box-shadow: 0 0 30px rgba(255, 51, 51, 0.3);
    }
    
    /* Responsive Design */
    @media (max-width: 1024px) {
        .product-details-grid {
            grid-template-columns: 1fr;
            gap: 40px;
        }
        
        .product-detail-image {
            height: 400px;
        }
        
        .product-detail-title {
            font-size: 2.5rem;
        }
    }
    
    @media (max-width: 768px) {
        .product-details-hero {
            padding: 60px 5%;
            min-height: 50vh;
        }
        
        .product-details-container {
            padding: 60px 5%;
        }
        
        .product-detail-title {
            font-size: 2rem;
        }
        
        .product-detail-image {
            height: 300px;
        }
        
        .product-actions-row {
            flex-direction: column;
        }
        
        .btn-back,
        .btn-enquire-large {
            width: 100%;
            justify-content: center;
            text-align: center;
        }
    }
</style>

<div class="noise-overlay"></div>

<section class="product-details-hero">
    <div class="hero-overlay" style="background: radial-gradient(circle at 70% 30%, rgba(20,20,20,0) 0%, var(--bg) 90%);"></div>
    
    <div class="product-details-hero-content reveal">
        <span class="label-mono">/// PRODUCT DETAILS</span>
        <h1 class="display-1" style="font-size: clamp(2rem, 6vw, 4rem);">
            Technical<br>
            <span class="outline-text">Specifications</span>
        </h1>
    </div>
</section>

<div class="product-details-container">
    <div class="product-details-grid reveal">
        <div class="product-image-wrapper">
            <?php
            $img = 'uploads/' . $product['image_path'];
            if (!empty($product['image_path']) && file_exists($img)) {
                echo '<img src="'.$img.'" class="product-detail-image" alt="'.htmlspecialchars($product['name']).'"
                     onerror="this.src=\'assets/placeholder.jpg\'">';
            } else {
                echo '<img src="assets/placeholder.jpg" class="product-detail-image" alt="Product Image">';
            }
            ?>
        </div>
        
        <div class="product-info">
            <div>
                <h2 class="product-detail-title">
                    <?php echo htmlspecialchars($product['name']); ?>
                </h2>
                <span class="label-mono" style="color: var(--primary);">PRODUCT ID: <?php echo $product['id']; ?></span>
            </div>
            
            <div class="product-detail-description">
                <?php echo nl2br(htmlspecialchars($product['description'])); ?>
            </div>
            
            <div class="product-actions-row">
                <a href="products.php" class="btn-back">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                    Back to Products
                </a>
                
                <a href="contact.php?product=<?php echo urlencode($product['name']); ?>" class="btn-enquire-large">
                    Request Engineering Consultation
                </a>
            </div>
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
</script>

<?php include 'includes/footer.php'; ?>
