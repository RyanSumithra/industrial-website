<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
include '../includes/db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>OVERWATCH | IndustrialTech Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* --- THEME VARIABLES --- */
        :root {
            --red: #ff3333;
            --red-dim: rgba(255, 51, 51, 0.1);
            
            /* Dark Mode (Default) */
            --bg: #020202;
            --panel: #0a0a0a;
            --border: #222;
            --text: #e0e0e0;
            --text-muted: #666;
            --scanline-opacity: 0.3;
        }

        /* Light Mode Override */
        body.light-mode {
            --bg: #f4f6f9;
            --panel: #ffffff;
            --border: #e0e0e0;
            --text: #111111;
            --text-muted: #666666;
            --scanline-opacity: 0.05;
        }
        
        body { 
            background: var(--bg); 
            color: var(--text);
            font-family: 'Inter', sans-serif; 
            margin: 0; padding: 0; 
            min-height: 100vh;
            display: flex; flex-direction: column;
            overflow-x: hidden;
            transition: background 0.3s ease, color 0.3s ease;
        }

        /* --- EFFECTS --- */
        .scanline {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(to bottom, rgba(255,255,255,0), rgba(255,255,255,0) 50%, rgba(0,0,0,0.1) 50%, rgba(0,0,0,0.1));
            background-size: 100% 4px;
            pointer-events: none; z-index: 9999; opacity: var(--scanline-opacity);
        }
        
        /* Toggle Button */
        .theme-toggle {
            position: fixed; bottom: 20px; right: 20px; z-index: 10000;
            background: var(--panel); border: 1px solid var(--border);
            color: var(--text); width: 50px; height: 50px;
            border-radius: 50%; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem; box-shadow: 0 4px 10px rgba(0,0,0,0.2);
            transition: 0.3s;
        }
        .theme-toggle:hover { border-color: var(--red); color: var(--red); }

        /* --- HEADER --- */
        .hud-header {
            display: flex; justify-content: space-between; align-items: center;
            padding: 20px 40px; border-bottom: 1px solid var(--border);
            background: var(--bg); position: relative; z-index: 10;
        }
        .brand-mark {
            font-family: 'JetBrains Mono', monospace; font-weight: 700; font-size: 1.1rem; letter-spacing: -1px;
            display: flex; align-items: center; gap: 10px; color: var(--text);
        }
        .status-dot { width: 8px; height: 8px; background: var(--red); border-radius: 50%; box-shadow: 0 0 10px var(--red); animation: pulse 2s infinite; }
        
        .hud-meta {
            font-family: 'JetBrains Mono', monospace; font-size: 0.75rem; color: var(--text-muted);
            display: flex; gap: 20px; align-items: center;
        }
        .hud-item span { color: var(--red); margin-right: 5px; }
        
        /* Mobile Header Adjustments */
        @media (max-width: 768px) {
            .hud-header { padding: 15px 20px; flex-direction: column; gap: 15px; align-items: flex-start; }
            .hud-meta { width: 100%; justify-content: space-between; }
        }

        /* --- MAIN AREA --- */
        .command-center {
            padding: 60px 40px;
            max-width: 1600px; width: 100%; margin: 0 auto; box-sizing: border-box;
            flex-grow: 1;
        }
        @media (max-width: 768px) { .command-center { padding: 40px 20px; } }

        .page-title-area { margin-bottom: 50px; border-left: 2px solid var(--red); padding-left: 30px; }
        .hero-label { font-family: 'JetBrains Mono', monospace; color: var(--red); font-size: 0.85rem; letter-spacing: 2px; margin-bottom: 10px; display: block; }
        .hero-text { 
            font-size: clamp(2.5rem, 5vw, 3.5rem); 
            font-weight: 800; line-height: 0.9; text-transform: uppercase; margin: 0; color: var(--text); letter-spacing: -2px; 
        }

        /* --- GRID SYSTEM --- */
        .modules-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-template-rows: 250px 250px; /* Explicit height for layout stability */
            gap: 20px;
        }
        /* Tablet: 2 cols */
        @media(max-width: 1100px) { 
            .modules-grid { grid-template-columns: 1fr 1fr; grid-template-rows: auto; } 
        }
        /* Mobile: 1 col */
        @media(max-width: 768px) { 
            .modules-grid { grid-template-columns: 1fr; grid-template-rows: auto; } 
        }

        .module-card {
            background: var(--panel);
            border: 1px solid var(--border);
            padding: 40px;
            display: flex; flex-direction: column; justify-content: space-between;
            position: relative;
            text-decoration: none;
            transition: 0.3s cubic-bezier(0.2, 0.8, 0.2, 1);
            overflow: hidden;
            min-height: 250px; /* Ensure height on mobile */
        }
        .module-card:hover {
            border-color: var(--red);
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        body.light-mode .module-card:hover { background: #fff; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }

        /* TALL CARDS (Span 2 Rows) */
        .card-tall { grid-row: span 2; }
        /* Reset span on smaller screens */
        @media(max-width: 1100px) { .card-tall { grid-row: span 1; min-height: 350px; } }

        /* Icon Styling */
        .mod-icon {
            font-size: 3rem; margin-bottom: 20px; color: var(--text); transition: 0.3s;
            width: 80px; height: 80px; border: 1px solid var(--border);
            display: flex; align-items: center; justify-content: center;
            border-radius: 8px;
        }
        .module-card:hover .mod-icon { color: var(--red); border-color: var(--red); background: var(--red-dim); }

        .mod-title { font-size: 1.8rem; font-weight: 700; color: var(--text); margin-bottom: 10px; display: block; }
        .mod-desc { color: var(--text-muted); font-size: 0.95rem; line-height: 1.5; max-width: 90%; }
        
        .mod-action {
            margin-top: 30px;
            font-family: 'JetBrains Mono', monospace; font-size: 0.8rem; color: var(--red);
            text-transform: uppercase; letter-spacing: 1px;
            display: flex; align-items: center; gap: 10px;
        }
        .mod-action::after { content: '→'; transition: 0.3s; }
        .module-card:hover .mod-action::after { transform: translateX(5px); }

        /* SYSTEM STATUS CARD (Small) */
        .status-card {
            background: var(--panel);
            padding: 30px;
            border: 1px solid var(--border);
            display: flex; flex-direction: column; justify-content: center;
            min-height: 200px;
        }
        .stat-val { font-family: 'JetBrains Mono', monospace; font-size: 2rem; color: var(--text); margin-bottom: 5px; }
        .stat-lbl { font-size: 0.75rem; text-transform: uppercase; color: var(--text-muted); letter-spacing: 1px; }
        .live-indicator { color: var(--red); font-weight: 700; display:flex; align-items:center; gap:8px; font-size:0.8rem; margin-bottom:10px; }
        .live-indicator::before { content:''; display:block; width:6px; height:6px; background:var(--red); border-radius:50%; box-shadow:0 0 8px var(--red); }

        /* --- FOOTER --- */
        .console-footer {
            border-top: 1px solid var(--border);
            padding: 20px 40px;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.75rem;
            color: var(--text-muted);
            display: flex; justify-content: space-between;
            background: var(--bg);
        }

        @keyframes pulse { 0% { opacity: 0.5; box-shadow: 0 0 0 var(--red); } 50% { opacity: 1; box-shadow: 0 0 10px var(--red); } 100% { opacity: 0.5; box-shadow: 0 0 0 var(--red); } }
    </style>
</head>
<body>

    <div class="scanline"></div>
    
    <button class="theme-toggle" onclick="toggleTheme()" title="Switch Theme">
        <span id="theme-icon">☀</span>
    </button>

    <div class="dashboard-layout">
        
        <header class="hud-header">
            <div class="brand-mark">
                <div class="status-dot"></div>
                ASIA<span style="color:var(--text-muted)">TECH</span> / OVERWATCH
            </div>
            <div class="hud-meta">
                <div class="hud-item"><span>ID:</span> ADMIN_01</div>
                <div class="hud-item" style="display:none; @media(min-width:768px){display:block;}"><span>NET:</span> SECURE</div>
                <a href="logout.php" style="color:var(--red); text-decoration:none; margin-left:auto; font-weight:700;">[ TERMINATE ]</a>
            </div>
        </header>

        <main class="command-center">
            
            <div class="page-title-area">
                <span class="hero-label">// CONTROL INTERFACE</span>
                <h1 class="hero-text">System <br><span style="color: var(--text-muted);">Operations</span></h1>
            </div>

            <div class="modules-grid">
                
                <a href="products.php" class="module-card card-tall">
                    <div>
                        <div class="mod-icon">📦</div>
                        <span class="mod-title">Inventory Control</span>
                        <p class="mod-desc">
                            Initialize product deployment. Manage technical specifications, imagery, and database entries for the global catalog.
                        </p>
                    </div>
                    <div class="mod-action">Access Database</div>
                </a>

                <a href="blogs.php" class="module-card card-tall">
                    <div>
                        <div class="mod-icon">📡</div>
                        <span class="mod-title">Blog Feed</span>
                        <p class="mod-desc">
                            Broadcast Blogs to the public network. Write articles, manage press releases, and control the narrative.
                        </p>
                    </div>
                    <div class="mod-action">Manage Transmission</div>
                </a>

                <a href="inquiries.php" class="module-card">
                    <div>
                        <div style="display:flex; justify-content:space-between; align-items:start;">
                            <span class="mod-title" style="font-size:1.5rem;">Inquiry Logs</span>
                            <div class="mod-icon" style="width:50px; height:50px; font-size:1.5rem; margin:0;">📨</div>
                        </div>
                        <p class="mod-desc" style="margin-top:15px; font-size:0.85rem;">
                            Intercept incoming transmissions and client requests.
                        </p>
                    </div>
                    <div class="mod-action" style="margin-top:20px;">Open Comms</div>
                </a>

                <div class="status-card">
                    <div class="live-indicator">LIVE TELEMETRY</div>
                    <span class="stat-val"><?php echo date("H:i"); ?> <span style="font-size:1rem; color:var(--text-muted);">UTC</span></span>
                    <span class="stat-lbl">Server Time Sync</span>
                    <div style="margin-top:15px; border-top:1px solid var(--border); padding-top:15px;">
                        <span class="stat-lbl" style="color:var(--red);">DB CONNECTION: ACTIVE</span>
                    </div>
                </div>

            </div>

        </main>

        <footer class="console-footer">
            <div>INDUSTRIAL_OS v2.5 // READY</div>
            <div style="opacity: 0.5;">COPYRIGHT © <?php echo date("Y"); ?></div>
        </footer>

    </div>

    <script>
        // Check local storage for theme
        const currentTheme = localStorage.getItem('theme');
        const icon = document.getElementById('theme-icon');
        
        if (currentTheme === 'light') {
            document.body.classList.add('light-mode');
            icon.innerText = '🌙';
        } else {
            icon.innerText = '☀';
        }

        function toggleTheme() {
            document.body.classList.toggle('light-mode');
            const isLight = document.body.classList.contains('light-mode');
            localStorage.setItem('theme', isLight ? 'light' : 'dark');
            icon.innerText = isLight ? '🌙' : '☀';
        }
    </script>

</body>
</html>