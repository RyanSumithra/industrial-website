<?php 
require_once 'includes/config.php';

$current_page = 'projects';
$page_title = 'Projects & Case Studies | ' . SITE_NAME;
$page_description = 'Explore our portfolio of successful industrial automation projects across various industries.';
$page_keywords = 'automation projects, case studies, portfolio, industrial solutions';

include 'includes/header.php'; 
?>

<style>
    /* Animations */
    @keyframes fadeUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    .animate-up { animation: fadeUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; opacity: 0; }
    
    /* 1. Global & Utilities */
    body { background-color: #050505; color: #fff; }
    .text-accent { color: #ff3333; text-shadow: 0 0 20px rgba(255, 51, 51, 0.4); }
    .text-glow { text-shadow: 0 0 30px rgba(255, 255, 255, 0.1); }

    /* 2. Page Hero */
    .page-hero {
        background: linear-gradient(rgba(0,0,0,0.8), rgba(0,0,0,0.8)),
                    repeating-linear-gradient(45deg, transparent, transparent 10px, rgba(255, 51, 51, 0.05) 10px, rgba(255, 51, 51, 0.05) 11px),
                    linear-gradient(180deg, #050505 0%, #111 100%);
        padding: 120px 0 100px;
        border-bottom: 1px solid #222;
        text-align: center;
        position: relative;
    }
    .hero-badge span {
        background: rgba(255, 51, 51, 0.1); color: var(--primary-red);
        border: 1px solid var(--primary-red); padding: 8px 16px;
        border-radius: 50px; font-size: 0.8rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 1.5px;
    }
    .page-hero h1 { font-size: 3.5rem; font-weight: 900; color: white; margin: 1.5rem 0 1rem; letter-spacing: -1px; }
    .page-hero p { color: #888; font-size: 1.2rem; max-width: 600px; margin: 0 auto; }

    /* Hero Stats (Top) */
    .hero-stats {
        display: flex; justify-content: center; gap: 40px; margin-top: 50px; flex-wrap: wrap;
    }
    .stat-card {
        background: rgba(20, 20, 20, 0.8); border: 1px solid #333; padding: 20px 30px;
        border-radius: 8px; backdrop-filter: blur(5px);
    }
    .stat-number { font-size: 2rem; font-weight: 800; color: white; }
    .stat-label { font-size: 0.8rem; color: #666; text-transform: uppercase; letter-spacing: 1px; }

    /* Waves */
    .hero-waves {
        position: absolute; bottom: 0; left: 0; width: 100%; overflow: hidden; line-height: 0;
        color: #080808; 
    }

    /* 3. Filter Section */
    .filter-section { background: #080808; padding: 40px 0; border-bottom: 1px solid #1a1a1a; top: 0; z-index: 50; }
    .filter-container { display: flex; flex-direction: column; align-items: center; gap: 20px; }
    
    .filter-tags { display: flex; flex-wrap: wrap; justify-content: center; gap: 10px; }
    .filter-tag {
        background: #111; border: 1px solid #333; color: #888;
        padding: 10px 20px; border-radius: 50px; cursor: pointer;
        font-weight: 600; font-size: 0.9rem; transition: 0.3s;
        display: flex; align-items: center; gap: 8px;
    }
    .filter-tag:hover, .filter-tag.active {
        background: rgba(255, 51, 51, 0.1); border-color: var(--primary-red); color: white;
        box-shadow: 0 0 15px rgba(255, 51, 51, 0.2);
    }
    .filter-stats {
    display: flex;
    justify-content: center;
    gap: 50px;
    border-top: 1px solid #222;
    padding-top: 30px;
}

/* Bubble container */
.stat-bubble {
    display: flex;
    align-items: center;
    gap: 15px;
    background: #fff;
    padding: 12px 28px;
    border-radius: 50px;
}

/* PERFECT CIRCLE */
.stat-count {
    width: 36px;
    height: 36px;
    background: #ff3333;
    color: #fff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 1rem;
    line-height: 1; /* IMPORTANT */
    flex-shrink: 0;
}

/* Text */
.stat-bubble span {
    color: #666;
    font-size: 0.9rem;
    white-space: nowrap;
}


    /* 4. Project Grid */
    .projects-showcase { background: #050505; padding: 80px 0; }
    .projects-grid { 
        display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); 
        gap: 30px; margin-top: 40px; 
    }
    
    .project-card {
        background: #111; border: 1px solid #222; border-radius: 12px; overflow: hidden;
        transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1); position: relative;
        display: flex; flex-direction: column;
    }
    .project-card:hover { transform: translateY(-7px); border-color: var(--primary-red); box-shadow: 0 10px 30px rgba(255,51,51,0.15); }
    
    .featured-card { grid-column: span 2; }
    @media(max-width: 900px) { .featured-card { grid-column: span 1; } }

    .project-media { position: relative; height: 240px; overflow: hidden; }
    .featured-card .project-media { height: 350px; }
    
    .project-image {
        width: 100%; height: 100%; 
        background-size: cover; background-position: center;
        transition: 0.5s;
    }
    .project-card:hover .project-image { transform: scale(1.05); }
    
    .image-overlay {
        position: absolute; bottom: 0; left: 0; width: 100%; padding: 20px;
        background: linear-gradient(to top, rgba(0,0,0,0.9), transparent);
        display: flex; align-items: end; justify-content: space-between;
    }
    
    .industry-icon { font-size: 1.5rem; background: rgba(255,255,255,0.1); width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 50%; backdrop-filter: blur(5px); }
    .project-duration { color: #ccc; font-size: 0.8rem; font-weight: 600; background: rgba(0,0,0,0.6); padding: 4px 10px; border-radius: 4px; }

    .project-content { padding: 25px; flex-grow: 1; display: flex; flex-direction: column; }
    .project-meta { display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px; }
    .project-category { color: var(--primary-red); font-weight: 700; }
    .project-client { color: #666; }

    .project-title { color: white; font-size: 1.4rem; margin-bottom: 10px; line-height: 1.3; }
    .project-description { color: #888; font-size: 0.95rem; line-height: 1.6; margin-bottom: 20px; }

    .project-tech-stack { display: flex; gap: 8px; flex-wrap: wrap; margin-top: auto; }
    .tech-badge { background: #1a1a1a; color: #ccc; border: 1px solid #333; padding: 4px 10px; font-size: 0.75rem; border-radius: 4px; }

    .project-footer { 
        margin-top: 20px; padding-top: 20px; border-top: 1px solid #222; 
        display: flex; justify-content: space-between; align-items: center; 
    }
    .project-link { color: white; text-decoration: none; font-weight: 600; display: flex; align-items: center; gap: 5px; transition: 0.3s; font-size: 0.9rem; }
    .project-link:hover { color: var(--primary-red); gap: 10px; }

    /* 5. Stats Showcase (FIXED LAYOUT) */
    .stats-showcase { 
        background: #080808; 
        padding: 80px 0; 
        border-top: 1px solid #1a1a1a; 
        border-bottom: 1px solid #1a1a1a; 
        overflow: hidden;
    }
    .stats-grid { 
        display: flex; 
        flex-wrap: wrap; 
        justify-content: center; 
        gap: 30px; 
    }
    .stat-card-large { 
        flex: 1 1 250px; 
        max-width: 350px;
        text-align: center; 
        background: rgba(255, 255, 255, 0.03); 
        border: 1px solid #222;
        padding: 40px 20px;
        border-radius: 16px;
        transition: all 0.3s ease;
    }
    .stat-card-large:hover {
        transform: translateY(-10px);
        border-color: #ff3333;
        background: rgba(255, 51, 51, 0.05);
        box-shadow: 0 10px 40px rgba(0,0,0,0.5);
    }
    .stat-icon { 
        font-size: 3rem; 
        margin-bottom: 20px; 
        filter: grayscale(100%); 
        transition: 0.3s; 
        display: inline-block;
    }
    .stat-card-large:hover .stat-icon { filter: grayscale(0); transform: scale(1.2); }
    .stat-card-large .stat-number { font-size: 3.5rem; font-weight: 900; color: #ff3333; line-height: 1; margin-bottom: 10px; }
    .stat-card-large .stat-label { color: #fff; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; font-size: 0.9rem; margin-bottom: 10px; display: block; }
    .stat-trend { color: #666; font-size: 0.8rem; display: inline-flex; align-items: center; gap: 6px; background: rgba(0,0,0,0.3); padding: 4px 12px; border-radius: 20px; }

    /* 6. Industry Grid */
    .industries-section { background: #050505; padding: 100px 0; }
    .industries-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 25px; }
    .industry-card { background: #111; padding: 30px; border-radius: 12px; border: 1px solid #222; transition: 0.3s; text-align: center; }
    .industry-card:hover { border-color: #ff3333; transform: translateY(-5px); background: #161616; }
    .industry-content h3 { color: white; margin: 15px 0 10px; }
    .industry-content p { color: #777; font-size: 0.9rem; margin-bottom: 15px; }
    .project-count { background: rgba(255, 51, 51, 0.1); color: #ff3333; display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 700; }

    /* 7. Process Timeline */
    .process-section { background: #080808; padding: 100px 0; border-top: 1px solid #222; }
    .process-timeline { max-width: 800px; margin: 50px auto 0; position: relative; }
    .process-timeline::before { content: ''; position: absolute; left: 29px; top: 0; height: 100%; width: 2px; background: #222; }
    
    .process-step { display: flex; gap: 40px; margin-bottom: 50px; position: relative; }
    .step-number { 
        width: 60px; height: 60px; background: #050505; border: 2px solid #ff3333; border-radius: 50%; 
        display: flex; align-items: center; justify-content: center; font-size: 1.2rem; font-weight: 800; color: #ff3333; 
        z-index: 2; flex-shrink: 0; box-shadow: 0 0 20px rgba(255,51,51,0.2);
    }
    .step-content { background: #111; padding: 30px; border-radius: 8px; border: 1px solid #222; flex-grow: 1; transition: 0.3s; }
    .step-content:hover { border-color: #ff3333; transform: translateX(10px); }
    .step-content h3 { color: white; margin-bottom: 10px; }
    .step-features li { color: #888; margin-bottom: 5px; font-size: 0.9rem; list-style: none; position: relative; padding-left: 15px; }
    .step-features li::before { content: '•'; color: #ff3333; position: absolute; left: 0; }

    /* 8. CTA */
    .cta-section { background: linear-gradient(135deg, #cc0000, #990000); padding: 100px 0; text-align: center; }
    .cta-content h2 { color: white; font-size: 3rem; font-weight: 900; margin-bottom: 1rem; }
    .cta-content p { color: rgba(255,255,255,0.9); font-size: 1.2rem; margin-bottom: 40px; }
    
    /* Buttons */
    .btn { display: inline-flex; align-items: center; gap: 10px; padding: 12px 28px; border-radius: 6px; font-weight: 700; text-decoration: none; transition: 0.3s; cursor: pointer; }
    .btn-primary { background: #ff3333; color: white; border: none; }
    .btn-primary:hover { background: #e60000; box-shadow: 0 0 20px rgba(255, 51, 51, 0.4); }
    .btn-secondary { background: transparent; border: 1px solid rgba(255,255,255,0.5); color: white; }
    .btn-secondary:hover { background: white; color: #cc0000; }
    .btn-white { background: white; color: #cc0000; border: none; }
    .btn-white:hover { background: #eee; }
</style>

<section class="page-hero projects-hero">
    <div class="container">
        <div class="page-hero-content animated-content">
            <div class="hero-badge pulse-animation">
                <span>🏆 Award-Winning Projects</span>
            </div>
            <h1 class="text-glow">Our <span class="text-accent">Projects</span></h1>
            <p class="hero-subtitle">Real-world automation solutions delivering measurable results.</p>
            <div class="hero-stats">
                <div class="stat-card">
                    <div class="stat-number">200+</div>
                    <div class="stat-label">Projects Completed</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">98%</div>
                    <div class="stat-label">Client Satisfaction</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">15</div>
                    <div class="stat-label">Industries Served</div>
                </div>
            </div>
        </div>
    </div>
    <div class="hero-waves">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".1" fill="currentColor"></path>
            <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".2" fill="currentColor"></path>
            <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" opacity=".8" fill="#080808"></path>
        </svg>
    </div>
</section>

<section class="section filter-section">
    <div class="container">
        <div class="filter-container">
            <div class="filter-tags">
                <button class="filter-tag active" onclick="filterProjects('all', this)">
                    <span class="filter-icon">⭐</span> All Projects
                </button>
                <button class="filter-tag" onclick="filterProjects('manufacturing', this)">
                    <span class="filter-icon">🏭</span> Manufacturing
                </button>
                <button class="filter-tag" onclick="filterProjects('energy', this)">
                    <span class="filter-icon">⚡</span> Energy
                </button>
                <button class="filter-tag" onclick="filterProjects('iot', this)">
                    <span class="filter-icon">🌐</span> IoT
                </button>
                <button class="filter-tag" onclick="filterProjects('food', this)">
                    <span class="filter-icon">🥤</span> Food & Bev
                </button>
                <button class="filter-tag" onclick="filterProjects('automotive', this)">
                    <span class="filter-icon">🚗</span> Automotive
                </button>
            </div>
            
            <div class="filter-stats">
                <div class="stat-bubble">
                    <div class="stat-count">6</div>
                    <span>Featured Projects</span>
                </div>
            
                <div class="stat-bubble">
                    <div class="stat-count">15+</div>
                    <span>Years Experience</span>
                </div>
            </div>

        </div>
    </div>
</section>

<section class="section projects-showcase">
    <div class="container">
        <div class="showcase-header" style="text-align:center; margin-bottom:50px;">
            <div class="section-label" style="color:#ff3333; font-weight:700; text-transform:uppercase;">Featured Work</div>
            <h2 class="section-title" style="font-size:2.5rem; color:white;">Success <span class="text-accent">Stories</span></h2>
            <p class="section-subtitle" style="color:#888;">Discover how we've transformed manufacturing processes.</p>
        </div>

        <div class="projects-grid">
            <div class="project-card featured-card" data-category="manufacturing">
                <div class="project-media">
                    <div class="project-image" style="background: linear-gradient(135deg, #990000, #ff3333);">
                        <div class="image-overlay">
                            <div class="industry-icon">🏭</div>
                            <div class="project-duration">12 Weeks • Large Scale</div>
                        </div>
                    </div>
                </div>
                <div class="project-content">
                    <div class="project-meta">
                        <span class="project-category">Manufacturing</span>
                        <span class="project-client">AutoParts Inc.</span>
                    </div>
                    <h3 class="project-title">Automotive Assembly Line</h3>
                    <p class="project-description">Complete PLC-based automation system for high-speed component assembly, achieving unprecedented efficiency.</p>
                    
                    <div class="project-results-grid">
                        <div class="result-metric">
                            <div class="metric-value">35%</div>
                            <div class="metric-label">Efficiency</div>
                        </div>
                        <div class="result-metric">
                            <div class="metric-value">50%</div>
                            <div class="metric-label">Defects ↓</div>
                        </div>
                        <div class="result-metric">
                            <div class="metric-value">99.9%</div>
                            <div class="metric-label">Uptime</div>
                        </div>
                    </div>
                    
                    <div class="project-cta" style="margin-top:20px; display:flex; justify-content:space-between; align-items:center;">
                        <a href="#" class="btn btn-primary" style="padding: 10px 20px; font-size:0.9rem;">
                            View Case Study
                        </a>
                        <div class="project-tech-stack">
                            <span class="tech-badge">Siemens S7</span>
                            <span class="tech-badge">SCADA</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="project-card" data-category="energy">
                <div class="project-media">
                    <div class="project-image" style="background: linear-gradient(135deg, #cc0000, #ff6600);">
                        <div class="image-overlay">
                            <div class="industry-icon">⚡</div>
                            <div class="project-duration">10MW System</div>
                        </div>
                    </div>
                </div>
                <div class="project-content">
                    <div class="project-meta">
                        <span class="project-category">Energy</span>
                        <span class="project-client">PowerGrid</span>
                    </div>
                    <h3 class="project-title">Smart Power Distribution</h3>
                    <p class="project-description">Advanced control panel design for industrial power distribution.</p>
                    
                    <div class="project-highlights">
                        <div class="highlight"><span class="highlight-icon">✅</span> 99.9% uptime</div>
                        <div class="highlight"><span class="highlight-icon">✅</span> 15% savings</div>
                    </div>
                    
                    <div class="project-footer">
                        <span class="tech-badge">Allen-Bradley</span>
                        <a href="#" class="project-link">Details &rarr;</a>
                    </div>
                </div>
            </div>

            <div class="project-card" data-category="iot">
                <div class="project-media">
                    <div class="project-image" style="background: linear-gradient(135deg, #111, #333);">
                        <div class="image-overlay">
                            <div class="industry-icon">🌐</div>
                            <div class="project-duration">500+ Sensors</div>
                        </div>
                    </div>
                </div>
                <div class="project-content">
                    <div class="project-meta">
                        <span class="project-category">IoT Solutions</span>
                        <span class="project-client">Precision Mfg</span>
                    </div>
                    <h3 class="project-title">Smart Factory Platform</h3>
                    <p class="project-description">Real-time monitoring and predictive maintenance for manufacturing.</p>
                    
                    <div class="project-highlights">
                        <div class="highlight"><span class="highlight-icon">✅</span> 40% downtime ↓</div>
                        <div class="highlight"><span class="highlight-icon">✅</span> Cloud Analytics</div>
                    </div>
                    
                    <div class="project-footer">
                        <span class="tech-badge">AWS IoT</span>
                        <a href="#" class="project-link">Details &rarr;</a>
                    </div>
                </div>
            </div>

            <div class="project-card" data-category="food">
                <div class="project-media">
                    <div class="project-image" style="background: linear-gradient(135deg, #660000, #330000);">
                        <div class="image-overlay">
                            <div class="industry-icon">🥤</div>
                            <div class="project-duration">15K bottles/hr</div>
                        </div>
                    </div>
                </div>
                <div class="project-content">
                    <div class="project-meta">
                        <span class="project-category">Food & Bev</span>
                        <span class="project-client">BevCorp</span>
                    </div>
                    <h3 class="project-title">Bottling Line Automation</h3>
                    <p class="project-description">High-speed bottling with precise control and vision quality assurance.</p>
                    
                    <div class="project-highlights">
                        <div class="highlight"><span class="highlight-icon">✅</span> 20% throughput ↑</div>
                        <div class="highlight"><span class="highlight-icon">✅</span> 99.5% Quality</div>
                    </div>
                    
                    <div class="project-footer">
                        <span class="tech-badge">Mitsubishi</span>
                        <a href="#" class="project-link">Details &rarr;</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="projects-footer" style="text-align:center; margin-top:60px;">
            <a href="contact.php" class="btn btn-primary btn-large">
                Start Your Project ➜
            </a>
        </div>
    </div>
</section>

<section class="section stats-showcase">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-card-large">
                <div class="stat-icon">📈</div>
                <div class="stat-content">
                    <div class="stat-number">35%</div>
                    <div class="stat-label">Efficiency Gain</div>
                    <div class="stat-trend">↑ Average Result</div>
                </div>
            </div>
            <div class="stat-card-large">
                <div class="stat-icon">⏱️</div>
                <div class="stat-content">
                    <div class="stat-number">99.8%</div>
                    <div class="stat-label">System Uptime</div>
                    <div class="stat-trend">★ Reliability</div>
                </div>
            </div>
            <div class="stat-card-large">
                <div class="stat-icon">🎯</div>
                <div class="stat-content">
                    <div class="stat-number">50%</div>
                    <div class="stat-label">Defect Reduction</div>
                    <div class="stat-trend">↓ Quality Control</div>
                </div>
            </div>
            <div class="stat-card-large">
                <div class="stat-icon">💯</div>
                <div class="stat-content">
                    <div class="stat-number">100%</div>
                    <div class="stat-label">Satisfaction</div>
                    <div class="stat-trend">♥ Client Retention</div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section industries-section">
    <div class="container">
        <div class="section-header" style="text-align:center; margin-bottom:50px;">
            <div class="section-label" style="color:#ff3333; font-weight:700;">Our Expertise</div>
            <h2 class="section-title" style="font-size:2.5rem; color:white;">Industries We <span class="text-accent">Serve</span></h2>
        </div>
        
        <div class="industries-grid">
            <div class="industry-card">
                <div class="industry-icon">🏭</div>
                <div class="industry-content">
                    <h3>Manufacturing</h3>
                    <p>Assembly lines, robotics, quality control.</p>
                    <div class="project-count">45 projects</div>
                </div>
            </div>
            <div class="industry-card">
                <div class="industry-icon">⚡</div>
                <div class="industry-content">
                    <h3>Energy</h3>
                    <p>Power distribution, renewable energy.</p>
                    <div class="project-count">28 projects</div>
                </div>
            </div>
            <div class="industry-card">
                <div class="industry-icon">🥤</div>
                <div class="industry-content">
                    <h3>Food & Bev</h3>
                    <p>Processing, packaging, sanitation.</p>
                    <div class="project-count">32 projects</div>
                </div>
            </div>
            <div class="industry-card">
                <div class="industry-icon">🚗</div>
                <div class="industry-content">
                    <h3>Automotive</h3>
                    <p>Assembly automation, supply chain.</p>
                    <div class="project-count">39 projects</div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section process-section">
    <div class="container">
        <div class="section-header" style="text-align:center; margin-bottom:60px;">
            <div class="section-label" style="color:#ff3333;">Our Process</div>
            <h2 class="section-title" style="font-size:2.5rem; color:white;">How We <span class="text-accent">Deliver</span></h2>
        </div>
        
        <div class="process-timeline">
            <div class="process-step">
                <div class="step-number">01</div>
                <div class="step-content">
                    <h3>Discovery & Analysis</h3>
                    <p>Comprehensive assessment of requirements and goals.</p>
                    <ul class="step-features">
                        <li>Needs analysis</li>
                        <li>Feasibility study</li>
                    </ul>
                </div>
                <div class="step-icon" style="color:white; font-size:2rem; margin-left:auto;">🔍</div>
            </div>
            
            <div class="process-step">
                <div class="step-number">02</div>
                <div class="step-content">
                    <h3>Design & Planning</h3>
                    <p>System architecture and component selection.</p>
                    <ul class="step-features">
                        <li>System architecture</li>
                        <li>Timeline planning</li>
                    </ul>
                </div>
                <div class="step-icon" style="color:white; font-size:2rem; margin-left:auto;">📐</div>
            </div>
            
            <div class="process-step">
                <div class="step-number">03</div>
                <div class="step-content">
                    <h3>Implementation</h3>
                    <p>Installation, software development, and integration.</p>
                    <ul class="step-features">
                        <li>Hardware setup</li>
                        <li>Software dev</li>
                    </ul>
                </div>
                <div class="step-icon" style="color:white; font-size:2rem; margin-left:auto;">⚙️</div>
            </div>
            
            <div class="process-step">
                <div class="step-number">04</div>
                <div class="step-content">
                    <h3>Support</h3>
                    <p>Testing, training, and ongoing maintenance.</p>
                    <ul class="step-features">
                        <li>System testing</li>
                        <li>24/7 Support</li>
                    </ul>
                </div>
                <div class="step-icon" style="color:white; font-size:2rem; margin-left:auto;">🛠️</div>
            </div>
        </div>
    </div>
</section>

<section class="section cta-section project-cta">
    <div class="container">
        <div class="cta-content">
            <div class="cta-badge" style="background:rgba(255,255,255,0.1); display:inline-block; padding:5px 15px; border-radius:50px; margin-bottom:15px;">
                <span>Ready to Transform?</span>
            </div>
            <h2>Start Your <span class="text-accent">Automation</span> Journey</h2>
            <div class="cta-buttons" style="margin-top:30px; display:flex; justify-content:center; gap:20px;">
                <a href="contact.php" class="btn btn-white">Discuss Project</a>
                <a href="services.php" class="btn btn-secondary">View Services</a>
            </div>
        </div>
    </div>
</section>

<script>
    function filterProjects(category, btn) {
        // Update Buttons
        document.querySelectorAll('.filter-tag').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        // Filter Cards
        const cards = document.querySelectorAll('.project-card');
        cards.forEach(card => {
            const projectCat = card.getAttribute('data-category');
            if (category === 'all' || projectCat === category) {
                card.style.display = 'flex';
                card.style.opacity = '0';
                setTimeout(() => card.style.opacity = '1', 100);
            } else {
                card.style.display = 'none';
            }
        });
    }
</script>

<?php include 'includes/footer.php'; ?>