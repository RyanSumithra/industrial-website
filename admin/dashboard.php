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
        :root { 
            --red: #ff3333; 
            --red-dim: rgba(255, 51, 51, 0.1);
            --bg: #020202; 
            --panel: #0a0a0a; 
            --border: #222; 
            --text: #e0e0e0;
            --mono: 'JetBrains Mono', monospace;
            --sans: 'Inter', sans-serif;
        }
        
        body { 
            background: var(--bg); 
            color: var(--text);
            font-family: var(--sans); 
            margin: 0; 
            padding: 0; 
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        /* --- CRT/NOISE EFFECT --- */
        .scanline {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(to bottom, rgba(255,255,255,0), rgba(255,255,255,0) 50%, rgba(0,0,0,0.1) 50%, rgba(0,0,0,0.1));
            background-size: 100% 4px;
            pointer-events: none; z-index: 9999; opacity: 0.3;
        }
        .noise {
            position: fixed; inset: 0; pointer-events: none; z-index: 9998; opacity: 0.04;
            background: url('https://grainy-gradients.vercel.app/noise.svg');
        }

        /* --- HEADER --- */
        .hud-header {
            display: flex; justify-content: space-between; align-items: center;
            padding: 20px 40px; border-bottom: 1px solid var(--border);
            background: var(--bg); position: relative; z-index: 10;
        }
        .brand-mark {
            font-family: var(--mono); font-weight: 700; font-size: 1.1rem; letter-spacing: -1px;
            display: flex; align-items: center; gap: 10px;
        }
        .status-dot { width: 8px; height: 8px; background: var(--red); border-radius: 50%; box-shadow: 0 0 10px var(--red); animation: pulse 2s infinite; }
        
        .hud-meta {
            font-family: var(--mono); font-size: 0.75rem; color: #666;
            display: flex; gap: 30px;
        }
        .hud-item span { color: var(--red); margin-right: 5px; }

        /* --- MAIN AREA --- */
        .command-center {
            padding: 60px 40px;
            max-width: 1600px; width: 100%; margin: 0 auto; box-sizing: border-box;
            flex-grow: 1;
        }

        .page-title-area { margin-bottom: 50px; border-left: 2px solid var(--red); padding-left: 30px; }
        .hero-label { font-family: var(--mono); color: var(--red); font-size: 0.85rem; letter-spacing: 2px; margin-bottom: 10px; display: block; }
        .hero-text { font-size: 3.5rem; font-weight: 800; line-height: 0.9; text-transform: uppercase; margin: 0; color: white; letter-spacing: -2px; }

        /* --- UNEVEN BENTO GRID --- */
        .modules-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-template-rows: 250px 250px; /* Two explicit rows */
            gap: 20px;
        }
        /* Tablet: 2 cols */
        @media(max-width: 1100px) { 
            .modules-grid { grid-template-columns: 1fr 1fr; grid-template-rows: auto; } 
        }
        /* Mobile: 1 col */
        @media(max-width: 768px) { 
            .modules-grid { grid-template-columns: 1fr; } 
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
        }
        .module-card:hover {
            border-color: var(--red);
            background: #0f0f0f;
            transform: translateY(-5px);
            box-shadow: 0 20px 50px rgba(0,0,0,0.5);
        }

        /* TALL CARDS (Span 2 Rows) */
        .card-tall { grid-row: span 2; }
        
        /* Reset span on smaller screens */
        @media(max-width: 1100px) { .card-tall { grid-row: span 1; min-height: 350px; } }

        /* Icon Styling */
        .mod-icon {
            font-size: 3rem; margin-bottom: 20px; color: #333; transition: 0.3s;
            width: 80px; height: 80px; border: 1px solid var(--border);
            display: flex; align-items: center; justify-content: center;
        }
        .module-card:hover .mod-icon { color: white; border-color: var(--red); background: var(--red-dim); }

        .mod-title { font-size: 1.8rem; font-weight: 700; color: white; margin-bottom: 10px; display: block; }
        .mod-desc { color: #888; font-size: 0.95rem; line-height: 1.5; max-width: 90%; }
        
        .mod-action {
            margin-top: 30px;
            font-family: var(--mono); font-size: 0.8rem; color: var(--red);
            text-transform: uppercase; letter-spacing: 1px;
            display: flex; align-items: center; gap: 10px;
        }
        .mod-action::after { content: '→'; transition: 0.3s; }
        .module-card:hover .mod-action::after { transform: translateX(5px); }

        /* SYSTEM STATUS CARD (Small) */
        .status-card {
            background: #050505;
            padding: 30px;
            border: 1px solid var(--border);
            display: flex; flex-direction: column; justify-content: center;
        }
        .stat-val { font-family: var(--mono); font-size: 2rem; color: white; margin-bottom: 5px; }
        .stat-lbl { font-size: 0.75rem; text-transform: uppercase; color: #666; letter-spacing: 1px; }
        .live-indicator { color: var(--red); font-weight: 700; display:flex; align-items:center; gap:8px; font-size:0.8rem; margin-bottom:10px; }
        .live-indicator::before { content:''; display:block; width:6px; height:6px; background:var(--red); border-radius:50%; box-shadow:0 0 8px var(--red); }

        /* --- FOOTER --- */
        .console-footer {
            border-top: 1px solid var(--border);
            padding: 20px 40px;
            font-family: var(--mono);
            font-size: 0.75rem;
            color: #444;
            display: flex; justify-content: space-between;
        }

        @keyframes pulse { 0% { opacity: 0.5; box-shadow: 0 0 0 var(--red); } 50% { opacity: 1; box-shadow: 0 0 10px var(--red); } 100% { opacity: 0.5; box-shadow: 0 0 0 var(--red); } }
    </style>
</head>
<body>

    <div class="scanline"></div>
    <div class="noise"></div>

    <div class="dashboard-layout">
        
        <header class="hud-header">
            <div class="brand-mark">
                <div class="status-dot"></div>
                ASIA<span style="color:white">TECH</span> / OVERWATCH
            </div>
            <div class="hud-meta">
                <div class="hud-item"><span>ID:</span> ADMIN_01</div>
                <div class="hud-item" style="display:none; @media(min-width:768px){display:block;}"><span>NET:</span> SECURE</div>
                <a href="logout.php" style="color:var(--red); text-decoration:none; margin-left:20px; font-weight:700;">[ TERMINATE ]</a>
            </div>
        </header>

        <main class="command-center">
            
            <div class="page-title-area">
                <span class="hero-label">// CONTROL INTERFACE</span>
                <h1 class="hero-text">System <br><span style="color: #333;">Operations</span></h1>
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
                    <span class="stat-val"><?php echo date("H:i"); ?> <span style="font-size:1rem; color:#666;">UTC</span></span>
                    <span class="stat-lbl">Server Time Sync</span>
                    <div style="margin-top:15px; border-top:1px solid #222; padding-top:15px;">
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

</body>
</html>