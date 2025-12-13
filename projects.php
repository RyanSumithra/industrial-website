<?php 
require_once 'includes/config.php';

$current_page = 'projects';
$page_title = 'Projects & Case Studies | ' . SITE_NAME;
$page_description = 'Explore our portfolio of successful industrial automation projects across various industries.';

include 'includes/header.php'; 
include 'includes/navbar.php'; 
?>

<!-- PAGE HEADER -->
<section class="hero" style="padding: 80px 0;">
    <div class="container">
        <div class="hero-content">
            <h1>Our Projects</h1>
            <p>Real-world automation solutions delivering measurable results</p>
        </div>
    </div>
</section>

<!-- PROJECTS GRID -->
<section class="section">
    <div class="container">
        <h2 class="section-title">Featured Case Studies</h2>
        <p class="section-subtitle">Success stories from our industrial automation implementations</p>
        
        <div class="projects-grid">
            <div class="project-card">
                <div class="project-image">🏭</div>
                <div class="project-content">
                    <div class="project-category">Manufacturing</div>
                    <h3>Automotive Assembly Line Automation</h3>
                    <p>Implemented a complete PLC-based automation system for a major automotive parts manufacturer, increasing production efficiency by 35% and reducing defect rates by 50%.</p>
                    <p style="font-size: 0.875rem; color: var(--gray-600); margin-top: 1rem;"><strong>Technologies:</strong> Siemens S7-1500, SCADA, Servo Motors</p>
                </div>
            </div>

            <div class="project-card">
                <div class="project-image">🔋</div>
                <div class="project-content">
                    <div class="project-category">Energy</div>
                    <h3>Power Distribution Control System</h3>
                    <p>Designed and installed advanced control panels for industrial power distribution, ensuring 99.9% uptime and seamless load balancing across multiple production lines.</p>
                    <p style="font-size: 0.875rem; color: var(--gray-600); margin-top: 1rem;"><strong>Technologies:</strong> Allen-Bradley, Energy Monitoring, Safety Systems</p>
                </div>
            </div>

            <div class="project-card">
                <div class="project-image">📊</div>
                <div class="project-content">
                    <div class="project-category">IoT</div>
                    <h3>Smart Factory Monitoring Platform</h3>
                    <p>Developed a comprehensive IoT solution providing real-time monitoring, predictive maintenance alerts, and production analytics for a large manufacturing facility.</p>
                    <p style="font-size: 0.875rem; color: var(--gray-600); margin-top: 1rem;"><strong>Technologies:</strong> Industrial IoT, Cloud Platform, Data Analytics</p>
                </div>
            </div>

            <div class="project-card">
                <div class="project-image">🥤</div>
                <div class="project-content">
                    <div class="project-category">Food & Beverage</div>
                    <h3>Beverage Bottling Line Control</h3>
                    <p>Automated bottling and packaging process with precise control systems, achieving 15,000 bottles per hour with minimal waste and consistent quality.</p>
                    <p style="font-size: 0.875rem; color: var(--gray-600); margin-top: 1rem;"><strong>Technologies:</strong> Mitsubishi PLC, Servo Control, Vision Systems</p>
                </div>
            </div>

            <div class="project-card">
                <div class="project-image">🏗️</div>
                <div class="project-content">
                    <div class="project-category">Material Handling</div>
                    <h3>Warehouse Automation System</h3>
                    <p>Implemented automated material handling and inventory management system, reducing processing time by 60% and improving accuracy to 99.8%.</p>
                    <p style="font-size: 0.875rem; color: var(--gray-600); margin-top: 1rem;"><strong>Technologies:</strong> Conveyor Control, RFID, WMS Integration</p>
                </div>
            </div>

            <div class="project-card">
                <div class="project-image">⚗️</div>
                <div class="project-content">
                    <div class="project-category">Chemical Processing</div>
                    <h3>Process Control & Safety System</h3>
                    <p>Designed safety-critical control systems for chemical processing plant, meeting stringent safety standards while optimizing production efficiency.</p>
                    <p style="font-size: 0.875rem; color: var(--gray-600); margin-top: 1rem;"><strong>Technologies:</strong> Safety PLC, DCS Integration, Emergency Shutdown</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- RESULTS -->
<section class="section stats">
    <div class="container">
        <h2 class="section-title" style="margin-bottom: 3rem;">Proven Results</h2>
        <div class="stats-grid">
            <div class="stat-item">
                <h3>35%</h3>
                <p>Average Efficiency Increase</p>
            </div>
            <div class="stat-item">
                <h3>99.8%</h3>
                <p>System Uptime</p>
            </div>
            <div class="stat-item">
                <h3>50%</h3>
                <p>Defect Reduction</p>
            </div>
            <div class="stat-item">
                <h3>100%</h3>
                <p>Client Satisfaction</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="section cta">
    <div class="container">
        <h2>Start Your Automation Journey</h2>
        <p>Let's discuss how we can transform your manufacturing process with proven solutions.</p>
        <a href="contact.php" class="btn btn-primary">Discuss Your Project</a>
    </div>
</section>

<?php include 'includes/footer.php'; ?>