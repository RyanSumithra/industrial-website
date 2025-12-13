<?php 
require_once 'includes/config.php';

$current_page = 'home';
$page_title = SITE_TAGLINE . ' | ' . SITE_NAME;
$page_description = 'Delivering cutting-edge PLC automation, control systems, and custom electronics for modern manufacturing.';

include 'includes/header.php'; 
include 'includes/navbar.php'; 
?>

<!-- HERO SECTION -->
<section class="hero">
    <div class="container">
        <div class="hero-content">
            <h1>Industrial Automation & Mechatronics Solutions</h1>
            <p>Delivering cutting-edge PLC automation, control systems, and custom electronics for modern manufacturing.</p>
            <div class="hero-buttons">
                <a href="services.php" class="btn btn-white">Our Services</a>
                <a href="contact.php" class="btn btn-secondary">Get a Quote</a>
            </div>
        </div>
    </div>
</section>

<!-- SERVICES OVERVIEW -->
<section class="section">
    <div class="container">
        <h2 class="section-title">Our Core Services</h2>
        <p class="section-subtitle">Comprehensive industrial automation solutions tailored to your manufacturing needs</p>
        
        <div class="services-grid">
            <div class="service-card">
                <div class="service-icon">⚙️</div>
                <h3>PLC Automation</h3>
                <p>Advanced programmable logic controller systems for industrial process automation and control.</p>
                <a href="services.php#plc" class="service-link">Learn more →</a>
            </div>

            <div class="service-card">
                <div class="service-icon">🔌</div>
                <h3>Control Panels</h3>
                <p>Custom-designed electrical control panels built to international standards and specifications.</p>
                <a href="services.php#panels" class="service-link">Learn more →</a>
            </div>

            <div class="service-card">
                <div class="service-icon">💡</div>
                <h3>Custom Electronics</h3>
                <p>Tailored electronic solutions for specialized industrial applications and unique requirements.</p>
                <a href="services.php#electronics" class="service-link">Learn more →</a>
            </div>

            <div class="service-card">
                <div class="service-icon">🌐</div>
                <h3>IoT Solutions</h3>
                <p>Industrial Internet of Things integration for smart manufacturing and real-time monitoring.</p>
                <a href="services.php#iot" class="service-link">Learn more →</a>
            </div>
        </div>
    </div>
</section>

<!-- STATS SECTION -->
<section class="section stats">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-item">
                <h3>15+</h3>
                <p>Years Experience</p>
            </div>
            <div class="stat-item">
                <h3>200+</h3>
                <p>Projects Completed</p>
            </div>
            <div class="stat-item">
                <h3>50+</h3>
                <p>Industrial Clients</p>
            </div>
            <div class="stat-item">
                <h3>24/7</h3>
                <p>Technical Support</p>
            </div>
        </div>
    </div>
</section>

<!-- FEATURED PROJECTS -->
<section class="section">
    <div class="container">
        <h2 class="section-title">Featured Projects</h2>
        <p class="section-subtitle">Explore our portfolio of successful automation implementations</p>
        
        <div class="projects-grid">
            <div class="project-card">
                <div class="project-image">🏭</div>
                <div class="project-content">
                    <div class="project-category">Manufacturing</div>
                    <h3>Automotive Assembly Line</h3>
                    <p>Complete PLC automation system for high-speed automotive component assembly.</p>
                    <a href="projects.php" class="service-link">View details →</a>
                </div>
            </div>

            <div class="project-card">
                <div class="project-image">🔋</div>
                <div class="project-content">
                    <div class="project-category">Energy</div>
                    <h3>Power Distribution Control</h3>
                    <p>Advanced control panel design for industrial power distribution system.</p>
                    <a href="projects.php" class="service-link">View details →</a>
                </div>
            </div>

            <div class="project-card">
                <div class="project-image">📊</div>
                <div class="project-content">
                    <div class="project-category">IoT</div>
                    <h3>Smart Factory Monitoring</h3>
                    <p>Real-time IoT monitoring system for production line optimization.</p>
                    <a href="projects.php" class="service-link">View details →</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA SECTION -->
<section class="section cta">
    <div class="container">
        <h2>Ready to Automate Your Operations?</h2>
        <p>Let's discuss how our industrial automation solutions can transform your manufacturing process.</p>
        <a href="contact.php" class="btn btn-primary">Contact Us Today</a>
    </div>
</section>

<?php include 'includes/footer.php'; ?>