<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LogoIpsum - Invoice Factoring</title>
    
    <!-- CSS Files -->
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="stylesheet" href="/assets/css/navbar.css">
    <link rel="stylesheet" href="/assets/css/hero.css">
    <link rel="stylesheet" href="/assets/css/features.css">
    <link rel="stylesheet" href="/assets/css/task-manager.css">
    <link rel="stylesheet" href="/assets/css/contact.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container">
            <div class="logo">
                <img src="/assets/images/logo.svg" alt="LogoIpsum" class="logo-img">
            </div>

            <!-- Desktop Navigation -->
            <div class="desktop-nav">
                <a href="#" class="nav-link">Products</a>
                <a href="#" class="nav-link">Solutions</a>
                <a href="#" class="nav-link">Use cases</a>
                <a href="#" class="nav-link">Get started</a>
                <a href="#" class="nav-link">Login</a>
                <a href="#" class="nav-btn">Request Access</a>
            </div>
            
            <!-- Hamburger Button -->
            <button class="hamburger" aria-label="Menu" aria-expanded="false">
                <div class="hamburger-box">
                    <div class="hamburger-inner"></div>
                </div>
            </button>

            <!-- Mobile Menu -->
            <div class="nav-backdrop"></div>
            <div class="mobile-menu">
                <!-- Mobile menu content -->
                <?php include 'mobile-menu.php'; ?>
            </div>
        </div>
    </nav>