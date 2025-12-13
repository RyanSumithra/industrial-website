<?php 
require_once 'includes/config.php';

$current_page = 'about';
$page_title = 'About Us | ' . SITE_NAME;
$page_description = 'Learn about our 15+ years of experience in industrial automation and mechatronics engineering.';

include 'includes/header.php'; 

?>

<!-- ABOUT INTRO -->
<section class="section">
    <div class="container">
        <div class="about-intro">
            <div>
                <h2 class="section-title" style="text-align: left;">About IndustrialTech</h2>
                <p style="margin-bottom: 1rem;">Founded in 2009, IndustrialTech has been at the forefront of industrial automation and mechatronics engineering. We specialize in delivering cutting-edge solutions that transform manufacturing processes and improve operational efficiency.</p>
                <p style="margin-bottom: 1rem;">Our team of experienced engineers and technicians work closely with clients to design, implement, and maintain automation systems that meet the highest industry standards.</p>
                <p>With over 200 successful projects and a commitment to innovation, we continue to be a trusted partner for industrial companies worldwide.</p>
            </div>
            <div class="about-image">🏢</div>
        </div>
    </div>
</section>

<!-- MISSION & VISION -->
<section class="section" style="background: var(--gray-100);">
    <div class="container">
        <div class="mission-vision">
            <div class="mission-card">
                <h3>Our Mission</h3>
                <p>To deliver innovative automation solutions that enhance productivity, reduce operational costs, and enable our clients to achieve their manufacturing goals through cutting-edge technology and expert engineering services.</p>
            </div>
            <div class="mission-card">
                <h3>Our Vision</h3>
                <p>To be the leading automation partner in the industry, recognized for technical excellence, customer satisfaction, and our commitment to advancing manufacturing through intelligent automation solutions.</p>
            </div>
        </div>
    </div>
</section>

<!-- EXPERTISE -->
<section class="section">
    <div class="container">
        <h2 class="section-title">Our Expertise</h2>
        <p class="section-subtitle">Decades of experience across multiple industrial sectors</p>
        
        <div class="services-grid">
            <div class="service-card">
                <div class="service-icon">🎓</div>
                <h3>Certified Engineers</h3>
                <p>Our team holds industry certifications including PLC programming, electrical engineering, and industrial automation.</p>
            </div>
            <div class="service-card">
                <div class="service-icon">🔧</div>
                <h3>Technical Excellence</h3>
                <p>We follow international standards and best practices in all our projects and implementations.</p>
            </div>
            <div class="service-card">
                <div class="service-icon">🤝</div>
                <h3>Client Partnership</h3>
                <p>Long-term relationships built on trust, reliability, and consistent delivery of quality solutions.</p>
            </div>
            <div class="service-card">
                <div class="service-icon">🚀</div>
                <h3>Innovation Focus</h3>
                <p>Continuously adopting new technologies and methodologies to stay ahead in the automation industry.</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="section cta">
    <div class="container">
        <h2>Partner With Us</h2>
        <p>Experience the difference of working with industry-leading automation experts.</p>
        <a href="contact.php" class="btn btn-primary">Get Started</a>
    </div>
</section>

<?php include 'includes/footer.php'; ?>