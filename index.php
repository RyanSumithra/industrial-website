<?php 
require_once 'includes/config.php';

$current_page = 'home';
$page_title = SITE_NAME . ' | Industrial Intelligence';
include 'includes/header.php'; 
?>

<style>
    :root {
        --primary: #ff3333;
        --primary-dim: #cc0000;
        --bg: #030303;
        --surface: #0a0a0a;
        --border: #222;
        --text: #ffffff;
        --text-muted: #888;
    }

    /* --- RESET & BASE --- */
    body {
        background-color: var(--bg);
        color: var(--text);
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
        overflow-x: hidden; /* Critical for mobile to prevent side-scroll */
        margin: 0;
    }

    /* Cinematic Noise Texture */
    .noise-overlay {
        position: fixed; inset: 0; pointer-events: none; z-index: 9000;
        opacity: 0.04;
        background: url('https://grainy-gradients.vercel.app/noise.svg');
    }

    /* --- TYPOGRAPHY --- */
    .display-1 { 
        font-size: clamp(2.5rem, 8vw, 6.5rem); 
        font-weight: 800; 
        line-height: 0.95; 
        letter-spacing: -0.03em; 
        margin-bottom: 2rem;
        text-transform: uppercase;
        color: white;
    }

    .outline-text {
        -webkit-text-stroke: 1px rgba(255,255,255,0.3);
        color: transparent;
        transition: 0.3s;
    }
    .hero-wrap:hover .outline-text {
        -webkit-text-stroke: 1px var(--primary);
        opacity: 0.8;
    }
    
    .display-2 { 
        font-size: clamp(1.8rem, 6vw, 3.5rem); 
        font-weight: 700; 
        line-height: 1.1; 
        letter-spacing: -1px; 
        text-transform: uppercase;
    }
    
    .label-mono { 
        color: var(--primary); 
        font-family: 'Courier New', monospace; 
        font-weight: 700; 
        letter-spacing: 2px; 
        font-size: 0.8rem; 
        display: block; 
        margin-bottom: 1.5rem;
    }

    .lead-text { 
        font-size: clamp(1rem, 2vw, 1.25rem); 
        color: var(--text-muted); 
        line-height: 1.6; 
        max-width: 650px; 
        font-weight: 400;
        margin-bottom: 40px;
    }

    /* --- ANIMATIONS --- */
    .reveal { opacity: 0; transform: translateY(40px); transition: all 1s cubic-bezier(0.16, 1, 0.3, 1); }
    .reveal.active { opacity: 1; transform: translateY(0); }
    
    /* --- HERO SECTION --- */
    .hero-wrap {
        min-height: 100vh;
        position: relative;
        display: flex;
        align-items: center;
        overflow: hidden;
        border-bottom: 1px solid var(--border);
        padding: 100px 5%;
    }
    .hero-bg {
        position: absolute; inset: 0;
        background: url('https://images.unsplash.com/photo-1550751827-4bd374c3f58b?q=80&w=2070&auto=format&fit=crop') no-repeat center center/cover;
        filter: grayscale(100%) brightness(0.3) contrast(1.2);
        transform: scale(1.1);
        z-index: 0;
    }
    .hero-overlay {
        position: absolute; inset: 0;
        background: radial-gradient(circle at 70% 30%, rgba(20,20,20,0) 0%, var(--bg) 90%);
        z-index: 1;
    }
    .hero-content {
        position: relative; z-index: 10;
        max-width: 1400px; margin: 0 auto; width: 100%;
    }

    /* --- BUTTONS --- */
    .btn-wrap {
        display: flex; gap: 20px; align-items: center; flex-wrap: wrap;
    }
    
    .btn-main {
        padding: 20px 50px;
        background: white;
        color: black;
        font-weight: 800;
        text-transform: uppercase;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        border: none;
        transition: 0.3s;
        font-size: 0.9rem;
        letter-spacing: 1px;
        white-space: nowrap;
    }
    .btn-main:hover { background: var(--primary); color: white; gap: 20px; box-shadow: 0 0 30px rgba(255, 51, 51, 0.3); }
    
    .btn-link {
        color: white; text-decoration: none; font-weight: 600; 
        text-transform: uppercase; letter-spacing: 1px; font-size: 0.9rem;
        border: 1px solid rgba(255,255,255,0.2); padding: 19px 40px;
        transition: 0.3s;
        white-space: nowrap;
    }
    .btn-link:hover { border-color: white; background: rgba(255,255,255,0.05); }

    /* Mobile Buttons */
    @media (max-width: 600px) {
        .btn-wrap { flex-direction: column; align-items: stretch; gap: 15px; }
        .btn-main, .btn-link { justify-content: center; width: 100%; box-sizing: border-box; }
    }

    /* --- MARQUEE --- */
    .marquee-wrap { border-bottom: 1px solid var(--border); padding: 25px 0; background: #000; overflow: hidden; }
    .marquee-track { display: flex; gap: 60px; animation: scroll 30s linear infinite; }
    .marquee-item { color: #222; font-weight: 900; font-size: 3rem; text-transform: uppercase; white-space: nowrap; -webkit-text-stroke: 1px #333; }
    .marquee-item.highlight { color: var(--primary); -webkit-text-stroke: 0; opacity: 0.8; }
    @keyframes scroll { 0% { transform: translateX(0); } 100% { transform: translateX(-100%); } }

    /* --- BENTO GRID SERVICES --- */
    .bento-section { padding: 120px 5%; max-width: 1600px; margin: 0 auto; }
    .bento-grid {
        display: grid; 
        grid-template-columns: repeat(3, 1fr); 
        grid-template-rows: repeat(2, 400px);
        gap: 20px;
    }
    
    .bento-card {
        background: var(--surface);
        border: 1px solid var(--border);
        padding: 40px;
        position: relative;
        overflow: hidden;
        display: flex; flex-direction: column; justify-content: flex-end;
        transition: 0.4s;
    }
    .bento-card:hover { border-color: var(--primary); transform: translateY(-5px); }
    
    .bento-bg {
        position: absolute; inset: 0;
        background-size: cover; background-position: center;
        transition: transform 0.6s ease;
        z-index: 1;
        filter: grayscale(100%) brightness(0.5);
    }
    .bento-card:hover .bento-bg { transform: scale(1.1); filter: grayscale(0%) brightness(0.7); }
    
    .bento-overlay {
        position: absolute; inset: 0;
        background: linear-gradient(0deg, rgba(0,0,0,0.9) 20%, rgba(0,0,0,0.4) 100%);
        z-index: 2;
    }
    
    .bento-content { position: relative; z-index: 3; }
    .bento-large { grid-column: span 2; }
    
    .bento-num { position: absolute; top: 30px; right: 30px; font-family: monospace; color: white; opacity: 0.5; font-size: 1.5rem; font-weight: 700; z-index: 4; }
    .bento-card:hover .bento-num { opacity: 1; color: var(--primary); }
    .bento-title { font-size: 2rem; font-weight: 700; margin-bottom: 10px; color: white; }
    .bento-desc { color: #ccc; line-height: 1.6; max-width: 95%; font-size: 1rem; margin-bottom: 10px; }
    .bento-link { color: var(--primary); text-transform: uppercase; font-weight: 700; font-size: 0.85rem; letter-spacing: 1px; display: inline-block; margin-top: 10px; }

    /* Responsive Bento */
    @media (max-width: 1024px) { 
        .bento-grid { grid-template-columns: 1fr 1fr; grid-template-rows: auto; } 
    }
    @media (max-width: 768px) { 
        .bento-section { padding: 80px 5%; }
        .bento-grid { grid-template-columns: 1fr; } 
        .bento-large { grid-column: span 1; }
        .bento-card { min-height: 350px; } /* Ensure height on mobile */
    }

    /* --- PROJECTS --- */
    .projects-wrap { padding: 0; border-top: 1px solid var(--border); }
    .project-item {
        display: grid; grid-template-columns: 1fr 1fr;
        min-height: 700px;
        border-bottom: 1px solid var(--border);
    }
    
    .project-info {
        padding: 100px 10%;
        display: flex; flex-direction: column; justify-content: center;
        background: var(--bg);
    }
    .project-img-wrap {
        position: relative; overflow: hidden; height: 100%; min-height: 400px; border-left: 1px solid var(--border);
    }
    .project-img {
        width: 100%; height: 115%; 
        background-size: cover; background-position: center;
        transition: transform 0.1s linear;
        filter: grayscale(100%);
    }
    .project-item:hover .project-img { filter: grayscale(0%); transition: filter 0.5s; }

    .project-stat-row { display: flex; gap: 60px; margin-top: 50px; padding-top: 30px; border-top: 1px solid var(--border); }
    .project-stat-val { font-size: 3rem; font-weight: 800; color: white; display: block; line-height: 1; }
    .project-stat-key { font-size: 0.85rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; font-weight: 700; margin-top: 10px; display: block; }

    /* Responsive Projects */
    @media (max-width: 900px) { 
        .project-item { grid-template-columns: 1fr; min-height: auto; } 
        .project-img-wrap { order: -1; height: 350px; min-height: 350px; border-left: none; border-bottom: 1px solid var(--border); }
        .project-info { padding: 60px 5%; }
        .project-img { height: 100%; transform: none !important; } /* Simplify parallax on mobile */
    }

    /* --- STATS MATRIX --- */
    .stats-matrix {
        display: grid; 
        grid-template-columns: repeat(4, 1fr);
        border-top: 1px solid var(--border);
        border-bottom: 1px solid var(--border);
        background: #080808;
    }
    
    .stat-cell {
        padding: 80px 40px;
        border-right: 1px solid var(--border);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
        transition: 0.3s;
    }
    .stat-cell:last-child { border-right: none; }
    .stat-cell:hover { background: #0f0f0f; }
    
    .stat-cell::after {
        content: ''; position: absolute; bottom: 0; left: 0; width: 100%; height: 2px;
        background: var(--primary); transform: scaleX(0); transition: 0.4s;
    }
    .stat-cell:hover::after { transform: scaleX(1); }

    .stat-big { font-size: 5rem; font-weight: 900; color: white; line-height: 1; font-variant-numeric: tabular-nums; }
    .stat-suffix { color: var(--primary); font-size: 3rem; vertical-align: super; font-weight: 700; }
    .stat-label { margin-top: 15px; font-family: 'Courier New', monospace; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 2px; color: var(--text-muted); }

    /* Responsive Stats */
    @media (max-width: 1024px) { 
        .stat-big { font-size: 3.5rem; }
        .stat-suffix { font-size: 2rem; }
    }
    @media (max-width: 900px) { 
        .stats-matrix { grid-template-columns: 1fr 1fr; } 
        .stat-cell:nth-child(2) { border-right: none; }
        .stat-cell:nth-child(1), .stat-cell:nth-child(2) { border-bottom: 1px solid var(--border); }
    }
    @media (max-width: 600px) {
        .stats-matrix { grid-template-columns: 1fr; }
        .stat-cell { border-right: none !important; border-bottom: 1px solid var(--border); padding: 50px 20px; }
        .stat-cell:last-child { border-bottom: none; }
    }

    /* --- CTA --- */
    .cta-area { padding: 180px 5%; text-align: center; border-bottom: 1px solid var(--border); background: #020202; }
    @media (max-width: 768px) { .cta-area { padding: 100px 5%; } }
    
    /* ================== OUR CLIENTS (MERGED) ================== */

    .clients-section {
        background: #0b0b0b;
        padding: 100px 0 80px;
        overflow: hidden;
        border-top: 1px solid var(--border);
    }
    
    .clients-heading {
        text-align: center;
        margin-bottom: 60px;
    }
    
    .clients-heading h2 {
        font-size: clamp(2.5rem, 6vw, 4rem);
        font-weight: 800;
        color: #fff;
    }
    
    .clients-heading span {
        color: var(--primary);
    }
    
    /* Slider */
    .clients-slider {
        width: 100%;
        overflow: hidden;
    }
    
    .clients-track {
        display: flex;
        gap: 40px;
        width: max-content;
        animation: clientsScroll 35s linear infinite;
    }
    
    .clients-track:hover {
        animation-play-state: paused;
    }
    
    .client-card {
        background: #cb312f;
        width: 380px;
        min-height: 420px;
        padding: 30px;
        border-radius: 10px;
        text-align: center;
        flex-shrink: 0;
    }
    
    .client-card p {
        color: #fff;
        font-size: 14.5px;
        line-height: 1.6;
        margin-bottom: 20px;
    }
    
    .client-logo {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: contain;
        background: #fff;
        padding: 10px;
        margin-bottom: 12px;
    }
    
    .client-card h4 {
        color: #fff;
        font-size: 16px;
        margin: 0;
    }
    
    @keyframes clientsScroll {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }


</style>

<div class="noise-overlay"></div>

<section class="hero-wrap">
    <div class="hero-bg" id="heroBg"></div>
    <div class="hero-overlay"></div>
    
    <div class="hero-content">
        <div class="reveal">
            <span class="label-mono">// SYSTEM INTEGRATORS</span>
            
            <h1 class="display-1">
                INDUSTRIAL AUTOMATION<br>
                <span style="color: #444;">&</span> MECHATRONICS<br>
                <span class="outline-text">SOLUTIONS</span>
            </h1>
            
            <p class="lead-text">
                Powering the future of manufacturing with cutting-edge PLC systems, robotics, and custom IoT integration.
            </p>
            
            <div class="btn-wrap">
                <a href="projects.php" class="btn-main">View Implementations</a>
                <a href="contact.php" class="btn-link">Contact Engineering</a>
            </div>
        </div>
    </div>
</section>

<div class="marquee-wrap">
    <div class="marquee-track">
        <span class="marquee-item">Automation</span>
        <span class="marquee-item highlight">Siemens</span>
        <span class="marquee-item">Robotics</span>
        <span class="marquee-item highlight">Allen-Bradley</span>
        <span class="marquee-item">SCADA</span>
        <span class="marquee-item highlight">IoT</span>
        <span class="marquee-item">Automation</span>
        <span class="marquee-item highlight">Siemens</span>
        <span class="marquee-item">Robotics</span>
        <span class="marquee-item highlight">Allen-Bradley</span>
        <span class="marquee-item">SCADA</span>
        <span class="marquee-item highlight">IoT</span>
    </div>
</div>

<section class="bento-section">
    <div class="reveal" style="margin-bottom: 80px;">
        <span class="label-mono">/// CORE COMPETENCIES</span>
        <h2 class="display-2">Engineered for<br>Absolute Performance.</h2>
    </div>

    <div class="bento-grid reveal">
        <div class="bento-card bento-large">
            <div class="bento-bg" style="background-image: url('https://images.unsplash.com/photo-1518770660439-4636190af475?q=80&w=2070&auto=format&fit=crop');"></div>
            <div class="bento-overlay"></div>
            <span class="bento-num">01</span>
            
            <div class="bento-content">
                <h3 class="bento-title">PLC & Process Logic</h3>
                <p class="bento-desc">
                    Robust logic for Siemens S7 and Allen-Bradley ControlLogix. Code optimized for sub-millisecond execution cycles.
                </p>
                <a href="services.php#plc" class="bento-link">Explore Architecture &rarr;</a>
            </div>
        </div>

        <div class="bento-card">
            <div class="bento-bg" style="background-image: url('https://images.unsplash.com/photo-1558346490-a72e53ae2d4f?q=80&w=2070&auto=format&fit=crop');"></div>
            <div class="bento-overlay"></div>
            <span class="bento-num">02</span>
            
            <div class="bento-content">
                <h3 class="bento-title">Control Panels</h3>
                <p class="bento-desc">UL/CE certified fabrication. High-density MCC & PCC panels.</p>
                <a href="services.php#panels" class="bento-link">View Specs &rarr;</a>
            </div>
        </div>

        <div class="bento-card">
            <div class="bento-bg" style="background-image: url('https://images.unsplash.com/photo-1551288049-bebda4e38f71?q=80&w=2070&auto=format&fit=crop');"></div>
            <div class="bento-overlay"></div>
            <span class="bento-num">03</span>
            
            <div class="bento-content">
                <h3 class="bento-title">Industrial IoT</h3>
                <p class="bento-desc">Real-time telemetry & predictive maintenance dashboards.</p>
                <a href="services.php#iot" class="bento-link">View Dashboards &rarr;</a>
            </div>
        </div>

        <div class="bento-card bento-large">
            <div class="bento-bg" style="background-image: url('https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?q=80&w=2070&auto=format&fit=crop');"></div>
            <div class="bento-overlay"></div>
            <span class="bento-num">04</span>
            
            <div class="bento-content">
                <h3 class="bento-title">Robotic Integration</h3>
                <p class="bento-desc">
                    End-of-arm tooling and 6-axis calibration for Fanuc and Kuka systems. We bridge the gap between mechanical hardware and intelligent software.
                </p>
                <a href="services.php#robotics" class="bento-link">Explore Capabilities &rarr;</a>
            </div>
        </div>
    </div>
</section>

<section class="projects-wrap">
    <div class="project-item">
        <div class="project-info reveal">
            <span class="label-mono">CASE STUDY: AUTOMOTIVE</span>
            <h2 class="display-2" style="margin-bottom: 20px;">Assembly Line<br>Optimization</h2>
            <p class="lead-text">
                Complete retrofit of a Tier-1 chassis assembly line. We replaced legacy relay logic with a distributed I/O network.
            </p>
            
            <div class="project-stat-row">
                <div>
                    <span class="project-stat-val">40%</span>
                    <span class="project-stat-key">Efficiency Gain</span>
                </div>
                <div>
                    <span class="project-stat-val">12</span>
                    <span class="project-stat-key">Week Timeline</span>
                </div>
            </div>
            <br>
            <a href="projects.php" class="btn-link" style="width: fit-content; border-color: #333; padding: 15px 30px;">Read Case Study &rarr;</a>
        </div>
        <div class="project-img-wrap">
            <div class="project-img" style="background-image: url('https://images.unsplash.com/photo-1621905252507-b35492cc74b4?q=80&w=2069&auto=format&fit=crop');"></div>
        </div>
    </div>

    <div class="project-item">
        <div class="project-img-wrap" style="order: -1;">
            <div class="project-img" style="background-image: url('https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?q=80&w=2070&auto=format&fit=crop');"></div>
        </div>
        <div class="project-info reveal">
            <span class="label-mono">CASE STUDY: UTILITIES</span>
            <h2 class="display-2" style="margin-bottom: 20px;">Smart Grid<br>Distribution</h2>
            <p class="lead-text">
                Implementing SIL-3 safety protocols for a regional power station. Redundant PLCs ensure 99.999% uptime.
            </p>
            <div class="project-stat-row">
                <div>
                    <span class="project-stat-val">SIL-3</span>
                    <span class="project-stat-key">Safety Rating</span>
                </div>
                <div>
                    <span class="project-stat-val">99.9%</span>
                    <span class="project-stat-key">Uptime</span>
                </div>
            </div>
            <br>
            <a href="projects.php" class="btn-link" style="width: fit-content; border-color: #333; padding: 15px 30px;">Read Case Study &rarr;</a>
        </div>
    </div>
</section>

<section class="stats-matrix reveal">
    <div class="stat-cell">
        <div>
            <span class="stat-big count-up" data-target="15">0</span><span class="stat-suffix">+</span>
        </div>
        <span class="stat-label">Years R&D</span>
    </div>
    
    <div class="stat-cell">
        <div>
            <span class="stat-big count-up" data-target="200">0</span><span class="stat-suffix">+</span>
        </div>
        <span class="stat-label">Deployments</span>
    </div>
    
    <div class="stat-cell">
        <div>
            <span class="stat-big count-up" data-target="99">0</span><span class="stat-suffix">%</span>
        </div>
        <span class="stat-label">System Uptime</span>
    </div>
    
    <div class="stat-cell">
        <div>
            <span class="stat-big">24</span><span class="stat-suffix">/7</span>
        </div>
        <span class="stat-label">Critical Support</span>
    </div>
</section>

<section class="clients-section reveal">
    <div class="clients-heading">
        <h2>Our <span>Clients</span></h2>
    </div>

    <div class="clients-slider">
        <div class="clients-track">

            <div class="client-card">
                <p>
                    “We developed an automated manual control system using Allen-Bradley PLCs for pipe bending machines,
                    improving precision and reliability for suppliers to ISRO, SpaceX, DRDO, and major automobile manufacturers.”
                </p>
                <img src="images/autoforms.png" class="client-logo">
                <h4>Autoforms</h4>
            </div>

            <div class="client-card">
                <p>
                    “PLC-based retrofitting of a steel bottle base welding machine improved control accuracy and extended
                    the life of legacy equipment for India’s first steel bottle manufacturer.”
                </p>
                <img src="images/riya.png" class="client-logo">
                <h4>Riya Industries</h4>
            </div>

            <div class="client-card">
                <p>
                    “A TechAsia digital timer with buzzer ensured precise monitoring of electrode powder mixing cycles,
                    improving consistency for a leading welding rod manufacturer.”
                </p>
                <img src="images/orange.png" class="client-logo">
                <h4>Orange Electrodes</h4>
            </div>

            <div class="client-card">
                <p>
                    “Water valve angle indicators and power factor correction panels improved efficiency and corrosion
                    protection in municipal water supply pumping stations.”
                </p>
                <img src="images/mcgm.png" class="client-logo">
                <h4>MCGM</h4>
            </div>

            <div class="client-card">
                <p>
                    “Controller and filter-life indicators enhanced monitoring and air quality control in hospital
                    operation-theatre laminar air-flow systems.”
                </p>
                <img src="images/WIESPL.png" class="client-logo">
                <h4>WIESPL</h4>
            </div>

            <div class="client-card">
                <p>
                    “PLC-based automation of hydraulic pipe-bending machines enabled high-volume production for an
                    Indo-American manufacturing venture.”
                </p>
                <img src="images/comfort.png" class="client-logo">
                <h4>Comfort Products</h4>
            </div>

            <div class="client-card">
                <p>
                    “Customized DVCB and Comby Controllers improved HVAC efficiency for a patented, innovation-driven
                    engineering company.”
                </p>
                <img src="images/panasia.png" class="client-logo">
                <h4>Panasia Engineers Pvt. Ltd.</h4>
            </div>

        </div>
    </div>
</section>


<section class="cta-area">
    <div class="reveal">
        <h2 class="display-2" style="margin-bottom: 30px;">Ready to Scale?</h2>
        <p class="lead-text" style="margin: 0 auto 50px auto;">
            Stop dealing with downtime. Let's engineer a solution that works as hard as you do.
        </p>
        <a href="contact.php" class="btn-main">
            Initiate Consultation
        </a>
    </div>
</section>

<script>
    // 1. SCROLL REVEAL OBSERVER
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if(entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));

    // 2. PARALLAX EFFECTS
    // Only run on non-mobile for performance
    if (window.innerWidth > 900) {
        window.addEventListener('scroll', () => {
            const scrolled = window.scrollY;
            
            // Hero Background
            const heroBg = document.getElementById('heroBg');
            if(heroBg) heroBg.style.transform = `translateY(${scrolled * 0.5}px) scale(1.1)`;

            // Project Images
            document.querySelectorAll('.project-img').forEach(img => {
                const speed = 0.1;
                const rect = img.parentElement.getBoundingClientRect();
                if (rect.top < window.innerHeight && rect.bottom > 0) {
                    const yPos = (window.innerHeight - rect.top) * speed;
                    img.style.transform = `translateY(${yPos - 50}px)`;
                }
            });
        });
    }

    // 3. NUMBER COUNTERS (ANIMATED)
    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if(entry.isIntersecting) {
                const target = +entry.target.getAttribute('data-target');
                const duration = 2000; // 2 seconds animation
                const fps = 60;
                const interval = 1000 / fps;
                const steps = duration / interval;
                const increment = target / steps;
                
                let current = 0;
                let counterElement = entry.target;
                
                const timer = setInterval(() => {
                    current += increment;
                    if(current >= target) {
                        current = target;
                        clearInterval(timer);
                    }
                    counterElement.innerText = Math.floor(current);
                }, interval);
                
                counterObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    document.querySelectorAll('.count-up').forEach(el => counterObserver.observe(el));
</script>

<?php include 'includes/footer.php'; ?>