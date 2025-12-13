<nav class="navbar" id="navbar">
    <div class="container nav-container">
        <a href="index.php" class="nav-logo">
            <span>INDUSTRIAL</span>TECH
        </a>
        
        <div class="nav-menu-container">
            <ul class="nav-menu" id="navMenu">
                <li><a href="index.php" class="nav-link <?php echo ($current_page == 'home') ? 'active' : ''; ?>">Home</a></li>
                <li><a href="about.php" class="nav-link <?php echo ($current_page == 'about') ? 'active' : ''; ?>">About</a></li>
                <li><a href="services.php" class="nav-link <?php echo ($current_page == 'services') ? 'active' : ''; ?>">Services</a></li>
                <li><a href="projects.php" class="nav-link <?php echo ($current_page == 'projects') ? 'active' : ''; ?>">Projects</a></li>
                <li><a href="contact.php" class="nav-link <?php echo ($current_page == 'contact') ? 'active' : ''; ?>">Contact</a></li>
                <li><a href="contact.php" class="nav-btn btn btn-primary">Get Quote</a></li>
            </ul>
        </div>
        
        <div class="nav-toggle" id="navToggle" aria-label="Toggle navigation">
            <span class="toggle-line"></span>
            <span class="toggle-line"></span>
            <span class="toggle-line"></span>
        </div>
    </div>
</nav>

<!-- Progress Indicator -->
<div class="scroll-progress" id="scrollProgress">
    <div class="scroll-progress-bar" id="scrollProgressBar"></div>
</div>