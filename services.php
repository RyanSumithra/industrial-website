<?php 
require_once 'includes/config.php';

$current_page = 'services';
$page_title = 'Our Services | ' . SITE_NAME;
$page_description = 'PLC automation, control panels, custom electronics, and IoT solutions for industrial manufacturing.';

include 'includes/header.php'; 

?>

<!-- PAGE HEADER -->
<section class="hero" style="padding: 80px 0;">
    <div class="container">
        <div class="hero-content">
            <h1>Our Services</h1>
            <p>Comprehensive industrial automation solutions designed for your success</p>
        </div>
    </div>
</section>

<!-- PLC AUTOMATION -->
<section class="section" id="plc">
    <div class="container">
        <div class="about-intro">
            <div>
                <h2 style="color: var(--primary-blue); margin-bottom: 1rem;">⚙️ PLC Automation</h2>
                <h3 style="font-size: 2rem; margin-bottom: 1.5rem;">Programmable Logic Controller Systems</h3>
                <p style="margin-bottom: 1rem;">Our PLC automation services provide comprehensive control solutions for industrial processes. We design, program, and implement PLC systems using industry-leading platforms including Siemens, Allen-Bradley, and Mitsubishi.</p>
                <ul style="list-style: none; padding: 0;">
                    <li style="padding: 0.5rem 0;">✓ PLC programming and configuration</li>
                    <li style="padding: 0.5rem 0;">✓ SCADA system integration</li>
                    <li style="padding: 0.5rem 0;">✓ Process automation design</li>
                    <li style="padding: 0.5rem 0;">✓ System troubleshooting and optimization</li>
                </ul>
            </div>
            <div class="about-image">⚙️</div>
        </div>
    </div>
</section>

<!-- CONTROL PANELS -->
<section class="section" id="panels" style="background: var(--gray-100);">
    <div class="container">
        <div class="about-intro" style="flex-direction: row-reverse;">
            <div>
                <h2 style="color: var(--primary-blue); margin-bottom: 1rem;">🔌 Control Panels</h2>
                <h3 style="font-size: 2rem; margin-bottom: 1.5rem;">Custom Electrical Control Solutions</h3>
                <p style="margin-bottom: 1rem;">We design and manufacture custom control panels that meet your specific requirements and comply with international standards (IEC, UL, CE).</p>
                <ul style="list-style: none; padding: 0;">
                    <li style="padding: 0.5rem 0;">✓ Custom panel design and fabrication</li>
                    <li style="padding: 0.5rem 0;">✓ Motor control centers (MCC)</li>
                    <li style="padding: 0.5rem 0;">✓ Power distribution panels</li>
                    <li style="padding: 0.5rem 0;">✓ Safety system integration</li>
                </ul>
            </div>
            <div class="about-image">🔌</div>
        </div>
    </div>
</section>

<!-- CUSTOM ELECTRONICS -->
<section class="section" id="electronics">
    <div class="container">
        <div class="about-intro">
            <div>
                <h2 style="color: var(--primary-blue); margin-bottom: 1rem;">💡 Custom Electronics</h2>
                <h3 style="font-size: 2rem; margin-bottom: 1.5rem;">Tailored Electronic Solutions</h3>
                <p style="margin-bottom: 1rem;">Our custom electronics services provide specialized solutions for unique industrial challenges, from PCB design to complete system integration.</p>
                <ul style="list-style: none; padding: 0;">
                    <li style="padding: 0.5rem 0;">✓ PCB design and prototyping</li>
                    <li style="padding: 0.5rem 0;">✓ Embedded systems development</li>
                    <li style="padding: 0.5rem 0;">✓ Sensor integration</li>
                    <li style="padding: 0.5rem 0;">✓ Custom HMI solutions</li>
                </ul>
            </div>
            <div class="about-image">💡</div>
        </div>
    </div>
</section>

<!-- IOT SOLUTIONS -->
<section class="section" id="iot" style="background: var(--gray-100);">
    <div class="container">
        <div class="about-intro" style="flex-direction: row-reverse;">
            <div>
                <h2 style="color: var(--primary-blue); margin-bottom: 1rem;">🌐 IoT Solutions</h2>
                <h3 style="font-size: 2rem; margin-bottom: 1.5rem;">Industrial Internet of Things</h3>
                <p style="margin-bottom: 1rem;">Transform your manufacturing with smart, connected systems that provide real-time data, predictive maintenance, and remote monitoring capabilities.</p>
                <ul style="list-style: none; padding: 0;">
                    <li style="padding: 0.5rem 0;">✓ Industrial IoT platform integration</li>
                    <li style="padding: 0.5rem 0;">✓ Real-time monitoring dashboards</li>
                    <li style="padding: 0.5rem 0;">✓ Predictive maintenance systems</li>
                    <li style="padding: 0.5rem 0;">✓ Cloud connectivity and data analytics</li>
                </ul>
            </div>
            <div class="about-image">🌐</div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="section cta">
    <div class="container">
        <h2>Need a Custom Solution?</h2>
        <p>Let's discuss your specific automation requirements and develop the perfect solution.</p>
        <a href="contact.php" class="btn btn-primary">Request Consultation</a>
    </div>
</section>

<?php include 'includes/footer.php'; ?>