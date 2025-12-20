<?php 
require_once 'includes/config.php';

$current_page = 'projects';
$page_title = 'Project Portfolio | ' . SITE_NAME;

include 'includes/header.php'; 
?>

<style>
    /* --- VARIABLES & THEME SETUP --- */
    :root {
        --mono: 'JetBrains Mono', 'Courier New', monospace;
        --sans: 'Inter', system-ui, -apple-system, sans-serif;
    }

    body {
        background-color: var(--bg-body);
        color: var(--text-main);
        font-family: var(--sans);
        margin: 0;
        overflow-x: hidden;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    /* --- HERO SECTION (Centered) --- */
    .page-hero {
        position: relative;
        min-height: 60vh; /* Force height for vertical centering */
        display: flex;
        flex-direction: column;
        justify-content: center; /* Vertical Center */
        align-items: center;     /* Horizontal Center */
        text-align: center;
        padding: 100px 5%;
        background: var(--bg-body);
        border-bottom: 1px solid var(--border-color);
        overflow: hidden;
    }
    
    /* Tech Grid Background */
    .page-hero::before {
        content: ''; position: absolute; inset: 0;
        background-image: 
            linear-gradient(var(--border-color) 1px, transparent 1px),
            linear-gradient(90deg, var(--border-color) 1px, transparent 1px);
        background-size: 40px 40px;
        opacity: 0.1;
        z-index: 0;
    }

    .page-hero-overlay {
        position: absolute; inset: 0;
        background: radial-gradient(circle at 50% 50%, rgba(255, 51, 51, 0.05), var(--bg-body) 70%);
        z-index: 1;
    }
    
    /* Light Mode Hero Override */
    body.light-mode .page-hero-overlay {
        background: radial-gradient(circle at 50% 50%, rgba(255, 51, 51, 0.05), rgba(255,255,255,0) 70%);
    }

    .hero-content { 
        position: relative; 
        z-index: 2; 
        width: 100%;
        max-width: 900px; /* Constrain width for centering */
    }

    .hero-badge {
        display: inline-block;
        font-family: var(--mono);
        font-size: 0.8rem;
        color: var(--primary-red);
        background: rgba(255, 51, 51, 0.1);
        padding: 6px 12px;
        border-radius: 4px;
        border: 1px solid rgba(255, 51, 51, 0.2);
        margin-bottom: 20px;
    }

    .page-hero h1 {
        font-size: clamp(2.5rem, 6vw, 4.5rem);
        font-weight: 900;
        color: var(--text-main);
        margin-bottom: 20px;
        letter-spacing: -1px;
    }

    .hero-subtitle {
        color: var(--text-muted);
        font-size: 1.1rem;
        max-width: 600px;
        margin: 0 auto 50px;
        line-height: 1.6;
    }

    .hero-stats {
        display: flex; justify-content: center; gap: 50px; flex-wrap: wrap;
    }
    .hero-stat { text-align: center; }
    .hero-stat-number { font-size: 2.5rem; font-weight: 800; color: var(--primary-red); line-height: 1; }
    .hero-stat-label { font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; margin-top: 8px; letter-spacing: 1px; font-weight: 600; }

    /* --- CATEGORY NAVIGATION --- */
    .category-nav {
        position: sticky; top: 80px; z-index: 90;
        background: var(--nav-bg);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border-bottom: 1px solid var(--border-color);
        padding: 15px 0;
        margin-bottom: 40px;
    }

    .category-tabs {
        display: flex; justify-content: center; gap: 10px; flex-wrap: wrap;
    }

    .category-tab {
        background: var(--bg-surface);
        border: 1px solid var(--border-color);
        color: var(--text-muted);
        padding: 10px 24px;
        border-radius: 50px;
        font-weight: 600; font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex; align-items: center; gap: 8px;
    }

    .category-tab:hover {
        border-color: var(--primary-red);
        color: var(--text-main);
        background: var(--bg-surface-2);
    }

    .category-tab.active {
        background: var(--primary-red);
        border-color: var(--primary-red);
        color: white;
        box-shadow: 0 4px 15px rgba(255, 51, 51, 0.3);
    }

    /* --- PROJECTS GRID --- */
    .projects-container {
        padding-bottom: 80px;
    }

    .category-header {
        text-align: center; margin-bottom: 40px; padding-top: 20px;
        display: none; /* Hidden by default, shown via JS */
    }
    .category-header.active { display: block; }

    .category-title {
        font-size: 1.8rem; font-weight: 800; color: var(--text-main); margin-bottom: 10px;
    }
    .category-desc { color: var(--text-muted); }

    .projects-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 30px;
        max-width: 1400px; margin: 0 auto;
    }

    /* --- PROJECT CARD --- */
    .project-card {
        background: var(--bg-surface-2);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        overflow: hidden;
        display: flex; flex-direction: column;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }

    .project-card:hover {
        transform: translateY(-8px);
        border-color: var(--primary-red);
        box-shadow: 0 20px 40px rgba(0,0,0,0.3);
    }
    body.light-mode .project-card:hover {
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }

    .project-image-wrap {
        height: 180px; width: 100%;
        position: relative; overflow: hidden;
        background: #000;
        border-bottom: 1px solid var(--border-color);
    }
    
    .project-image-wrap img {
        width: 100%; height: 100%; object-fit: cover;
        transition: transform 0.6s ease;
        opacity: 0.9;
    }
    body.light-mode .project-image-wrap img { opacity: 1; }
    
    .project-card:hover .project-image-wrap img {
        transform: scale(1.1); opacity: 1;
    }

    .project-badge {
        position: absolute; top: 15px; left: 15px;
        background: rgba(255, 51, 51, 0.9);
        color: white; padding: 4px 10px; border-radius: 4px;
        font-size: 0.7rem; font-weight: 700; text-transform: uppercase;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }

    .project-content {
        padding: 25px;
        display: flex; flex-direction: column; flex-grow: 1;
    }

    .project-title {
        font-size: 1.1rem; font-weight: 700; color: var(--text-main);
        margin: 0 0 10px 0; line-height: 1.3;
    }

    .project-desc {
        font-size: 0.9rem; color: var(--text-muted);
        line-height: 1.6; margin-bottom: 20px; flex-grow: 1;
    }

    .project-tech {
        display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 20px;
    }
    .tech-pill {
        font-size: 0.75rem; color: var(--text-muted);
        background: var(--bg-surface);
        border: 1px solid var(--border-color);
        padding: 4px 10px; border-radius: 50px;
    }

    .project-footer {
        border-top: 1px solid var(--border-color);
        padding-top: 15px; margin-top: auto;
        display: flex; justify-content: space-between; align-items: center;
    }
    
    .project-link {
        color: var(--primary-red); font-weight: 700; font-size: 0.85rem;
        text-decoration: none; text-transform: uppercase; letter-spacing: 0.5px;
        display: flex; align-items: center; gap: 5px; transition: gap 0.2s;
    }
    .project-link:hover { gap: 8px; }

    /* --- RESPONSIVE --- */
    @media (max-width: 768px) {
        .page-hero { padding: 80px 20px 40px; min-height: auto; }
        .hero-stats { gap: 25px; }
        .hero-stat-number { font-size: 2rem; }
        .category-nav { top: 70px; overflow-x: auto; padding: 15px 20px; justify-content: flex-start; }
        .category-tabs { flex-wrap: nowrap; padding-bottom: 5px; }
        .category-tab { white-space: nowrap; }
    }
    
    /* Animation Utility */
    .fade-in { animation: fadeIn 0.5s ease forwards; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
</style>

<section class="page-hero">
    <div class="page-hero-overlay"></div>
    <div class="hero-content">
        <div class="hero-badge">PORTFOLIO OVERVIEW</div>
        <h1>Engineering Projects</h1>
        <p class="hero-subtitle">
            Explore our complete collection of embedded systems and Raspberry Pi projects with real-world applications.
        </p>
        
        <div class="hero-stats">
            <div class="hero-stat">
                <div class="hero-stat-number">17</div>
                <div class="hero-stat-label">Embedded</div>
            </div>
            <div class="hero-stat">
                <div class="hero-stat-number">10</div>
                <div class="hero-stat-label">Raspberry Pi</div>
            </div>
            <div class="hero-stat">
                <div class="hero-stat-number">100%</div>
                <div class="hero-stat-label">Functional</div>
            </div>
        </div>
    </div>
</section>

<section class="category-nav">
    <div class="container">
        <div class="category-tabs">
            <button class="category-tab active" onclick="filterProjects('all', this)">
                <span>📁</span> All Projects
            </button>
            <button class="category-tab" onclick="filterProjects('embedded', this)">
                <span>🔌</span> Embedded Systems
            </button>
            <button class="category-tab" onclick="filterProjects('raspberry', this)">
                <span>🍓</span> Raspberry Pi
            </button>
            <button class="category-tab" onclick="filterProjects('additional', this)">
                <span>✨</span> Additional Projects
            </button>
        </div>
    </div>
</section>

<section class="projects-container">
    <div class="container">
        
        <div id="embedded-section" class="project-group">
            <div class="category-header active">
                <h2 class="category-title">Embedded Systems</h2>
                <p class="category-desc">Microcontroller-based solutions for industrial and consumer applications</p>
            </div>
            <div class="projects-grid">
                <div class="project-card">
                    <div class="project-image-wrap">
                        <span class="project-badge">Tracking</span>
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRGlSF9DnpS05kKA6MIp3UJxjQ6J2R8zmOXXQ&s" alt="GPS">
                    </div>
                    <div class="project-content">
                        <h3 class="project-title">Vehicle Tracking GPS–GSM</h3>
                        <p class="project-desc">Real-time vehicle location tracking sent via SMS using Arduino, GPS, and GSM modules.</p>
                        <div class="project-tech"><span class="tech-pill">GPS</span><span class="tech-pill">GSM</span><span class="tech-pill">Arduino</span></div>
                        <div class="project-footer"><a href="#" class="project-link">Details &rarr;</a></div>
                    </div>
                </div>
                <div class="project-card">
                    <div class="project-image-wrap">
                        <span class="project-badge">Automation</span>
                        <img src="https://telemecaniquesensors.com/sites/default/files/generics/9006BR1602_AutoDoors_HS.jpg" alt="Train">
                    </div>
                    <div class="project-content">
                        <h3 class="project-title">Automatic Train Doors</h3>
                        <p class="project-desc">Automated door opening mechanism based on station arrival signals and safety sensors.</p>
                        <div class="project-tech"><span class="tech-pill">IR Sensor</span><span class="tech-pill">Motor</span></div>
                        <div class="project-footer"><a href="#" class="project-link">Details &rarr;</a></div>
                    </div>
                </div>
                <div class="project-card">
                    <div class="project-image-wrap">
                        <span class="project-badge">Safety</span>
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQIK5RQ2XDgC8G5HEpu3TSENa0IwM1axnuUOA&s" alt="Beacon">
                    </div>
                    <div class="project-content">
                        <h3 class="project-title">Beacon Flasher System</h3>
                        <p class="project-desc">Microcontroller-controlled warning lights with variable patterns for emergency vehicles.</p>
                        <div class="project-tech"><span class="tech-pill">PIC16F</span><span class="tech-pill">LEDs</span></div>
                        <div class="project-footer"><a href="#" class="project-link">Details &rarr;</a></div>
                    </div>
                </div>
                <div class="project-card">
                    <div class="project-image-wrap">
                        <span class="project-badge">Security</span>
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ_4qlqYqMHu-nN0LRCH1hiloNfnA5hEmYXCw&s" alt="Breaker">
                    </div>
                    <div class="project-content">
                        <h3 class="project-title">Password Circuit Breaker</h3>
                        <p class="project-desc">Digital keypad security system that only allows power flow upon correct password entry.</p>
                        <div class="project-tech"><span class="tech-pill">Keypad</span><span class="tech-pill">Relay</span></div>
                        <div class="project-footer"><a href="#" class="project-link">Details &rarr;</a></div>
                    </div>
                </div>
                <div class="project-card">
                    <div class="project-image-wrap">
                        <span class="project-badge">Automotive</span>
                        <img src="https://pictures.dealer.com/s/smythevolvovcna/1239/6359b64ef1cb7a160609c7870bee9109x.jpg" alt="Collision">
                    </div>
                    <div class="project-content">
                        <h3 class="project-title">Collision Avoidance</h3>
                        <p class="project-desc">Rear-end collision prevention using ultrasonic sensors and CAN bus communication.</p>
                        <div class="project-tech"><span class="tech-pill">CAN</span><span class="tech-pill">Ultrasonic</span></div>
                        <div class="project-footer"><a href="#" class="project-link">Details &rarr;</a></div>
                    </div>
                </div>
                <div class="project-card">
                    <div class="project-image-wrap">
                        <span class="project-badge">Biometric</span>
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTLf2oiMRmJ2MF6KnAlq5DQP0fCSs1xoH8_JQ&s" alt="Fingerprint">
                    </div>
                    <div class="project-content">
                        <h3 class="project-title">PC Fingerprint Login</h3>
                        <p class="project-desc">Hardware-based authentication module for secure PC access using fingerprint scanning.</p>
                        <div class="project-tech"><span class="tech-pill">Fingerprint</span><span class="tech-pill">USB</span></div>
                        <div class="project-footer"><a href="#" class="project-link">Details &rarr;</a></div>
                    </div>
                </div>
                <div class="project-card">
                    <div class="project-image-wrap">
                        <span class="project-badge">Agriculture</span>
                        <img src="https://dasenergie.com/wp-content/uploads/2024/07/automatic-solar-powered-irrigation-system.jpg" alt="Solar">
                    </div>
                    <div class="project-content">
                        <h3 class="project-title">Solar Irrigation System</h3>
                        <p class="project-desc">Energy-efficient automated watering system powered by solar panels.</p>
                        <div class="project-tech"><span class="tech-pill">Solar</span><span class="tech-pill">Moisture</span></div>
                        <div class="project-footer"><a href="#" class="project-link">Details &rarr;</a></div>
                    </div>
                </div>
                <div class="project-card">
                    <div class="project-image-wrap">
                        <span class="project-badge">Automotive</span>
                        <img src="https://www.researchgate.net/publication/328920450/figure/fig1/AS:692681546141697@1542159558581/Advanced-driver-assistance-systems-ADAS-for-active-passive-safety-comfort-functionality.ppm" alt="Vehicle Control">
                    </div>
                    <div class="project-content">
                        <h3 class="project-title">Vehicle Control System</h3>
                        <p class="project-desc">Manages vehicle subsystems electronically with CAN bus communication.</p>
                        <div class="project-tech"><span class="tech-pill">CAN Bus</span><span class="tech-pill">ECU</span></div>
                        <div class="project-footer"><a href="#" class="project-link">Details &rarr;</a></div>
                    </div>
                </div>
                <div class="project-card">
                    <div class="project-image-wrap">
                        <span class="project-badge">Automotive</span>
                        <img src="https://www.suzukirndindia.com/assets/styles/blog_details/s3/2025-04/adaptive-cruise-control.jpeg.webp?itok=TKBsH9Cj" alt="Cruise Control">
                    </div>
                    <div class="project-content">
                        <h3 class="project-title">RFID Cruise Control</h3>
                        <p class="project-desc">Controls speed with parental lock features using RFID authentication.</p>
                        <div class="project-tech"><span class="tech-pill">RFID</span><span class="tech-pill">CAN</span></div>
                        <div class="project-footer"><a href="#" class="project-link">Details &rarr;</a></div>
                    </div>
                </div>
                <div class="project-card">
                    <div class="project-image-wrap">
                        <span class="project-badge">Agriculture</span>
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTvdMj0IoKchnIzWSJyUIBy4dk3qwHhU577Dg&s" alt="Greenhouse">
                    </div>
                    <div class="project-content">
                        <h3 class="project-title">Greenhouse Monitoring</h3>
                        <p class="project-desc">Monitors and controls greenhouse conditions remotely via sensors.</p>
                        <div class="project-tech"><span class="tech-pill">WiFi</span><span class="tech-pill">Sensors</span></div>
                        <div class="project-footer"><a href="#" class="project-link">Details &rarr;</a></div>
                    </div>
                </div>
                <div class="project-card">
                    <div class="project-image-wrap">
                        <span class="project-badge">Smart Home</span>
                        <img src="https://invidyo.com/blog/wp-content/uploads/2022/10/colic-new.jpg" alt="Baby Monitor">
                    </div>
                    <div class="project-content">
                        <h3 class="project-title">Baby Cry Detector</h3>
                        <p class="project-desc">Detects baby crying and alerts caregivers via Bluetooth notification.</p>
                        <div class="project-tech"><span class="tech-pill">Audio Sensor</span><span class="tech-pill">Bluetooth</span></div>
                        <div class="project-footer"><a href="#" class="project-link">Details &rarr;</a></div>
                    </div>
                </div>
                <div class="project-card">
                    <div class="project-image-wrap">
                        <span class="project-badge">Consumer</span>
                        <img src="https://media.sciencephoto.com/f0/42/76/08/f0427608-800px-wm.jpg" alt="Remote">
                    </div>
                    <div class="project-content">
                        <h3 class="project-title">TV Remote Controller</h3>
                        <p class="project-desc">Controls TV functions using PIC microcontroller and IR signals.</p>
                        <div class="project-tech"><span class="tech-pill">PIC</span><span class="tech-pill">IR</span></div>
                        <div class="project-footer"><a href="#" class="project-link">Details &rarr;</a></div>
                    </div>
                </div>
                <div class="project-card">
                    <div class="project-image-wrap">
                        <span class="project-badge">Sports</span>
                        <img src="https://repository-images.githubusercontent.com/770019172/2166411b-151b-4a49-bdcd-d252ab3c9023" alt="Speed">
                    </div>
                    <div class="project-content">
                        <h3 class="project-title">Human Speed Detection</h3>
                        <p class="project-desc">Measures speed of human movement using precise IR sensors.</p>
                        <div class="project-tech"><span class="tech-pill">IR</span><span class="tech-pill">Timer</span></div>
                        <div class="project-footer"><a href="#" class="project-link">Details &rarr;</a></div>
                    </div>
                </div>
                <div class="project-card">
                    <div class="project-image-wrap">
                        <span class="project-badge">Agriculture</span>
                        <img src="https://i.ytimg.com/vi/0l414YpfQbM/maxresdefault.jpg" alt="Crop Protection">
                    </div>
                    <div class="project-content">
                        <h3 class="project-title">Crop Protection System</h3>
                        <p class="project-desc">Protects crops from animals using PIR sensors and alarm systems.</p>
                        <div class="project-tech"><span class="tech-pill">PIR</span><span class="tech-pill">Alarm</span></div>
                        <div class="project-footer"><a href="#" class="project-link">Details &rarr;</a></div>
                    </div>
                </div>
                <div class="project-card">
                    <div class="project-image-wrap">
                        <span class="project-badge">Security</span>
                        <img src="https://www.bestonlinetrafficschool.co/wp-content/uploads/2023/04/55-Best-Anti-Theft-Car-Devices-04.png" alt="Theft">
                    </div>
                    <div class="project-content">
                        <h3 class="project-title">Vehicle Theft Alert</h3>
                        <p class="project-desc">Detects theft via vibration sensors and sends GSM alerts.</p>
                        <div class="project-tech"><span class="tech-pill">Vibration</span><span class="tech-pill">GSM</span></div>
                        <div class="project-footer"><a href="#" class="project-link">Details &rarr;</a></div>
                    </div>
                </div>
                <div class="project-card">
                    <div class="project-image-wrap">
                        <span class="project-badge">IoT</span>
                        <img src="https://www.siilc.edu.in/wp-content/uploads/2025/07/modern-smart-farming-agriculture-technology-farm-1.jpg" alt="Smart Farm">
                    </div>
                    <div class="project-content">
                        <h3 class="project-title">Smart Agriculture IoT</h3>
                        <p class="project-desc">Full farming automation with multiple environmental sensors.</p>
                        <div class="project-tech"><span class="tech-pill">IoT</span><span class="tech-pill">Cloud</span></div>
                        <div class="project-footer"><a href="#" class="project-link">Details &rarr;</a></div>
                    </div>
                </div>
                <div class="project-card">
                    <div class="project-image-wrap">
                        <span class="project-badge">Industrial</span>
                        <img src="https://incantodynamics.com/wp-content/uploads/2024/03/What_are_Industrial_Control_Systems__ICS_.jpeg" alt="Industry">
                    </div>
                    <div class="project-content">
                        <h3 class="project-title">Industrial Controller</h3>
                        <p class="project-desc">PLC-based industrial process control and automation system.</p>
                        <div class="project-tech"><span class="tech-pill">PLC</span><span class="tech-pill">SCADA</span></div>
                        <div class="project-footer"><a href="#" class="project-link">Details &rarr;</a></div>
                    </div>
                </div>
            </div>
        </div>

        <div id="raspberry-section" class="project-group" style="margin-top: 60px;">
            <div class="category-header active">
                <h2 class="category-title">Raspberry Pi Projects</h2>
                <p class="category-desc">Advanced computing and IoT solutions powered by Raspberry Pi</p>
            </div>
            <div class="projects-grid">
                <div class="project-card">
                    <div class="project-image-wrap">
                        <span class="project-badge">Environmental</span>
                        <img src="https://www.libelium.com/wp-content/uploads/2018/06/diagrama_argentina_rack21.jpg" alt="Flood">
                    </div>
                    <div class="project-content">
                        <h3 class="project-title">IoT Flood Monitoring</h3>
                        <p class="project-desc">Internet-connected water level monitoring system with dashboard alerts.</p>
                        <div class="project-tech"><span class="tech-pill">IoT</span><span class="tech-pill">Python</span></div>
                        <div class="project-footer"><a href="#" class="project-link">Details &rarr;</a></div>
                    </div>
                </div>
                <div class="project-card">
                    <div class="project-image-wrap">
                        <span class="project-badge">Vision</span>
                        <img src="https://pub.mdpi-res.com/engproc/engproc-32-00012/article_deploy/html/images/engproc-32-00012-g001.png" alt="Color">
                    </div>
                    <div class="project-content">
                        <h3 class="project-title">IoT Color Monitor</h3>
                        <p class="project-desc">Industrial color sorting and identification using computer vision.</p>
                        <div class="project-tech"><span class="tech-pill">OpenCV</span><span class="tech-pill">Camera</span></div>
                        <div class="project-footer"><a href="#" class="project-link">Details &rarr;</a></div>
                    </div>
                </div>
                <div class="project-card">
                    <div class="project-image-wrap">
                        <span class="project-badge">Robotics</span>
                        <img src="https://miro.medium.com/v2/resize:fit:1400/1*Y3pONHyWJF9Xbl_NzuqBTA.png" alt="Tracker">
                    </div>
                    <div class="project-content">
                        <h3 class="project-title">Object Tracker</h3>
                        <p class="project-desc">Automated camera turret that follows moving objects via image processing.</p>
                        <div class="project-tech"><span class="tech-pill">Servos</span><span class="tech-pill">CV</span></div>
                        <div class="project-footer"><a href="#" class="project-link">Details &rarr;</a></div>
                    </div>
                </div>
                <div class="project-card">
                    <div class="project-image-wrap">
                        <span class="project-badge">Smart Home</span>
                        <img src="https://assets.skyfilabs.com/images/blog/gsm_based_home_automation_system_with_iot.webp" alt="Home">
                    </div>
                    <div class="project-content">
                        <h3 class="project-title">IoT Home Automation</h3>
                        <p class="project-desc">Centralized control hub for home appliances with remote web access.</p>
                        <div class="project-tech"><span class="tech-pill">NodeJS</span><span class="tech-pill">Relays</span></div>
                        <div class="project-footer"><a href="#" class="project-link">Details &rarr;</a></div>
                    </div>
                </div>
                <div class="project-card">
                    <div class="project-image-wrap">
                        <span class="project-badge">Security</span>
                        <img src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEiD7y8V_clxWfBWOLp8NIhN7_s1wHFePbdJmwuSOgwzGR_f4ft_na9QPwfjgaufchGjAExgO4ghNjP2ylPswMxaQpuTOP20UY62qgI6-kF8dFaTExum3P6GOU0fDBox4J_FD268UGcYpYyPSSaSafQGqW-Zqikav2F5N8drYKw1uy9ZuRQKNLf3GivFr65p/s1600/Android_Theft%20Protection_Blog%20Header_2096x1182_v3.2%20%281%29.png" alt="Security">
                    </div>
                    <div class="project-content">
                        <h3 class="project-title">Theft Detection System</h3>
                        <p class="project-desc">Detects intrusion using PIR sensors and captures images for evidence.</p>
                        <div class="project-tech"><span class="tech-pill">Camera</span><span class="tech-pill">Email</span></div>
                        <div class="project-footer"><a href="#" class="project-link">Details &rarr;</a></div>
                    </div>
                </div>
                <div class="project-card">
                    <div class="project-image-wrap">
                        <span class="project-badge">Robotics</span>
                        <img src="https://robodk.com/blog/wp-content/uploads/2023/07/iStock-867944730.jpg" alt="Arm">
                    </div>
                    <div class="project-content">
                        <h3 class="project-title">Robotic Arm Control</h3>
                        <p class="project-desc">Precise control of robotic arm movements using Python scripts.</p>
                        <div class="project-tech"><span class="tech-pill">GPIO</span><span class="tech-pill">Servos</span></div>
                        <div class="project-footer"><a href="#" class="project-link">Details &rarr;</a></div>
                    </div>
                </div>
                <div class="project-card">
                    <div class="project-image-wrap">
                        <span class="project-badge">Transport</span>
                        <img src="https://www.shutterstock.com/image-photo/billericay-uk-march-4-2024-260nw-2495378967.jpg" alt="Ticket">
                    </div>
                    <div class="project-content">
                        <h3 class="project-title">Touch Railway Ticketing</h3>
                        <p class="project-desc">Modern ticket booking system with touchscreen interface and database.</p>
                        <div class="project-tech"><span class="tech-pill">Touch</span><span class="tech-pill">SQL</span></div>
                        <div class="project-footer"><a href="#" class="project-link">Details &rarr;</a></div>
                    </div>
                </div>
                <div class="project-card">
                    <div class="project-image-wrap">
                        <span class="project-badge">Energy</span>
                        <img src="https://www.tuvie.com/wp-content/uploads/solar-notebook1.jpg" alt="Solar PC">
                    </div>
                    <div class="project-content">
                        <h3 class="project-title">Solar Powered Computer</h3>
                        <p class="project-desc">Self-sustaining computer system running entirely on solar energy.</p>
                        <div class="project-tech"><span class="tech-pill">Solar</span><span class="tech-pill">Power</span></div>
                        <div class="project-footer"><a href="#" class="project-link">Details &rarr;</a></div>
                    </div>
                </div>
                <div class="project-card">
                    <div class="project-image-wrap">
                        <span class="project-badge">Storage</span>
                        <img src="https://data-carts.com/wp-content/uploads/2022/04/Valuable-Advantages-of-Powered-Medical-Carts.jpg" alt="Data">
                    </div>
                    <div class="project-content">
                        <h3 class="project-title">Portable Data Cart</h3>
                        <p class="project-desc">Mobile data storage and transfer unit with wireless capabilities.</p>
                        <div class="project-tech"><span class="tech-pill">WiFi</span><span class="tech-pill">NAS</span></div>
                        <div class="project-footer"><a href="#" class="project-link">Details &rarr;</a></div>
                    </div>
                </div>
                <div class="project-card">
                    <div class="project-image-wrap">
                        <span class="project-badge">Tools</span>
                        <img src="https://knowhow.distrelec.com/wp-content/uploads/2021/06/GettyImages-185760490.jpg?w=1920&h=1024&crop=1" alt="Scope">
                    </div>
                    <div class="project-content">
                        <h3 class="project-title">Digital Oscilloscope</h3>
                        <p class="project-desc">Signal analysis and visualization tool built on Raspberry Pi.</p>
                        <div class="project-tech"><span class="tech-pill">ADC</span><span class="tech-pill">GUI</span></div>
                        <div class="project-footer"><a href="#" class="project-link">Details &rarr;</a></div>
                    </div>
                </div>
            </div>
        </div>

        <div id="additional-section" class="project-group" style="margin-top: 60px;">
            <div class="category-header active">
                <h2 class="category-title">Additional Projects</h2>
                <p class="category-desc">Innovative solutions across various industrial domains</p>
            </div>
            <div class="projects-grid">
                <div class="project-card">
                    <div class="project-image-wrap">
                        <span class="project-badge">IoT</span>
                        <img src="https://smiledrive.in/cdn/shop/products/3_3c3a03de-0c06-49b9-8218-b1e7a1f58ed9.jpg?v=1642159888&width=1445" alt="Door">
                    </div>
                    <div class="project-content">
                        <h3 class="project-title">Email/SMS Door Notifier</h3>
                        <p class="project-desc">Security system that logs door activity and sends instant alerts.</p>
                        <div class="project-tech"><span class="tech-pill">Sensor</span><span class="tech-pill">API</span></div>
                        <div class="project-footer"><a href="#" class="project-link">Details &rarr;</a></div>
                    </div>
                </div>
                <div class="project-card">
                    <div class="project-image-wrap">
                        <span class="project-badge">Automotive</span>
                        <img src="https://dn1qkewum0hvl.cloudfront.net/blog/wp-content/uploads/2016/10/Solo-PCMS-automotive-computer-modern-dashboard-concept-1024x682.jpg" alt="Car PC">
                    </div>
                    <div class="project-content">
                        <h3 class="project-title">Car Computer</h3>
                        <p class="project-desc">On-board diagnostics display showing real-time vehicle metrics.</p>
                        <div class="project-tech"><span class="tech-pill">OBD-II</span><span class="tech-pill">Display</span></div>
                        <div class="project-footer"><a href="#" class="project-link">Details &rarr;</a></div>
                    </div>
                </div>
                <div class="project-card">
                    <div class="project-image-wrap">
                        <span class="project-badge">Industrial</span>
                        <img src="https://incantodynamics.com/wp-content/uploads/2024/03/What_are_Industrial_Control_Systems__ICS_.jpeg" alt="Industrial">
                    </div>
                    <div class="project-content">
                        <h3 class="project-title">Industrial Automation</h3>
                        <p class="project-desc">PLC and SCADA implementation for factory line control.</p>
                        <div class="project-tech"><span class="tech-pill">PLC</span><span class="tech-pill">SCADA</span></div>
                        <div class="project-footer"><a href="#" class="project-link">Details &rarr;</a></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<script>
    function filterProjects(category, btn) {
        // Update tabs
        document.querySelectorAll('.category-tab').forEach(t => t.classList.remove('active'));
        btn.classList.add('active');

        // Sections
        const embedded = document.getElementById('embedded-section');
        const raspberry = document.getElementById('raspberry-section');
        const additional = document.getElementById('additional-section');

        // Logic
        if (category === 'all') {
            embedded.style.display = 'block';
            raspberry.style.display = 'block';
            additional.style.display = 'block';
        } else if (category === 'embedded') {
            embedded.style.display = 'block';
            raspberry.style.display = 'none';
            additional.style.display = 'none';
        } else if (category === 'raspberry') {
            embedded.style.display = 'none';
            raspberry.style.display = 'block';
            additional.style.display = 'none';
        } else if (category === 'additional') {
            embedded.style.display = 'none';
            raspberry.style.display = 'none';
            additional.style.display = 'block';
        }

        // Animation reset
        document.querySelectorAll('.project-card').forEach(card => {
            card.classList.remove('fade-in');
            void card.offsetWidth; // trigger reflow
            card.classList.add('fade-in');
        });
    }
</script>

<?php include 'includes/footer.php'; ?>