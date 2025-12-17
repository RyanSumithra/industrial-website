
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
            --primary-red: #ff3333;
            --dark-red: #cc0000;
            --glow-red: rgba(255, 51, 51, 0.15);
            --text-white: #ffffff;
            --text-gray: #a0a0a0;
            --text-light: #e0e0e0;
            --bg-black: #000000;
            --bg-dark: #0a0a0a;
            --bg-darker: #050505;
            --bg-gradient: linear-gradient(135deg, #000000 0%, #0a0a0a 50%, #000000 100%);
            --bg-gradient-alt: linear-gradient(180deg, #000000 0%, #111111 100%);
            --border-color: rgba(255, 255, 255, 0.05);
            --card-bg: rgba(10, 10, 10, 0.8);
        }

        /* ===== GLOBAL STYLES ===== */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            background: var(--bg-gradient) !important;
            color: var(--text-white) !important;
            font-family: 'Inter', sans-serif !important;
            margin: 0;
            padding-top: 80px;
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 50%, rgba(255, 51, 51, 0.03) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 51, 51, 0.02) 0%, transparent 50%);
            pointer-events: none;
            z-index: -1;
        }

        /* ===== NAVBAR STYLES ===== */
        .navbar {
            background: linear-gradient(180deg, rgba(0, 0, 0, 0.98) 0%, rgba(5, 5, 5, 0.98) 100%) !important;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border-color) !important;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.3);
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            height: 80px;
            display: flex;
            align-items: center;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .navbar.scrolled {
            height: 70px;
            background: rgba(0, 0, 0, 0.95) !important;
            border-bottom: 1px solid rgba(255, 51, 51, 0.1) !important;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
        }

        .nav-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 40px;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* LOGO STYLING */
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
            gap: 2.5rem;
            list-style: none;
            margin: 0;
            padding: 0;
            align-items: center;
        }

        .nav-link { 
            color: var(--text-gray) !important; 
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.3s ease; 
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            padding: 0.5rem 0;
            display: inline-block;
        }
        
        .nav-link::before {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(to right, var(--primary-red), #ff6666);
            transition: width 0.3s ease;
            border-radius: 2px;
        }
        
        .nav-link:hover,
        .nav-link.active { 
            color: var(--text-white) !important; 
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.2);
        }
        
        .nav-link:hover::before,
        .nav-link.active::before { 
            width: 100%; 
        }

        /* Login Button Special Styling */
        .nav-link.login-btn {
            background: linear-gradient(135deg, var(--primary-red), var(--dark-red));
            color: var(--text-white) !important;
            padding: 0.7rem 1.8rem;
            border-radius: 4px;
            margin-left: 1.5rem;
            transition: all 0.3s ease;
            border: none;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .nav-link.login-btn::before {
            display: none;
        }
        
        .nav-link.login-btn:hover {
            background: linear-gradient(135deg, var(--dark-red), #b30000);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 51, 51, 0.4);
        }

        /* MOBILE TOGGLE BUTTON */
        .nav-toggle {
            display: none;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
            background: none;
            border: none;
            padding: 10px;
            z-index: 1001;
            position: relative;
        }
        
        .nav-toggle span {
            display: block;
            width: 24px;
            height: 2px;
            background: var(--text-white);
            transition: all 0.3s ease;
            transform-origin: center;
            border-radius: 2px;
        }
        
        .nav-toggle.active span:nth-child(1) {
            transform: rotate(45deg) translate(6px, 6px);
            background: var(--primary-red);
        }
        
        .nav-toggle.active span:nth-child(2) {
            opacity: 0;
        }
        
        .nav-toggle.active span:nth-child(3) {
            transform: rotate(-45deg) translate(6px, -6px);
            background: var(--primary-red);
        }

        /* MOBILE MENU STYLES */
        @media (max-width: 1024px) {
            .nav-menu {
                gap: 2rem;
            }
            
            .nav-container {
                padding: 0 30px;
            }
        }

        @media (max-width: 768px) {
            .nav-toggle {
                display: flex;
            }
            
            .nav-menu {
                position: fixed;
                top: 0;
                right: -100%;
                width: 300px;
                height: 100vh;
                background: linear-gradient(180deg, rgba(0, 0, 0, 0.98) 0%, rgba(10, 10, 10, 0.98) 100%);
                backdrop-filter: blur(30px);
                -webkit-backdrop-filter: blur(30px);
                flex-direction: column;
                padding: 120px 40px 40px;
                gap: 0;
                transition: right 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                z-index: 999;
                border-left: 1px solid var(--border-color);
                box-shadow: -10px 0 40px rgba(0, 0, 0, 0.5);
            }
            
            .nav-menu.active {
                right: 0;
            }
            
            .nav-menu li {
                width: 100%;
                margin-bottom: 0;
                opacity: 0;
                transform: translateX(20px);
                animation: slideIn 0.3s ease forwards;
            }
            
            .nav-menu li:nth-child(1) { animation-delay: 0.1s; }
            .nav-menu li:nth-child(2) { animation-delay: 0.2s; }
            .nav-menu li:nth-child(3) { animation-delay: 0.3s; }
            .nav-menu li:nth-child(4) { animation-delay: 0.4s; }
            .nav-menu li:nth-child(5) { animation-delay: 0.5s; }
            .nav-menu li:nth-child(6) { animation-delay: 0.6s; }
            .nav-menu li:nth-child(7) { animation-delay: 0.7s; }
            .nav-menu li:nth-child(8) { animation-delay: 0.8s; }
            
            @keyframes slideIn {
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }
            
            .nav-link {
                display: block;
                padding: 1.2rem 0;
                border-bottom: 1px solid rgba(255, 255, 255, 0.05);
                font-size: 1rem;
                width: 100%;
            }
            
            .nav-link.login-btn {
                margin: 1.5rem 0 0 0;
                text-align: center;
                width: 100%;
                padding: 1rem;
                font-size: 1rem;
            }
            
            .navbar {
                height: 70px;
            }
            
            body {
                padding-top: 70px;
            }
            
            .nav-container {
                padding: 0 20px;
            }
        }

        @media (max-width: 480px) {
            .brand-logo {
                font-size: 1.5rem;
            }
            
            .nav-menu {
                width: 100%;
                padding: 100px 30px 30px;
            }
            
            .nav-container {
                padding: 0 15px;
            }
        }

        /* ===== GLOBAL UTILITIES ===== */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            width: 100%;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 14px 32px;
            font-family: 'Inter', sans-serif;
            font-size: 1rem;
            font-weight: 600;
            line-height: 1;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-red), var(--dark-red));
            color: var(--text-white);
            border: 1px solid transparent;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--dark-red), #b30000);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 51, 51, 0.3);
        }

        .section {
            padding: 100px 0;
            position: relative;
        }

        .section-title {
            font-family: 'Montserrat', sans-serif;
            font-size: 3rem;
            font-weight: 800;
            color: var(--text-white);
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .section-subtitle {
            color: var(--text-gray);
            font-size: 1.125rem;
            max-width: 700px;
            margin: 0 auto 3rem;
            text-align: center;
            line-height: 1.6;
        }

        /* ===== SCROLLBAR STYLING ===== */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg-darker);
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, var(--primary-red), var(--dark-red));
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(to bottom, var(--dark-red), #b30000);
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
            <?php 
                $cp = $current_page ?? ''; 
            ?>
            <li><a href="<?php echo $base_path; ?>index.php" class="nav-link <?php echo ($cp == 'home') ? 'active' : ''; ?>">Home</a></li>
            <li><a href="<?php echo $base_path; ?>projects.php" class="nav-link <?php echo ($cp == 'projects') ? 'active' : ''; ?>">Projects</a></li>
            <li><a href="<?php echo $base_path; ?>services.php" class="nav-link <?php echo ($cp == 'services') ? 'active' : ''; ?>">Services</a></li>
            <li><a href="<?php echo $base_path; ?>products.php" class="nav-link <?php echo ($cp == 'products') ? 'active' : ''; ?>">Products</a></li>
            <li><a href="<?php echo $base_path; ?>blogs.php" class="nav-link <?php echo ($cp == 'blogs') ? 'active' : ''; ?>">Blog</a></li>
            <li><a href="<?php echo $base_path; ?>business-card.php" class="nav-link <?php echo ($cp == 'business-card') ? 'active' : ''; ?>">Digital Card</a></li>
            <li><a href="<?php echo $base_path; ?>contact.php" class="nav-link <?php echo ($cp == 'contact') ? 'active' : ''; ?>">Contact</a></li>
            <li><a href="<?php echo $base_path; ?>admin/login.php" class="nav-link login-btn">Login</a></li>
        </ul>

        <button class="nav-toggle" id="navToggle" aria-label="Toggle navigation">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
</nav>