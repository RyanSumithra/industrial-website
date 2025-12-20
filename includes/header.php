<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? 'AsiaTech Mechatronics - Industrial Automation'; ?></title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Montserrat:wght@700;800;900&display=swap" rel="stylesheet">
    
    <?php 
        $css_path = (basename(dirname($_SERVER['PHP_SELF'])) == 'admin') ? '../css/styles.css' : 'css/styles.css';
        if(basename(dirname($_SERVER['PHP_SELF'])) == 'asiaTech-website' || basename(dirname($_SERVER['PHP_SELF'])) == 'htdocs') {
            $css_path = 'css/styles.css';
        }
    ?>
    <link rel="stylesheet" href="<?php echo $css_path; ?>">

    <style>
        :root {
            /* --- CORE PALETTE (Variables used across both themes) --- */
            --primary-red: #ff3333;
            --dark-red: #cc0000;
            
            /* --- DARK THEME (DEFAULT) --- */
            --bg-body: #000000;
            --bg-surface: #0a0a0a;
            --bg-surface-2: #111111; /* Slightly lighter for cards */
            --bg-gradient: linear-gradient(135deg, #000000 0%, #0a0a0a 50%, #000000 100%);
            
            --text-main: #ffffff;
            --text-muted: #a0a0a0;
            --text-light: #e0e0e0;
            
            --border-color: rgba(255, 255, 255, 0.1);
            --card-bg: rgba(10, 10, 10, 0.8);
            
            --nav-bg: rgba(0, 0, 0, 0.95);
            --shadow: 0 4px 30px rgba(0, 0, 0, 0.5);
        }

        /* --- LIGHT THEME OVERRIDES --- */
        body.light-mode {
            /* Aliceblue background, Black text, Red Accents */
            --bg-body: #f0f8ff; /* Aliceblue */
            --bg-surface: #ffffff;
            --bg-surface-2: #e6f0fa;
            --bg-gradient: linear-gradient(135deg, #f0f8ff 0%, #ffffff 100%);
            
            --text-main: #111111;
            --text-muted: #555555;
            --text-light: #333333;
            
            --border-color: rgba(0, 0, 0, 0.1);
            --card-bg: rgba(255, 255, 255, 0.95);
            
            --nav-bg: rgba(255, 255, 255, 0.95);
            --shadow: 0 4px 30px rgba(0, 0, 0, 0.05);
        }

        /* ===== GLOBAL STYLES ===== */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html { scroll-behavior: smooth; }

        body {
            background: var(--bg-gradient) !important;
            color: var(--text-main) !important;
            font-family: 'Inter', sans-serif !important;
            margin: 0;
            padding-top: 80px;
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
            transition: background 0.3s ease, color 0.3s ease;
        }

        /* Background grid/dots effect */
        body::before {
            content: '';
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: 
                radial-gradient(circle at 20% 50%, rgba(255, 51, 51, 0.03) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 51, 51, 0.02) 0%, transparent 50%);
            pointer-events: none; z-index: -1;
        }

        /* ===== NAVBAR STYLES ===== */
        .navbar {
            background: var(--nav-bg) !important;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border-color) !important;
            box-shadow: var(--shadow);
            position: fixed; top: 0; left: 0; width: 100%; z-index: 1000; height: 80px;
            display: flex; align-items: center;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .nav-container {
            max-width: 1400px; margin: 0 auto; padding: 0 40px; width: 100%;
            display: flex; justify-content: space-between; align-items: center;
        }

        /* LOGO */
        .brand { display: flex; align-items: center; text-decoration: none; }
        .header-logo { height: 60px; width: auto; object-fit: contain; transition: transform 0.3s ease; }
        .brand:hover .header-logo { transform: scale(1.05); }

        /* MENU */
        .nav-menu {
            display: flex; gap: 2rem; list-style: none; margin: 0; padding: 0; align-items: center;
        }

        .nav-link { 
            color: var(--text-muted) !important; 
            text-decoration: none; font-weight: 600; font-size: 0.9rem;
            transition: all 0.3s ease; text-transform: uppercase; letter-spacing: 1px;
            position: relative; padding: 0.5rem 0;
        }
        
        .nav-link::before {
            content: ''; position: absolute; bottom: -2px; left: 0; width: 0; height: 2px;
            background: var(--primary-red); transition: width 0.3s ease;
        }
        
        .nav-link:hover, .nav-link.active { 
            color: var(--text-main) !important; 
        }
        .nav-link:hover::before, .nav-link.active::before { width: 100%; }

        /* THEME TOGGLE BTN */
        .theme-toggle-btn {
            background: transparent;
            border: 1px solid var(--border-color);
            color: var(--text-main);
            width: 40px; height: 40px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            margin-left: 1rem;
            transition: 0.3s;
        }
        .theme-toggle-btn:hover {
            background: var(--primary-red);
            color: white;
            border-color: var(--primary-red);
        }
        .theme-toggle-btn svg { width: 20px; height: 20px; fill: currentColor; }
        
        /* Sun/Moon Icons logic */
        .icon-sun { display: none; }
        .icon-moon { display: block; }
        
        body.light-mode .icon-sun { display: block; }
        body.light-mode .icon-moon { display: none; }

        /* LOGIN BTN */
        .nav-link.login-btn {
            background: linear-gradient(135deg, var(--primary-red), var(--dark-red));
            color: #fff !important; padding: 0.6rem 1.5rem; border-radius: 4px;
            margin-left: 0.5rem;
        }
        .nav-link.login-btn:hover { transform: translateY(-2px); box-shadow: 0 4px 15px rgba(255, 51, 51, 0.4); }
        .nav-link.login-btn::before { display: none; }

        /* MOBILE TOGGLE */
        .nav-toggle { display: none; flex-direction: column; gap: 5px; cursor: pointer; background: none; border: none; z-index: 1001; }
        .nav-toggle span { display: block; width: 24px; height: 2px; background: var(--text-main); transition: 0.3s; }

        /* RESPONSIVE */
        @media (max-width: 1024px) {
            .nav-menu { gap: 1.5rem; }
        }
        @media (max-width: 900px) {
            .nav-toggle { display: flex; }
            .nav-menu {
                position: fixed; top: 0; right: -100%; width: 300px; height: 100vh;
                background: var(--bg-surface);
                flex-direction: column; padding: 100px 40px; border-left: 1px solid var(--border-color);
                transition: 0.4s; box-shadow: -10px 0 40px rgba(0,0,0,0.2);
            }
            .nav-menu.active { right: 0; }
            .nav-link { width: 100%; border-bottom: 1px solid var(--border-color); padding: 15px 0; }
            .nav-link.login-btn { margin: 20px 0; width: 100%; text-align: center; }
        }
    </style>
</head>

<body class="antialiased">

<nav class="navbar" id="navbar">
    <div class="nav-container">
        <?php 
            $home_link = (basename(dirname($_SERVER['PHP_SELF'])) == 'admin') ? '../index.php' : 'index.php';
            $base_path = (basename(dirname($_SERVER['PHP_SELF'])) == 'admin') ? '../' : '';
        ?>
        
         <a href="<?php echo $home_link; ?>" class="brand">
            <img src="images/logo.png" alt="IndustrialTech Logo" class="header-logo">
        </a>

        <ul class="nav-menu" id="navMenu">
            <?php $cp = $current_page ?? ''; ?>
            <li><a href="<?php echo $base_path; ?>index.php" class="nav-link <?php echo ($cp == 'home') ? 'active' : ''; ?>">Home</a></li>
            <li><a href="<?php echo $base_path; ?>projects.php" class="nav-link <?php echo ($cp == 'projects') ? 'active' : ''; ?>">Projects</a></li>
            <li><a href="<?php echo $base_path; ?>services.php" class="nav-link <?php echo ($cp == 'services') ? 'active' : ''; ?>">Services</a></li>
            <li><a href="<?php echo $base_path; ?>products.php" class="nav-link <?php echo ($cp == 'products') ? 'active' : ''; ?>">Products</a></li>
            <li><a href="<?php echo $base_path; ?>blogs.php" class="nav-link <?php echo ($cp == 'blogs') ? 'active' : ''; ?>">Blog</a></li>
            <li><a href="<?php echo $base_path; ?>business-card.php" class="nav-link <?php echo ($cp == 'business-card') ? 'active' : ''; ?>">Digital Card</a></li>
            <li><a href="<?php echo $base_path; ?>contact.php" class="nav-link <?php echo ($cp == 'contact') ? 'active' : ''; ?>">Contact</a></li>
            <li><a href="<?php echo $base_path; ?>admin/login.php" class="nav-link login-btn">Login</a></li>
            
            <li>
                <button id="themeToggle" class="theme-toggle-btn" aria-label="Toggle Theme">
                    <svg class="icon-moon" viewBox="0 0 24 24"><path d="M12 3a9 9 0 1 0 9 9c0-.46-.04-.92-.1-1.36a5.389 5.389 0 0 1-4.4 2.26 5.403 5.403 0 0 1-3.14-9.8c-.44-.06-.9-.1-1.36-.1z"/></svg>
                    <svg class="icon-sun" viewBox="0 0 24 24"><path d="M12 7c-2.76 0-5 2.24-5 5s2.24 5 5 5 5-2.24 5-5-2.24-5-5-5zM2 13h2c.55 0 1-.45 1-1s-.45-1-1-1H2c-.55 0-1 .45-1 1s.45 1 1 1zm18 0h2c.55 0 1-.45 1-1s-.45-1-1-1h-2c-.55 0-1 .45-1 1s.45 1 1 1zM11 2v2c0 .55.45 1 1 1s1-.45 1-1V2c0-.55-.45-1-1-1s-1 .45-1 1zm0 18v2c0 .55.45 1 1 1s1-.45 1-1v-2c0-.55-.45-1-1-1s-1 .45-1 1zM5.99 4.58a.996.996 0 0 0-1.41 0 .996.996 0 0 0 0 1.41l1.41 1.41c.39.39 1.02.39 1.41 0 .39-.39.39-1.02 0-1.41L5.99 4.58zm12.37 12.37a.996.996 0 0 0-1.41 0 .996.996 0 0 0 0 1.41l1.41 1.41c.39.39 1.02.39 1.41 0 .39-.39.39-1.02 0-1.41l-1.41-1.41zm1.06-10.96a.996.996 0 0 0 0-1.41.996.996 0 0 0-1.41 0l-1.41 1.41c-.39.39-.39 1.02 0 1.41.39.39 1.02.39 1.41 0l1.41-1.41zM7.05 18.36a.996.996 0 0 0 0 1.41.996.996 0 0 0 1.41 0l1.41-1.41c.39-.39.39-1.02 0-1.41-.39-.39-1.02-.39-1.41 0L7.05 18.36z"/></svg>
                </button>
            </li>
        </ul>

        <button class="nav-toggle" id="navToggle">
            <span></span><span></span><span></span>
        </button>
    </div>
</nav>

<script>
    // Theme Toggling Logic
    const toggleBtn = document.getElementById('themeToggle');
    const body = document.body;
    
    // Check saved preference
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'light') {
        body.classList.add('light-mode');
    }

    toggleBtn.addEventListener('click', () => {
        body.classList.toggle('light-mode');
        // Save preference
        if (body.classList.contains('light-mode')) {
            localStorage.setItem('theme', 'light');
        } else {
            localStorage.setItem('theme', 'dark');
        }
    });

    // Mobile Menu Logic
    const navToggle = document.getElementById('navToggle');
    const navMenu = document.getElementById('navMenu');
    
    navToggle.addEventListener('click', () => {
        navToggle.classList.toggle('active');
        navMenu.classList.toggle('active');
    });
</script>