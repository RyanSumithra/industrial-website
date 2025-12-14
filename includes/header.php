<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? 'IndustrialTech - Automation Solutions'; ?></title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Montserrat:wght@700;800;900&display=swap" rel="stylesheet">
    
    <?php 
        $css_path = (basename(dirname($_SERVER['PHP_SELF'])) == 'admin') ? '../css/styles.css' : 'css/styles.css';
        if(basename(dirname($_SERVER['PHP_SELF'])) == 'asiaTech-website' || basename(dirname($_SERVER['PHP_SELF'])) == 'htdocs') {
            $css_path = 'css/styles.css';
        }
    ?>
    <link rel="stylesheet" href="<?php echo $css_path; ?>">

    <style>
        :root {
            --primary-red: #ff3333;
            --dark-red: #cc0000;
            --bg-black: #0a0a0a;
            --bg-dark: #111111;
            --bg-panel: #1a1a1a;
            --text-white: #ffffff;
            --text-gray: #a0a0a0;
            --glow: 0 0 20px rgba(255, 51, 51, 0.15);
        }

        /* 1. Global Backgrounds */
        body {
            background-color: var(--bg-black) !important;
            color: var(--text-white) !important;
            font-family: 'Inter', sans-serif !important;
            margin: 0;
            padding-top: 90px; /* Increased to prevent hiding behind larger header */
        }

        /* 2. Global Navbar Styling */
        .navbar {
            background: rgba(10, 10, 10, 0.95) !important;
            border-bottom: 1px solid rgba(255, 51, 51, 0.1) !important;
            backdrop-filter: blur(10px);
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            height: 90px; /* Increased height for bigger logo */
            display: flex;
            align-items: center;
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* LOGO STYLING */
        .brand {
            display: flex;
            align-items: center;
            text-decoration: none;
        }
        
        .header-logo {
            height: 70px; /* Much bigger logo */
            width: auto;
            object-fit: contain;
            transition: transform 0.3s ease;
        }
        
        .brand:hover .header-logo {
            transform: scale(1.05);
        }

        /* MENU STYLING */
        .nav-menu {
            display: flex;
            gap: 30px;
            list-style: none;
            margin: 0;
            padding: 0;
            align-items: center;
        }

        .nav-link { 
            color: var(--text-white) !important; 
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            transition: 0.3s; 
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .nav-link:hover, .nav-link.active { 
            color: var(--primary-red) !important; 
        }
        
        .nav-toggle span { background: white !important; }

        /* MOBILE RESPONSIVENESS */
        @media (max-width: 768px) {
            .nav-menu { display: none; }
            /* Bigger logo on mobile too */
            .header-logo { height: 50px; } 
            .navbar { height: 70px; }
            body { padding-top: 70px; }
        }

        /* 3. Global Footer Styling */
        .footer {
            background: #050505 !important;
            border-top: 1px solid #222 !important;
        }
        .footer h3 span { color: var(--primary-red) !important; }
        .footer-links a:hover { color: var(--primary-red) !important; }

        /* 4. Global Button Styling */
        .btn-primary, button[type="submit"] {
            background: var(--primary-red) !important;
            color: white !important;
            border: none !important;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }
        .btn-primary:hover {
            background: var(--dark-red) !important;
            box-shadow: var(--glow) !important;
        }

        /* 5. Clean Grid Layouts */
        .projects-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 3rem;
        }
    </style>
</head>

<body class="antialiased">

<nav class="navbar" id="navbar">
    <div class="nav-container">
        <?php $home_link = (basename(dirname($_SERVER['PHP_SELF'])) == 'admin') ? '../index.php' : 'index.php'; ?>
        
        <a href="<?php echo $home_link; ?>" class="brand">
            <img src="images/logo.png" alt="IndustrialTech Logo" class="header-logo">
        </a>

        <ul class="nav-menu" id="navMenu">
            <?php 
                $cp = $current_page ?? ''; 
                $p = (basename(dirname($_SERVER['PHP_SELF'])) == 'admin') ? '../' : '';
            ?>
            <li><a href="<?php echo $p; ?>index.php" class="nav-link <?php echo ($cp == 'home') ? 'active' : ''; ?>">Home</a></li>
            <li><a href="<?php echo $p; ?>projects.php" class="nav-link <?php echo ($cp == 'projects') ? 'active' : ''; ?>">Projects</a></li>
            <li><a href="<?php echo $p; ?>services.php" class="nav-link <?php echo ($cp == 'services') ? 'active' : ''; ?>">Services</a></li>
            <li><a href="<?php echo $p; ?>products.php" class="nav-link <?php echo ($cp == 'products') ? 'active' : ''; ?>">Products</a></li>
            <li><a href="<?php echo $p; ?>blogs.php" class="nav-link <?php echo ($cp == 'blogs') ? 'active' : ''; ?>">Blog</a></li>
            <li><a href="<?php echo $p; ?>contact.php" class="nav-link <?php echo ($cp == 'contact') ? 'active' : ''; ?>">Contact</a></li>
            <li><a href="<?php echo $p; ?>admin/login.php" class="nav-link" style="color: var(--primary-red); font-weight: bold;">Login</a></li>
        </ul>

        <div class="nav-toggle" id="navToggle">
            <span></span><span></span><span></span>
        </div>
    </div>
</nav>