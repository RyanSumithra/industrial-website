<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo $page_description ?? 'Industrial automation, PLC systems, control panels, and custom electronics solutions for modern manufacturing.'; ?>">
    <meta name="keywords" content="<?php echo $page_keywords ?? 'industrial automation, PLC, control panels, mechatronics, IoT, manufacturing, Industry 4.0, robotics, SCADA, HMI'; ?>">
    <meta name="author" content="IndustrialTech">
    <meta name="robots" content="index, follow">
    
    <meta property="og:title" content="<?php echo $page_title ?? 'IndustrialTech - Industrial Automation Solutions'; ?>">
    <meta property="og:description" content="<?php echo $page_description ?? 'Leading industrial automation solutions provider.'; ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo BASE_URL . basename($_SERVER['PHP_SELF']); ?>">
    <meta property="og:image" content="<?php echo BASE_URL; ?>assets/og-image.jpg">
    
    <title><?php echo $page_title ?? 'IndustrialTech - Industrial Automation Solutions'; ?></title>
    
    <link rel="apple-touch-icon" sizes="180x180" href="assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="assets/favicon/site.webmanifest">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Montserrat:wght@700;800;900&display=swap" rel="stylesheet">
    
    <?php 
        // If we are in the admin folder, we need to go back one level (../)
        $css_path = (basename(dirname($_SERVER['PHP_SELF'])) == 'admin') ? '../css/styles.css' : 'css/styles.css';
        
        // Fix for products.php and blogs.php being in root
        if(basename(dirname($_SERVER['PHP_SELF'])) == 'asiaTech-website' || basename(dirname($_SERVER['PHP_SELF'])) == 'htdocs') {
            $css_path = 'css/styles.css';
        }
    ?>
    <link rel="stylesheet" href="<?php echo $css_path; ?>">

    <style>
        /* Critical CSS for initial load */
        .navbar { opacity: 0; animation: fadeIn 0.5s ease forwards; }
        .hero-content { opacity: 0; transform: translateY(20px); animation: slideUp 0.8s ease 0.3s forwards; }
        @keyframes fadeIn { to { opacity: 1; } }
        @keyframes slideUp { to { opacity: 1; transform: translateY(0); } }
        
        /* Prevent FOUC */
        .js-loading * { animation-play-state: paused !important; }
    </style>
</head>

<body class="antialiased js-loading">

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