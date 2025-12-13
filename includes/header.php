<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo $page_description ?? 'Industrial automation, PLC systems, control panels, and custom electronics solutions for modern manufacturing.'; ?>">
    <meta name="keywords" content="<?php echo $page_keywords ?? 'industrial automation, PLC, control panels, mechatronics, IoT, manufacturing, Industry 4.0, robotics, SCADA, HMI'; ?>">
    <meta name="author" content="IndustrialTech">
    <meta name="robots" content="index, follow">
    <meta property="og:title" content="<?php echo $page_title ?? 'IndustrialTech - Industrial Automation Solutions'; ?>">
    <meta property="og:description" content="<?php echo $page_description ?? 'Leading industrial automation solutions provider.'; ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo BASE_URL . basename($_SERVER['PHP_SELF']); ?>">
    <meta property="og:image" content="<?php echo BASE_URL; ?>assets/og-image.jpg">
    
    <title><?php echo $page_title ?? 'IndustrialTech - Industrial Automation Solutions'; ?></title>
    
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="assets/favicon/site.webmanifest">
    
    <!-- Preconnect for fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Montserrat:wght@700;800;900&display=swap" rel="stylesheet">
    
    <!-- Stylesheet -->
    <link rel="stylesheet" href="css/styles.css">
    
    <!-- Critical CSS -->
    <style>
        /* Critical CSS for initial load */
        .navbar { opacity: 0; animation: fadeIn 0.5s ease forwards; }
        .hero-content { opacity: 0; transform: translateY(20px); animation: slideUp 0.8s ease 0.3s forwards; }
        @keyframes fadeIn { to { opacity: 1; } }
        @keyframes slideUp { to { opacity: 1; transform: translateY(0); } }
        
        /* Prevent FOUC */
        .js-loading * { animation-play-state: paused !important; }
    </style>
</head>
<body class="antialiased js-loading">