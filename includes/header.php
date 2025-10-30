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
                <a href="/docs/getting-started" class="nav-link">
                    Getting Started
                </a>
                <div class="nav-dropdown">
                    <button class="nav-link nav-dropdown-trigger">
                        Products
                        <i class="ph ph-caret-down"></i>
                    </button>
                    <div class="nav-dropdown-menu">
                        <div class="nav-dropdown-grid">
                            <a href="/docs/peeksmith-3" class="nav-dropdown-item">
                                <img src="https://electricks.info/wp-content/uploads/2021/10/ps3_featured-300x300.png" alt="PeekSmith 3" class="nav-dropdown-image">
                                <div class="nav-dropdown-content">
                                    <span class="nav-dropdown-name">PeekSmith 3</span>
                                    <span class="nav-dropdown-desc">Card box and pocket peek</span>
                                </div>
                            </a>
                            <a href="/docs/bond" class="nav-dropdown-item">
                                <img src="https://electricks.info/wp-content/uploads/2024/10/bond-anim-300x300.gif" alt="Bond" class="nav-dropdown-image">
                                <div class="nav-dropdown-content">
                                    <span class="nav-dropdown-name">Bond</span>
                                    <span class="nav-dropdown-desc">Smartwatch peek</span>
                                </div>
                            </a>
                            <a href="/docs/mrcard" class="nav-dropdown-item">
                                <img src="https://electricks.info/wp-content/uploads/2025/03/MrCard-Final-300x300.png" alt="MrCard" class="nav-dropdown-image">
                                <div class="nav-dropdown-content">
                                    <span class="nav-dropdown-name">MrCard</span>
                                    <span class="nav-dropdown-desc">Access card peek & remote</span>
                                </div>
                            </a>
                            <a href="/docs/sbwatch" class="nav-dropdown-item">
                                <img src="https://electricks.info/wp-content/uploads/2022/05/sb_white_simple-300x300.png" alt="SB Watch" class="nav-dropdown-image">
                                <div class="nav-dropdown-content">
                                    <span class="nav-dropdown-name">SB Watch</span>
                                    <span class="nav-dropdown-desc">Predict the time</span>
                                </div>
                            </a>
                            <a href="/docs/sb-watch-2" class="nav-dropdown-item">
                                <img src="https://electricks.info/wp-content/uploads/2024/02/sbw2_-300x300.png" alt="SB Watch 2" class="nav-dropdown-image">
                                <div class="nav-dropdown-content">
                                    <span class="nav-dropdown-name">SB Watch 2</span>
                                    <span class="nav-dropdown-desc">Predict time & peek</span>
                                </div>
                            </a>
                            <a href="/docs/atom-remote" class="nav-dropdown-item">
                                <img src="https://electricks.info/wp-content/uploads/2023/01/atom2-300x300.png" alt="Atom 2" class="nav-dropdown-image">
                                <div class="nav-dropdown-content">
                                    <span class="nav-dropdown-name">Atom 2</span>
                                    <span class="nav-dropdown-desc">Control apps and devices</span>
                                </div>
                            </a>
                            <a href="/docs/sbmote" class="nav-dropdown-item">
                                <img src="https://electricks.info/wp-content/uploads/2022/12/sbmote-300x300.png" alt="SB Mote" class="nav-dropdown-image">
                                <div class="nav-dropdown-content">
                                    <span class="nav-dropdown-name">SB Mote</span>
                                    <span class="nav-dropdown-desc">Trigger app actions</span>
                                </div>
                            </a>
                            <a href="/docs/teleport" class="nav-dropdown-item">
                                <img src="https://electricks.info/wp-content/uploads/2025/01/teleport-QD-300x300.png" alt="Teleport" class="nav-dropdown-image">
                                <div class="nav-dropdown-content">
                                    <span class="nav-dropdown-name">Teleport</span>
                                    <span class="nav-dropdown-desc">Reveal cards, words</span>
                                </div>
                            </a>
                            <a href="/docs/quantum" class="nav-dropdown-item">
                                <img src="https://electricks.info/wp-content/uploads/2025/02/67EB80C5-BE05-4826-8FE7-BACB1838B4BC-300x300.png" alt="Quantum" class="nav-dropdown-image">
                                <div class="nav-dropdown-content">
                                    <span class="nav-dropdown-name">Quantum</span>
                                    <span class="nav-dropdown-desc">Force numbers, peek</span>
                                </div>
                            </a>
                            <a href="/docs/ghostmove" class="nav-dropdown-item">
                                <img src="https://electricks.info/wp-content/uploads/2021/10/ghostmove_featured-300x300.png" alt="GhostMove" class="nav-dropdown-image">
                                <div class="nav-dropdown-content">
                                    <span class="nav-dropdown-name">GhostMove</span>
                                    <span class="nav-dropdown-desc">Sense picked up object</span>
                                </div>
                            </a>
                            <a href="/docs/vision" class="nav-dropdown-item">
                                <img src="https://electricks.info/wp-content/uploads/2022/12/vision_glasses-1-300x300.png" alt="Vision Glasses" class="nav-dropdown-image">
                                <div class="nav-dropdown-content">
                                    <span class="nav-dropdown-name">Vision Glasses</span>
                                    <span class="nav-dropdown-desc">Hear information</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <a href="/docs/guides" class="nav-link">
                    Guides
                </a>
            </nav>

            <div class="header-actions">
                <button class="header-btn header-search-trigger" id="headerSearchBtn">
                    <i class="ph ph-magnifying-glass" style="font-size: 18px;"></i>
                    <span class="search-shortcut" id="searchShortcut">⌘K</span>
                </button>
                <a href="https://electricks.info" class="header-btn">
                    <i class="ph ph-storefront" style="font-size: 18px; margin-right: 4px;"></i>
                    Shop
                </a>
                <a href="/contact" class="header-btn header-btn-primary">
                    Contact Support
                </a>
            </div>
        </div>
    </header>

    <!-- Search Modal -->
    <div class="search-modal" id="searchModal">
        <div class="search-modal-overlay"></div>
        <div class="search-modal-content">
            <div class="search-modal-header">
                <div class="search-input-wrapper">
                    <i class="ph ph-magnifying-glass"></i>
                    <input
                        type="text"
                        id="searchModalInput"
                        placeholder="Search documentation..."
                        autocomplete="off"
                    >
                    <button class="search-close-btn" id="searchCloseBtn">
                        <i class="ph ph-x"></i>
                    </button>
                </div>
            </div>
            <div class="search-modal-body">
                <div class="search-results" id="searchResults">
                    <div class="search-empty-state">
                        <i class="ph ph-magnifying-glass"></i>
                        <p>Start typing to search...</p>
                    </div>
                </div>
            </div>
            <div class="search-modal-footer">
                <span class="search-hint">
                    <kbd>↑</kbd><kbd>↓</kbd> Navigate
                </span>
                <span class="search-hint">
                    <kbd>↵</kbd> Open
                </span>
                <span class="search-hint">
                    <kbd>Esc</kbd> Close
                </span>
            </div>
        </div>
    </div>

    <main class="site-main">
