<?php 
require_once 'includes/config.php';

$current_page = 'about';
$page_title = 'About Us | ' . SITE_NAME;
$page_description = 'Learn about our 15+ years of experience in industrial automation and mechatronics engineering.';
$page_keywords = 'about industrial automation, company history, team expertise, mission vision';

include 'includes/header.php'; 
include 'includes/navbar.php'; 
?>

<!-- PAGE HEADER -->
<section class="page-hero">
    <div class="container">
        <div class="page-hero-content">
            <h1>About IndustrialTech</h1>
            <p>Pioneering industrial automation solutions since 2009</p>
        </div>
    </div>
</section>

<!-- ABOUT INTRO -->
<section class="section">
    <div class="container">
        <div class="about-intro">
            <div class="about-content">
                <div class="section-label">Our Story</div>
                <h2 class="section-title">Leading the Future of Industrial Automation</h2>
                <div class="about-text">
                    <p>Founded in 2009, IndustrialTech has been at the forefront of industrial automation and mechatronics engineering. We specialize in delivering cutting-edge solutions that transform manufacturing processes and improve operational efficiency.</p>
                    <p>Our team of experienced engineers and technicians work closely with clients to design, implement, and maintain automation systems that meet the highest industry standards.</p>
                    <p>With over 200 successful projects and a commitment to innovation, we continue to be a trusted partner for industrial companies worldwide.</p>
                </div>
                <div class="about-metrics">
                    <div class="metric">
                        <strong>15+</strong>
                        <span>Years in Industry</span>
                    </div>
                    <div class="metric">
                        <strong>50+</strong>
                        <span>Expert Engineers</span>
                    </div>
                    <div class="metric">
                        <strong>24/7</strong>
                        <span>Technical Support</span>
                    </div>
                </div>
            </div>
            <div class="about-visual">
                <div class="visual-image">
                    <div class="image-placeholder">🏢</div>
                </div>
                <div class="visual-badge">
                    <span>🏆 Industry Certified</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- MISSION & VISION -->
<section class="section mission-section">
    <div class="container">
        <div class="mission-vision-grid">
            <div class="mission-card">
                <div class="mission-icon">🎯</div>
                <div class="mission-content">
                    <h3>Our Mission</h3>
                    <p>To deliver innovative automation solutions that enhance productivity, reduce operational costs, and enable our clients to achieve their manufacturing goals through cutting-edge technology and expert engineering services.</p>
                </div>
            </div>
            <div class="mission-card">
                <div class="mission-icon">🚀</div>
                <div class="mission-content">
                    <h3>Our Vision</h3>
                    <p>To be the leading automation partner in the industry, recognized for technical excellence, customer satisfaction, and our commitment to advancing manufacturing through intelligent automation solutions.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- VALUES -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="section-label">Our Values</span>
            <h2 class="section-title">What Drives Us</h2>
            <p class="section-subtitle">The principles that guide everything we do</p>
        </div>
        
        <div class="values-grid">
            <div class="value-card">
                <div class="value-icon">🎓</div>
                <div class="value-content">
                    <h3>Technical Excellence</h3>
                    <p>We maintain the highest standards in engineering and follow international best practices.</p>
                </div>
            </div>
            <div class="value-card">
                <div class="value-icon">🤝</div>
                <div class="value-content">
                    <h3>Client Partnership</h3>
                    <p>We build long-term relationships based on trust, reliability, and shared success.</p>
                </div>
            </div>
            <div class="value-card">
                <div class="value-icon">⚡</div>
                <div class="value-content">
                    <h3>Innovation</h3>
                    <p>Continuously adopting new technologies to stay ahead in the automation industry.</p>
                </div>
            </div>
            <div class="value-card">
                <div class="value-icon">🛡️</div>
                <div class="value-content">
                    <h3>Safety First</h3>
                    <p>Prioritizing safety in all our designs and implementations.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- TEAM SECTION (Optional Placeholder) -->
<section class="section team-section">
    <div class="container">
        <div class="section-header">
            <span class="section-label">Our Team</span>
            <h2 class="section-title">Meet Our Experts</h2>
            <p class="section-subtitle">Certified professionals with decades of combined experience</p>
        </div>
        
        <div class="team-grid">
            <div class="team-card">
                <div class="team-image">👨‍💼</div>
                <div class="team-content">
                    <h3>Engineering Team</h3>
                    <p>Certified PLC programmers, electrical engineers, and automation specialists.</p>
                </div>
            </div>
            <div class="team-card">
                <div class="team-image">👩‍🔧</div>
                <div class="team-content">
                    <h3>Technical Support</h3>
                    <p>24/7 technical assistance and maintenance specialists.</p>
                </div>
            </div>
            <div class="team-card">
                <div class="team-image">👨‍💻</div>
                <div class="team-content">
                    <h3>R&D Department</h3>
                    <p>Innovation team focused on next-generation automation solutions.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="section cta-section">
    <div class="container">
        <div class="cta-content">
            <h2>Partner With Us</h2>
            <p>Experience the difference of working with industry-leading automation experts.</p>
            <a href="contact.php" class="btn btn-primary">Get Started</a>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>