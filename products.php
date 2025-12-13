<?php 
// --- SETUP ---
ini_set('display_errors', 1);
error_reporting(E_ALL);

$current_page = 'products';
$page_title = 'Our Products - IndustrialTech';

if (file_exists('includes/config.php')) include 'includes/config.php';
if (!defined('BASE_URL')) define('BASE_URL', 'http://localhost/asiaTech-website/');
if (!file_exists('includes/db.php')) die("Error: DB file missing.");

include 'includes/db.php';
include 'includes/header.php'; 
?>

<div class="hero blogheader" style="
    background: linear-gradient(180deg, #000 0%, #111 100%); 
    padding: 50px 0 30px; 
    border-bottom: 1px solid #222;
">
    <div class="container" style="text-align: center;">
        <h1 style="font-size: 2.5rem; font-weight: 800; letter-spacing: -1px; margin-bottom: 0.5rem; line-height: 1.1;">
            INDUSTRIAL <span style="color: var(--primary-red);">SOLUTIONS</span>
        </h1>
        <p style="color: #888; font-size: 1rem; max-width: 600px; margin: 0 auto;">
            High-performance components for advanced automation.
        </p>
    </div>
</div>

<section class="section" style="padding: 40px 0;">
    <div class="container">
        
        <div class="projects-grid"> 
            <?php
            if (isset($conn) && $conn) {
                $sql = "SELECT * FROM products ORDER BY id DESC";
                $result = $conn->query($sql);

                if ($result && $result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        
                        // Image Handler
                        $imgFile = 'uploads/' . $row['image'];
                        $bgStyle = (!empty($row['image']) && file_exists($imgFile)) 
                                    ? "background-image: url('$imgFile');" 
                                    : "background: #222;";
                        
                        // Price Formatting
                        $price = number_format($row['price'], 2);

                        echo '
                        <article style="
                            background: #151515; 
                            border: 1px solid #2a2a2a; 
                            border-radius: 6px; 
                            overflow: hidden; 
                            transition: transform 0.2s ease;
                            display: flex;
                            flex-direction: column;
                            height: 100%;
                        " 
                        onmouseover="this.style.borderColor=\'var(--primary-red)\'; this.style.transform=\'translateY(-3px)\';" 
                        onmouseout="this.style.borderColor=\'#2a2a2a\'; this.style.transform=\'translateY(0)\';">
                            
                            <div style="height: 200px; width: 100%; '.$bgStyle.' background-size: cover; background-position: center; border-bottom: 1px solid #222; position: relative;">
                                <div style="
                                    position: absolute; 
                                    top: 10px; 
                                    right: 10px; 
                                    background: rgba(0,0,0,0.8); 
                                    color: var(--primary-red); 
                                    padding: 4px 10px; 
                                    border-radius: 4px; 
                                    font-weight: 700; 
                                    font-size: 0.9rem;
                                    border: 1px solid #333;
                                ">
                                    $'.$price.'
                                </div>
                            </div>

                            <div style="padding: 1.5rem; display: flex; flex-direction: column; flex-grow: 1;">
                                <h3 style="font-size: 1.25rem; margin-bottom: 0.75rem; line-height: 1.3; color: white;">
                                    '.htmlspecialchars($row['title']).'
                                </h3>
                                
                                <p style="color: #999; font-size: 0.9rem; line-height: 1.5; margin-bottom: 1.5rem; flex-grow: 1;">
                                    '.substr(htmlspecialchars($row['description']), 0, 85).'
                                </p>
                                
                                <a href="contact.php?product='.$row['id'].'" style="
                                    background: transparent;
                                    color: white; 
                                    text-decoration: none; 
                                    font-weight: 600; 
                                    font-size: 0.85rem;
                                    display: flex; 
                                    align-items: center; 
                                    justify-content: space-between;
                                    padding: 10px 0;
                                    border-top: 1px solid #2a2a2a;
                                    transition: 0.3s;
                                " onmouseover="this.style.color=\'var(--primary-red)\'; this.style.borderColor=\'var(--primary-red)\'" 
                                  onmouseout="this.style.color=\'white\'; this.style.borderColor=\'#2a2a2a\'">
                                    ENQUIRE NOW <span>&rarr;</span>
                                </a>
                            </div>
                        </article>';
                    }
                } else {
                    echo '<div style="grid-column: 1/-1; padding: 40px; text-align: center; border: 1px dashed #333; border-radius: 8px;">
                            <h3 style="color: #555; font-size: 1.2rem;">No Products Listed</h3>
                          </div>';
                }
            } else {
                echo "<p style='color: red;'>Database Error.</p>";
            }
            ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>