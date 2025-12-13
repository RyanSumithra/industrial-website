<?php 
// 1. Define page variables so the navbar knows which link to highlight
$current_page = 'products';
$page_title = 'Our Products - IndustrialTech';

// 2. Connect to the database
include 'includes/db.php';

// 3. THIS LINE ADDS THE NAVBAR AND HEAD TAGS
include 'includes/header.php'; 
?>

<div class="hero" style="padding: 60px 0;">
    <div class="container">
        <div class="hero-content">
            <h1>Industrial Products</h1>
            <p>High-performance components for automation systems.</p>
        </div>
    </div>
</div>

<section class="section">
    <div class="container">
        <div class="projects-grid"> 
            <?php
            $sql = "SELECT * FROM products ORDER BY id DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    // Check if image exists, otherwise show a placeholder color
                    $bgStyle = (!empty($row['image'])) ? "background-image: url('uploads/".$row['image']."');" : "background-color: #ddd;";
                    
                    echo '
                    <div class="project-card">
                        <div class="project-image" style="'.$bgStyle.' background-size: cover; background-position: center;">
                            </div>
                        <div class="project-content">
                            <div class="project-category">$'.$row['price'].'</div>
                            <h3>'.$row['title'].'</h3>
                            <p>'.$row['description'].'</p>
                            <a href="contact.php?product='.$row['id'].'" class="btn btn-secondary" style="padding: 8px 16px; font-size: 0.9rem;">Enquire Now</a>
                        </div>
                    </div>';
                }
            } else {
                echo "<p>No products available at the moment.</p>";
            }
            ?>
        </div>
    </div>
</section>

<?php 
// 4. THIS LINE ADDS THE FOOTER
include 'includes/footer.php'; 
?>