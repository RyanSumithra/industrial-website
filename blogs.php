<?php 
$current_page = 'blogs';
$page_title = 'Latest News - IndustrialTech';

include 'includes/db.php';
include 'includes/header.php'; // <--- This adds your Navbar
?>

<div class="hero" style="padding: 60px ;">
    <div class="container">
        <div class="hero-content">
            <h1>Latest Insights</h1>
            <p>News and technical articles from our engineering team.</p>
        </div>
    </div>
</div>

<section class="section">
    <div class="container">
        <div class="projects-grid"> 
            <?php
            $sql = "SELECT * FROM blogs ORDER BY created_at DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $date = date('F j, Y', strtotime($row['created_at']));
                    $bgStyle = (!empty($row['image'])) ? "background-image: url('uploads/".$row['image']."');" : "background-color: #ddd;";

                    echo '
                    <div class="project-card">
                         <div class="project-image" style="'.$bgStyle.' background-size: cover; background-position: center;"></div>
                        <div class="project-content">
                            <div class="project-category">'.$date.'</div>
                            <h3>'.$row['title'].'</h3>
                            <p>'.substr($row['content'], 0, 100).'...</p>
                            <a href="#" class="service-link">Read More &rarr;</a>
                        </div>
                    </div>';
                }
            } else {
                echo "<p>No updates yet.</p>";
            }
            ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>