<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo $page_description ?? 'Industrial automation, PLC systems, control panels, and custom electronics solutions for modern manufacturing.'; ?>">
    <meta name="keywords" content="<?php echo $page_keywords ?? 'industrial automation, PLC, control panels, mechatronics, IoT, manufacturing'; ?>">
    <meta name="author" content="IndustrialTech">
    
    <title><?php echo $page_title ?? 'IndustrialTech - Industrial Automation Solutions'; ?></title>
    
    <link rel="icon" type="image/png" href="favicon.png">
    
    <?php 
        // If we are in the admin folder, we need to go back one level (../)
        $css_path = (basename(dirname($_SERVER['PHP_SELF'])) == 'admin') ? '../css/styles.css' : 'css/styles.css';
        
        // Fix for products.php and blogs.php being in root
        if(basename(dirname($_SERVER['PHP_SELF'])) == 'asiaTech-website' || basename(dirname($_SERVER['PHP_SELF'])) == 'htdocs') {
            $css_path = 'css/styles.css';
        }
    ?>
    <link rel="stylesheet" href="<?php echo $css_path; ?>">
</head>
<body>

<nav class="navbar" id="navbar">
    <div class="nav-container">
        <?php $home_link = (basename(dirname($_SERVER['PHP_SELF'])) == 'admin') ? '../index.php' : 'index.php'; ?>
        <a href="<?php echo $home_link; ?>" class="nav-logo">
            <span>INDUSTRIAL</span>TECH
        </a>

        <ul class="nav-menu" id="navMenu">
            <?php 
                // Helper to determine active class
                $cp = $current_page ?? ''; 
                // Helper for links if inside admin folder
                $p = (basename(dirname($_SERVER['PHP_SELF'])) == 'admin') ? '../' : '';
            ?>
            
            <li><a href="<?php echo $p; ?>index.php" class="nav-link <?php echo ($cp == 'home') ? 'active' : ''; ?>">Home</a></li>
            <li><a href="<?php echo $p; ?>about.php" class="nav-link <?php echo ($cp == 'about') ? 'active' : ''; ?>">About</a></li>
            <li><a href="<?php echo $p; ?>services.php" class="nav-link <?php echo ($cp == 'services') ? 'active' : ''; ?>">Services</a></li>
            
            <li><a href="<?php echo $p; ?>products.php" class="nav-link <?php echo ($cp == 'products') ? 'active' : ''; ?>">Products</a></li>
            <li><a href="<?php echo $p; ?>blogs.php" class="nav-link <?php echo ($cp == 'blogs') ? 'active' : ''; ?>">Blog</a></li>
            
            <li><a href="<?php echo $p; ?>contact.php" class="nav-link <?php echo ($cp == 'contact') ? 'active' : ''; ?>">Contact</a></li>
            
            <li><a href="<?php echo $p; ?>admin/login.php" class="nav-link" style="color: var(--primary-blue); font-weight: bold;">Login</a></li>
        </ul>

        <div class="nav-toggle" id="navToggle">
            <span></span><span></span><span></span>
        </div>
    </div>
</nav>