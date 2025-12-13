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
    <title>Command Center - IndustrialTech</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        :root { --primary-red: #ff3333; --bg-black: #050505; --card-bg: #111; --border: #2a2a2a; color: white; }
        body { background: var(--bg-black); font-family: 'Inter', sans-serif; margin: 0; padding: 20px; }
        
        .nav { display: flex; justify-content: space-between; padding-bottom: 20px; border-bottom: 1px solid var(--border); margin-bottom: 40px; }
        .brand { font-weight: 800; font-size: 1.5rem; }
        
        .grid-menu { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; max-width: 1000px; margin: 0 auto; }
        
        .menu-card {
            background: var(--card-bg); border: 1px solid var(--border); padding: 40px; border-radius: 12px;
            text-align: center; transition: 0.3s; cursor: pointer; text-decoration: none; color: white;
            display: block; position: relative; overflow: hidden;
        }
        .menu-card:hover { transform: translateY(-5px); border-color: var(--primary-red); background: #161616; }
        
        .icon { font-size: 4rem; margin-bottom: 20px; display: block; }
        .title { font-size: 1.5rem; font-weight: 700; margin-bottom: 10px; display: block; }
        .desc { color: #888; font-size: 0.9rem; }
    </style>
</head>
<body>

    <div class="nav">
        <div class="brand">INDUSTRIAL<span style="color:var(--primary-red)">TECH</span></div>
        <a href="logout.php" style="color:#888; text-decoration:none;">Sign Out</a>
    </div>

    <div style="text-align:center; margin-bottom:50px;">
        <h1 style="font-size: 3rem; margin-bottom: 10px;">Mission Control</h1>
        <p style="color:#666;">Select a system to manage</p>
    </div>

    <div class="grid-menu">
        <a href="products.php" class="menu-card">
            <span class="icon">📦</span>
            <span class="title">Product Management</span>
            <span class="desc">Add new inventory, upload specs, and manage catalog.</span>
        </a>

        <a href="blogs.php" class="menu-card">
            <span class="icon">📰</span>
            <span class="title">Intelligence Hub</span>
            <span class="desc">Write articles, publish news, and manage content.</span>
        </a>
    </div>

</body>
</html>