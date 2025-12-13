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
?>

<div class="hero blogheader" style="background: linear-gradient(180deg, #000 0%, #111 100%); padding: 0px 0 0px; border-bottom: 1px solid #222;">
    <div class="container" style="text-align: center;">
        <h1 style="font-size: 3.5rem; font-weight: 900; letter-spacing: 1px; margin-bottom: 1rem;">
            INTELLIGENCE <span style="color: var(--primary-red);">HUB</span>
        </h1>
        <p style="color: var(--text-gray); font-size: 1.2rem; max-width: 600px; margin: 0 auto;">
            Technical breakdowns and automation insights.
        </p>
    </div>
</div>

<section class="section" style="padding: 80px 0;">
    <div class="container">
        
        <div class="projects-grid"> 
            
            <?php
            if (isset($conn) && $conn) {
                $sql = "SELECT * FROM blogs ORDER BY created_at DESC";
                $result = $conn->query($sql);

                if ($result && $result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $date = date('M d, Y', strtotime($row['created_at']));
                        $imgFile = 'uploads/' . $row['image'];
                        
                        // Smart Image Handler
                        $bgStyle = (!empty($row['image']) && file_exists($imgFile)) 
                                    ? "background-image: url('$imgFile');" 
                                    : "background: #222;"; 

                        echo '
                        <article style="
                            background: var(--bg-panel); 
                            border: 1px solid #2a2a2a; 
                            border-radius: 8px; 
                            overflow: hidden; 
                            transition: transform 0.3s ease, border 0.3s ease;
                            display: flex;
                            flex-direction: column;
                            height: 100%;
                        " 
                        onmouseover="this.style.borderColor=\'var(--primary-red)\'; this.style.transform=\'translateY(-5px)\';" 
                        onmouseout="this.style.borderColor=\'#2a2a2a\'; this.style.transform=\'translateY(0)\';">
                            
                            <div style="height: 240px; width: 100%; '.$bgStyle.' background-size: cover; background-position: center; border-bottom: 1px solid #222;"></div>

                            <div style="padding: 2rem; display: flex; flex-direction: column; flex-grow: 1;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
                                    <span style="color: var(--primary-red); font-weight: 700; font-size: 0.8rem; text-transform: uppercase;">Update</span>
                                    <span style="color: #666; font-size: 0.8rem;">'.$date.'</span>
                                </div>
                                
                                <h3 style="font-size: 1.5rem; margin-bottom: 1rem; line-height: 1.3; color: white;">
                                    '.htmlspecialchars($row['title']).'
                                </h3>
                                
                                <p style="color: #999; line-height: 1.6; margin-bottom: 2rem; flex-grow: 1;">
                                    '.substr(htmlspecialchars($row['content']), 0, 100).'
                                </p>
                                
                                <a href="#" style="
                                    color: white; 
                                    text-decoration: none; 
                                    font-weight: 600; 
                                    display: flex; 
                                    align-items: center; 
                                    gap: 10px;
                                    transition: 0.3s;
                                " onmouseover="this.style.color=\'var(--primary-red)\'" onmouseout="this.style.color=\'white\'">
                                    READ ARTICLE <span>&rarr;</span>
                                </a>
                            </div>
                        </article>';
                    }
                } else {
                    echo '<div style="grid-column: 1/-1; padding: 60px; text-align: center; border: 1px dashed #333; border-radius: 8px;">
                            <h3 style="color: #555;">No Data Found</h3>
                          </div>';
                }
            }
            ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>