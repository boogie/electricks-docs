<?php
if (!defined('BASE_PATH')) {
    require_once __DIR__ . '/../config.php';
}

$pageTitle = isset($pageTitle) ? $pageTitle . ' - ' . SITE_TITLE : SITE_TITLE;
$currentPage = isset($currentPage) ? $currentPage : 'home';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>

    <!-- Primary Meta Tags -->
    <meta name="description" content="Find help, guides, and documentation for all Electricks magic devices">
    <meta name="author" content="Electricks">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?php echo htmlspecialchars($pageTitle); ?>">
    <meta property="og:description" content="Electricks Help Center - Support for magic devices">

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/images/favicon-32x32.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/images/favicon-180x180.png">

    <!-- Font Preloading -->
    <link rel="preload" href="/assets/fonts/SF-Pro-Display-Regular.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="/assets/fonts/SF-Pro-Display-Semibold.woff2" as="font" type="font/woff2" crossorigin>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="/assets/css/style.css?v=<?php echo ASSET_VERSION; ?>">
    <link rel="stylesheet" href="/assets/css/help-theme-v2.css?v=<?php echo ASSET_VERSION; ?>">

    <!-- Syntax Highlighting with Highlight.js - Base16 Ashes Theme -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/base16/ashes.min.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web@2.0.3"></script>

    <!-- Simple CSS gradient icons - no JS needed -->
</head>
<body class="<?php echo $currentPage; ?>-page">
    <header class="site-header">
        <div class="header-inner">
            <a href="/" class="logo">
                <img src="/assets/images/electricks-logo.png" alt="Electricks" class="logo-image">
                <span class="logo-text">Help Center</span>
            </a>

            <nav class="main-nav">
                <a href="/" class="nav-link <?php echo $currentPage === 'home' ? 'active' : ''; ?>">
                    Home
                </a>
                <a href="/docs/getting-started/index" class="nav-link">
                    Getting Started
                </a>
                <div class="nav-dropdown">
                    <button class="nav-link nav-dropdown-trigger">
                        Products
                        <i class="ph ph-caret-down"></i>
                    </button>
                    <div class="nav-dropdown-menu">
                        <div class="nav-dropdown-grid">
                            <a href="/docs/devices/remote-control/atom-2" class="nav-dropdown-item">
                                <div class="nav-dropdown-icon">
                                    <img src="https://electricks.info/wp-content/uploads/2023/01/atom2-300x300.png" alt="Atom 2">
                                </div>
                                <span class="nav-dropdown-name">Atom 2</span>
                            </a>
                            <a href="/docs/devices/peeking/peeksmith-3" class="nav-dropdown-item">
                                <div class="nav-dropdown-icon">
                                    <img src="https://electricks.info/wp-content/uploads/2021/10/ps3_featured-300x300.png" alt="PeekSmith 3">
                                </div>
                                <span class="nav-dropdown-name">PeekSmith 3</span>
                            </a>
                            <a href="/docs/devices/remote-control/bond" class="nav-dropdown-item">
                                <div class="nav-dropdown-icon">
                                    <img src="https://electricks.info/wp-content/uploads/2024/10/bond-anim-300x300.gif" alt="Bond">
                                </div>
                                <span class="nav-dropdown-name">Bond</span>
                            </a>
                            <a href="/docs/devices/wearables/sb-watch-2" class="nav-dropdown-item">
                                <div class="nav-dropdown-icon">
                                    <img src="https://electricks.info/wp-content/uploads/2024/02/sbw2_-300x300.png" alt="SB Watch 2">
                                </div>
                                <span class="nav-dropdown-name">SB Watch 2</span>
                            </a>
                            <a href="/docs/devices/calculators/quantum-calculator" class="nav-dropdown-item">
                                <div class="nav-dropdown-icon">
                                    <img src="https://electricks.info/wp-content/uploads/2025/02/67EB80C5-BE05-4826-8FE7-BACB1838B4BC-300x300.png" alt="Quantum Calculator">
                                </div>
                                <span class="nav-dropdown-name">Quantum</span>
                            </a>
                            <a href="/docs/devices/remote-control/teleport" class="nav-dropdown-item">
                                <div class="nav-dropdown-icon">
                                    <img src="https://electricks.info/wp-content/uploads/2025/01/teleport-QD-300x300.png" alt="Teleport">
                                </div>
                                <span class="nav-dropdown-name">Teleport</span>
                            </a>
                        </div>
                    </div>
                </div>
                <a href="/docs/guides/troubleshooting-common-issues" class="nav-link">
                    Guides
                </a>
            </nav>

            <div class="header-actions">
                <a href="https://electricks.info" class="header-btn">
                    <i class="ph ph-storefront" style="font-size: 18px; margin-right: 4px;"></i>
                    Shop
                </a>
                <a href="/docs/support/contact" class="header-btn header-btn-primary">
                    Contact Support
                </a>
            </div>
        </div>
    </header>

    <main class="site-main">
