<?php 
// --- SETUP ---
require_once 'includes/config.php';

$current_page = 'home';
$page_title = SITE_TAGLINE . ' | ' . SITE_NAME;
$page_description = 'Delivering cutting-edge PLC automation, control systems, and custom electronics for modern manufacturing.';
$page_keywords = 'industrial automation, PLC programming, control panels, mechatronics, IoT solutions, manufacturing';

include 'includes/header.php'; 
?>

<style>
    /* --- Animations --- */
    @keyframes fadeUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    .animate-up { animation: fadeUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; opacity: 0; }
    .delay-1 { animation-delay: 0.1s; } .delay-2 { animation-delay: 0.2s; } .delay-3 { animation-delay: 0.3s; }

    /* --- 1. Hero Section --- */
    .hero {
        /* Tech Pattern Overlay + Red Glow Gradient */
        background: 
            linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)),
            repeating-linear-gradient(0deg, transparent, transparent 2px, rgba(255, 51, 51, 0.03) 2px, rgba(255, 51, 51, 0.03) 4px),
            radial-gradient(circle at 70% 30%, rgba(200, 0, 0, 0.3), transparent 50%),
            linear-gradient(180deg, #050505 0%, #111 100%);
        padding: 140px 0 120px;
        position: relative;
        overflow: hidden;
        border-bottom: 1px solid #222;
    }
    .hero-badge span {
        background: rgba(255, 51, 51, 0.1); color: var(--primary-red);
        border: 1px solid var(--primary-red); padding: 10px 20px;
        border-radius: 50px; font-size: 0.8rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 1.5px;
        box-shadow: 0 0 15px rgba(255, 51, 51, 0.2);
    }
    .hero h1 {
        font-size: 4rem; font-weight: 900; margin: 1.5rem 0; line-height: 1.05;
        letter-spacing: -1px; color: white;
    }
    .hero-subtitle { color: #999; font-size: 1.35rem; max-width: 650px; margin-bottom: 3rem; font-weight: 400; }

    /* --- 2. Trust Badges --- */
    .trust-badges { background: #080808; border-bottom: 1px solid #1a1a1a; padding: 50px 0; }
    .badge-item {
        display: flex; align-items: center; gap: 15px; padding: 25px;
        background: rgba(255,255,255,0.02); border: 1px solid #222;
        border-radius: 12px; transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }
    .badge-item:hover { 
        border-color: var(--primary-red); 
        background: rgba(255, 51, 51, 0.05);
        transform: translateY(-5px);
        box-shadow: 0 10px 20px -10px rgba(255, 51, 51, 0.3);
    }
    .badge-icon { font-size: 2rem; filter: grayscale(100%) opacity(0.7); transition: 0.3s; }
    .badge-item:hover .badge-icon { filter: grayscale(0%) opacity(1); transform: scale(1.1); }
    .badge-content h4 { color: white; margin-bottom: 4px; font-size: 1.1rem; font-weight: 700; }
    .badge-content p { color: #777; font-size: 0.9rem; margin: 0; }

    /* --- 3. High-Tech Cards --- */
    .service-card, .project-card {
        background: #111; border: 1px solid #222; padding: 2.5rem;
        border-radius: 12px; transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
        height: 100%; display: flex; flex-direction: column; position: relative; z-index: 1;
        overflow: hidden;
    }
    /* Card Glow Effect */
    .service-card::before, .project-card::before {
        content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%;
        background: radial-gradient(circle at center, rgba(255,51,51,0.2) 0%, transparent 70%);
        opacity: 0; transition: opacity 0.4s ease; z-index: -1;
    }
    .service-card:hover, .project-card:hover {
        border-color: var(--primary-red); transform: translateY(-7px);
        box-shadow: 0 15px 40px -10px rgba(255, 51, 51, 0.3);
    }
    .service-card:hover::before, .project-card:hover::before { opacity: 1; }

    .service-icon, .project-image {
        font-size: 2.5rem; margin-bottom: 2rem;
        background: linear-gradient(135deg, #1a1a1a, #0a0a0a);
        width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;
        border-radius: 12px; border: 1px solid #333; box-shadow: inset 0 0 10px rgba(0,0,0,0.5);
    }
    .service-card h3, .project-card h3 { color: white; margin-bottom: 1rem; font-size: 1.5rem; font-weight: 700; }
    .service-card p, .project-card p { color: #888; line-height: 1.7; margin-bottom: 2rem; flex-grow: 1; }
    
    .tech-tag {
        background: #1a1a1a; color: #ccc; padding: 6px 12px; font-size: 0.8rem; font-weight: 600;
        border-radius: 4px; border: 1px solid #333; display: inline-block; margin: 0 5px 5px 0;
    }

    /* --- 4. Glowing Stats --- */
    .stats-section { background: #080808; padding: 80px 0; border-top: 1px solid #222; border-bottom: 1px solid #222; position: relative; }
    /* Ambient red light behind stats */
    .stats-section::after {
        content: ''; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);
        width: 80%; height: 50%; background: rgba(255, 51, 51, 0.05); filter: blur(100px); pointer-events: none;
    }
    .stat-item { text-align: center; position: relative; z-index: 2; }
    .stat-number { 
        font-size: 4.5rem; font-weight: 900; margin-bottom: 0.5rem; 
        color: var(--primary-red); text-shadow: 0 0 20px rgba(255, 51, 51, 0.4);
    }
    .stat-label { color: white; text-transform: uppercase; letter-spacing: 2px; font-size: 0.9rem; font-weight: 700; }

    /* --- 5. CTA Section --- */
    .cta-section {
        background: linear-gradient(45deg, #cc0000, #990000);
        text-align: center; padding: 120px 0; position: relative; overflow: hidden;
    }
    /* Pattern overlay for CTA */
    .cta-section::before {
        content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%;
        background-image: url("data:image/svg+xml,%3Csvg width='20' height='20' viewBox='0 0 20 20' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.05' fill-rule='evenodd'%3E%3Ccircle cx='3' cy='3' r='3'/%3E%3Ccircle cx='13' cy='13' r='3'/%3E%3C/g%3E%3C/svg%3E");
        pointer-events: none;
    }
    .cta-content { position: relative; z-index: 2; }
    .cta-content h2 { font-size: 3rem; color: white; margin-bottom: 1.5rem; font-weight: 900; }
    .cta-content p { color: rgba(255,255,255,0.9); font-size: 1.3rem; margin-bottom: 3rem; max-width: 700px; margin-inline: auto; }

    /* Buttons & Layouts */
    .btn-primary { padding: 14px 32px; font-size: 1rem; }
    .btn-white {
        background: white; color: var(--primary-red); padding: 14px 32px; font-size: 1rem; font-weight: 700;
        display: inline-flex; align-items: center; gap: 10px; border-radius: 4px; transition: 0.3s; text-decoration: none;
    }
    .btn-white:hover { background: #eee; transform: translateY(-2px); box-shadow: 0 10px 20px -10px rgba(255,255,255,0.5); }
    
    .btn-text-red {
        color: var(--primary-red); font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: 0.3s;
    }
    .btn-text-red:hover { gap: 12px; color: #ff6666; }

    .badges-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 25px; }
    .services-grid, .projects-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 40px; }
    .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 40px; }
    .section-header { text-align: center; margin-bottom: 70px; }
    .section-label { color: var(--primary-red); font-weight: 800; text-transform: uppercase; font-size: 0.9rem; letter-spacing: 3px; display: block; margin-bottom: 10px; }
    .section-title { font-size: 3rem; color: white; margin: 0 0 15px 0; font-weight: 900; }
    .section-subtitle { color: #888; max-width: 600px; margin: 0 auto; font-size: 1.1rem; }
</style>

<section class="hero">
    <div class="container">
        <div class="hero-content animate-up">
            <div class="hero-badge">
                <span>🏆 Global Industry Leader</span>
            </div>
            <h1 class="animate-up delay-1">Industrial Automation & <br><span style="color: var(--primary-red); text-shadow: 0 0 30px rgba(255,51,51,0.4);">Mechatronics Solutions</span></h1>
            <p class="hero-subtitle animate-up delay-2">Powering the future of manufacturing with cutting-edge PLC systems, robotics, and custom IoT integration.</p>
            <div class="hero-buttons animate-up delay-3" style="display: flex; gap: 20px; flex-wrap: wrap;">
                <a href="services.php" class="btn btn-primary">
                    <span>Explore Services</span>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
                <a href="contact.php" class="btn btn-white">
                    <span>Get a Quote</span>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </div>
</section>

<section class="trust-badges">
    <div class="container">
        <div class="badges-grid animate-up delay-1">
            <div class="badge-item">
                <div class="badge-icon">💎</div>
                <div class="badge-content">
                    <h4>ISO 9001 Certified</h4>
                    <p>Global Quality Standards</p>
                </div>
            </div>
            <div class="badge-item">
                <div class="badge-icon">🛡️</div>
                <div class="badge-content">
                    <h4>24/7 Critical Support</h4>
                    <p>Always-On Assistance</p>
                </div>
            </div>
            <div class="badge-item">
                <div class="badge-icon">⚡</div>
                <div class="badge-content">
                    <h4>Rapid Response</h4>
                    <p>Sub-2 Hour Deployment</p>
                </div>
            </div>
            <div class="badge-item">
                <div class="badge-icon">🌐</div>
                <div class="badge-content">
                    <h4>Global Reach</h4>
                    <p>Worldwide Implementation</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section services-section" style="background: #050505; padding: 120px 0;">
    <div class="container">
        <div class="section-header animate-up">
            <span class="section-label">Our Expertise</span>
            <h2 class="section-title">Core Competencies</h2>
            <p class="section-subtitle">Engineered solutions tailored for high-performance manufacturing environments.</p>
        </div>
        
        <div class="services-grid">
            <div class="service-card animate-up delay-1">
                <div class="service-icon">⚙️</div>
                <div class="service-content">
                    <h3>PLC Automation</h3>
                    <p>Architecting robust programmable logic controller systems for mission-critical industrial processes.</p>
                    <ul style="list-style: none; padding: 0; margin-bottom: 25px; color: #777; font-size: 0.9rem; font-weight: 500;">
                        <li style="margin-bottom: 8px;">✓ Siemens & Allen-Bradley Experts</li>
                        <li style="margin-bottom: 8px;">✓ Advanced SCADA Integration</li>
                        <li>✓ Process Logic Optimization</li>
                    </ul>
                    <a href="services.php#plc" class="btn-text-red">
                        <span>Explore PLC Solutions &rarr;</span>
                    </a>
                </div>
            </div>

            <div class="service-card animate-up delay-2">
                <div class="service-icon">🔌</div>
                <div class="service-content">
                    <h3>Control Panels</h3>
                    <p>Precision-engineered electrical control panels built to exceed international safety standards.</p>
                    <ul style="list-style: none; padding: 0; margin-bottom: 25px; color: #777; font-size: 0.9rem; font-weight: 500;">
                        <li style="margin-bottom: 8px;">✓ UL/CE Certified Fabrication</li>
                        <li style="margin-bottom: 8px;">✓ High-Density MCC & PCC</li>
                        <li>✓ Integrated Safety Systems</li>
                    </ul>
                    <a href="services.php#panels" class="btn-text-red">
                        <span>View Panel Capabilities &rarr;</span>
                    </a>
                </div>
            </div>

            <div class="service-card animate-up delay-3">
                <div class="service-icon">💡</div>
                <div class="service-content">
                    <h3>Custom Electronics</h3>
                    <p>Developing specialized electronic hardware for unique industrial challenges.</p>
                    <ul style="list-style: none; padding: 0; margin-bottom: 25px; color: #777; font-size: 0.9rem; font-weight: 500;">
                        <li style="margin-bottom: 8px;">✓ Multi-Layer PCB Design</li>
                        <li style="margin-bottom: 8px;">✓ Real-Time Embedded Systems</li>
                        <li>✓ Precision Sensor Integration</li>
                    </ul>
                    <a href="services.php#electronics" class="btn-text-red">
                        <span>Discover Custom Solutions &rarr;</span>
                    </a>
                </div>
            </div>

            <div class="service-card animate-up delay-1">
                <div class="service-icon">📡</div>
                <div class="service-content">
                    <h3>IoT Solutions</h3>
                    <p>Connecting your factory floor to the cloud for unprecedented data visibility.</p>
                    <ul style="list-style: none; padding: 0; margin-bottom: 25px; color: #777; font-size: 0.9rem; font-weight: 500;">
                        <li style="margin-bottom: 8px;">✓ Real-time Asset Monitoring</li>
                        <li style="margin-bottom: 8px;">✓ AI-Driven Predictive Maintenance</li>
                        <li>✓ Secure Cloud Analytics Dashboards</li>
                    </ul>
                    <a href="services.php#iot" class="btn-text-red">
                        <span>See IoT in Action &rarr;</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section stats-section">
    <div class="container">
        <div class="stats-grid animate-up">
            <div class="stat-item">
                <div class="stat-number">15+</div>
                <div class="stat-label">Years Proven Experience</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">200+</div>
                <div class="stat-label">Successful Deployments</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">50+</div>
                <div class="stat-label">Enterprise Clients</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">24/7</div>
                <div class="stat-label">Mission-Critical Support</div>
            </div>
        </div>
    </div>
</section>

<section class="section projects-section" style="background: #0a0a0a; padding: 120px 0;">
    <div class="container">
        <div class="section-header animate-up">
            <span class="section-label">Our Work</span>
            <h2 class="section-title">Featured Implementations</h2>
            <p class="section-subtitle">Examine our track record of delivering complex automation projects.</p>
        </div>
        
        <div class="projects-grid">
            <div class="project-card animate-up delay-1">
                <div class="project-image">🏭</div>
                <div class="project-content">
                    <div style="color: var(--primary-red); font-size: 0.85rem; text-transform: uppercase; font-weight: 800; margin-bottom: 10px; letter-spacing: 1px;">Automotive Sector</div>
                    <h3>High-Speed Assembly Line</h3>
                    <p>End-to-end automation for a major automotive components manufacturer, increasing throughput by 40%.</p>
                    <div class="project-tech">
                        <span class="tech-tag">Siemens S7-1500</span>
                        <span class="tech-tag">Ignition SCADA</span>
                        <span class="tech-tag">Fanuc Robotics</span>
                    </div>
                    <a href="projects.php" class="btn-text-red" style="margin-top: auto;">View Case Study &rarr;</a>
                </div>
            </div>

            <div class="project-card animate-up delay-2">
                <div class="project-image">⚡</div>
                <div class="project-content">
                    <div style="color: var(--primary-red); font-size: 0.85rem; text-transform: uppercase; font-weight: 800; margin-bottom: 10px; letter-spacing: 1px;">Energy & Utilities</div>
                    <h3>Smart Grid Distribution</h3>
                    <p>Modernizing power distribution infrastructure with intelligent, redundant control panels.</p>
                    <div class="project-tech">
                        <span class="tech-tag">Allen-Bradley ControlLogix</span>
                        <span class="tech-tag">Safety SIL3</span>
                        <span class="tech-tag">Power Monitoring</span>
                    </div>
                    <a href="projects.php" class="btn-text-red" style="margin-top: auto;">View Case Study &rarr;</a>
                </div>
            </div>

            <div class="project-card animate-up delay-3">
                <div class="project-image">🧠</div>
                <div class="project-content">
                    <div style="color: var(--primary-red); font-size: 0.85rem; text-transform: uppercase; font-weight: 800; margin-bottom: 10px; letter-spacing: 1px;">Industry 4.0</div>
                    <h3>Predictive Maintenance Platform</h3>
                    <p>IoT sensor network deployment across 50+ machines for real-time health monitoring and failure prediction.</p>
                    <div class="project-tech">
                        <span class="tech-tag">Custom IoT Gateway</span>
                        <span class="tech-tag">AWS IoT Core</span>
                        <span class="tech-tag">Machine Learning</span>
                    </div>
                    <a href="projects.php" class="btn-text-red" style="margin-top: auto;">View Case Study &rarr;</a>
                </div>
            </div>
        </div>
        
        <div class="section-footer animate-up delay-2" style="text-align: center; margin-top: 80px;">
            <a href="projects.php" class="btn btn-white" style="background: transparent; color: white; border: 1px solid #333;">
                View Full Portfolio
            </a>
        </div>
    </div>
</section>

<section class="section cta-section">
    <div class="container">
        <div class="cta-content animate-up">
            <h2>Ready to Revolutionize Your Operations?</h2>
            <p>Partner with us to engineer the future of your manufacturing process.</p>
            <div class="cta-buttons" style="display: flex; gap: 20px; justify-content: center; flex-wrap: wrap; margin-top: 40px;">
                <a href="contact.php" class="btn btn-white">
                    <span>Initiate Consultation</span>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
                <a href="tel:<?php echo SITE_PHONE; ?>" class="btn" style="border: 1px solid rgba(255,255,255,0.3); color: white; padding: 14px 32px; font-weight: 700; display: inline-flex; align-items: center; gap: 10px; border-radius: 4px; text-decoration: none; transition:0.3s;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/></svg>
                    <span><?php echo SITE_PHONE; ?></span>
                </a>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>