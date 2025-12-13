<nav class="navbar" id="navbar">
    <div class="nav-container">
        <a href="index.php" class="nav-logo">
            <span>INDUSTRIAL</span>TECH
        </a>
        <ul class="nav-menu" id="navMenu">
            <li><a href="index.php" class="nav-link <?php echo ($current_page == 'home') ? 'active' : ''; ?>">Home</a></li>
            <li><a href="about.php" class="nav-link <?php echo ($current_page == 'about') ? 'active' : ''; ?>">About</a></li>
            <!-- etc -->
        </ul>
        <div class="nav-toggle" id="navToggle">
            <span></span><span></span><span></span>
        </div>
    </div>
</nav>