<?php
require_once __DIR__ . '/config.php';

$pageTitle = 'Help Center';
$currentPage = 'home';

include __DIR__ . '/includes/header.php';
?>

<div class="hero">
    <canvas id="meshGradientCanvas"></canvas>
    <div class="container">
        <div class="hero-content-center">
            <h1 class="hero-title">
                How can we <span class="gradient-text">help you?</span>
            </h1>
            <p class="hero-subtitle">
                Find answers, guides, and support for all your Electricks products.
            </p>

            <!-- Search Bar -->
            <div class="hero-search">
                <div class="search-box-large">
                    <svg class="search-icon" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="2"/>
                        <path d="M16.5 16.5L21 21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    <input type="text" id="heroSearchInput" placeholder="Search for help articles, guides, devices..." autocomplete="off">
                    <kbd class="search-shortcut">⌘ K</kbd>
                </div>
                <div id="heroSearchResults" class="search-results-dropdown"></div>
            </div>

            <!-- Popular Searches -->
            <div class="popular-searches">
                <span class="popular-label">Popular:</span>
                <a href="/docs/devices/peeking/peeksmith-3" class="popular-tag">PeekSmith 3</a>
                <a href="/docs/guides/bluetooth-pairing" class="popular-tag">Bluetooth Pairing</a>
                <a href="/docs/guides/firmware-updates" class="popular-tag">Firmware Updates</a>
                <a href="/docs/guides/troubleshooting-common-issues" class="popular-tag">Troubleshooting</a>
            </div>
        </div>
    </div>
</div>

<!-- Products Section -->
<section class="products-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Get support.</h2>
        </div>
        <div class="products-grid">
            <a href="/docs/devices/remote-control/atom-2" class="product-item">
                <div class="product-icon">
                    <img src="https://electricks.info/wp-content/uploads/2023/01/atom2-300x300.png" alt="Atom 2">
                </div>
                <span class="product-name">Atom 2</span>
            </a>
            <a href="/docs/devices/peeking/peeksmith-3" class="product-item">
                <div class="product-icon">
                    <img src="https://electricks.info/wp-content/uploads/2021/10/ps3_featured-300x300.png" alt="PeekSmith 3">
                </div>
                <span class="product-name">PeekSmith 3</span>
            </a>
            <a href="/docs/devices/remote-control/bond" class="product-item">
                <div class="product-icon">
                    <img src="https://electricks.info/wp-content/uploads/2024/10/bond-anim-300x300.gif" alt="Bond">
                </div>
                <span class="product-name">Bond</span>
            </a>
            <a href="/docs/devices/wearables/sb-watch-2" class="product-item">
                <div class="product-icon">
                    <img src="https://electricks.info/wp-content/uploads/2024/02/sbw2_-300x300.png" alt="SB Watch 2">
                </div>
                <span class="product-name">SB Watch 2</span>
            </a>
            <a href="/docs/devices/calculators/quantum-calculator" class="product-item">
                <div class="product-icon">
                    <img src="https://electricks.info/wp-content/uploads/2025/02/67EB80C5-BE05-4826-8FE7-BACB1838B4BC-300x300.png" alt="Quantum Calculator">
                </div>
                <span class="product-name">Quantum</span>
            </a>
            <a href="/docs/devices/remote-control/teleport" class="product-item">
                <div class="product-icon">
                    <img src="https://electricks.info/wp-content/uploads/2025/01/teleport-QD-300x300.png" alt="Teleport">
                </div>
                <span class="product-name">Teleport</span>
            </a>
        </div>
    </div>
</section>

<section class="categories">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Master your Magic.</h2>
        </div>

        <div class="category-grid">
            <?php
            global $NAVIGATION;
            foreach ($NAVIGATION as $categorySlug => $category):
                $iconColor = $category['icon_color'] ?? 'blue';
                $iconName = $category['icon'] ?? 'folder';
                $itemCount = isset($category['items']) ? count($category['items']) : 0;

                // Get first item - it already includes the full path
                $firstItemKey = isset($category['items']) ? key($category['items']) : str_replace('docs/', '', $categorySlug);
                // Remove 'docs/' prefix from the item key for the URL
                $firstItem = str_replace('docs/', '', $firstItemKey);

                $devices = $category['devices'] ?? [];
                $image = $category['image'] ?? null;

                // Generate unique ID for this icon
                $iconId = 'cat-' . str_replace(['/', ' '], '-', $categorySlug);
            ?>
            <a href="/docs/<?php echo htmlspecialchars($firstItem); ?>" class="category-card glass-card">
                <?php if ($image): ?>
                <div class="category-image-wrapper">
                    <img src="<?php echo htmlspecialchars($image); ?>" alt="<?php echo htmlspecialchars($category['title']); ?>" class="category-image">
                </div>
                <?php endif; ?>

                <div class="category-card-header">
                    <div class="liquid-glass-icon-container" data-liquid-glass="<?php echo htmlspecialchars($iconColor); ?>" data-size="60" data-id="<?php echo $iconId; ?>">
                        <i class="ph-fill ph-<?php echo htmlspecialchars($iconName); ?>"></i>
                    </div>
                    <div class="category-card-title-wrapper">
                        <h3 class="category-title"><?php echo htmlspecialchars($category['title']); ?></h3>
                        <?php if (isset($category['description']) && $category['description']): ?>
                        <p class="category-subtitle">
                            <?php echo htmlspecialchars($category['description']); ?>
                        </p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="category-footer">
                    <span class="btn btn-primary btn-small">
                        Explore
                        <svg width="14" height="14" viewBox="0 0 16 16" fill="none">
                            <path d="M6 3L11 8L6 13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    <span class="category-count">
                        <i class="ph ph-article"></i>
                        <?php echo $itemCount; ?> article<?php echo $itemCount !== 1 ? 's' : ''; ?>
                    </span>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="updates-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Latest updates.</h2>
        </div>

        <div class="updates-grid">
            <div class="update-card glass-card">
                <div class="update-badge firmware">Firmware Update</div>
                <h3 class="update-title">PeekSmith 3 v2.8.0</h3>
                <p class="update-description">Improved battery life, faster Bluetooth pairing, and new display modes.</p>
                <div class="update-footer">
                    <span class="update-date">
                        <i class="ph ph-calendar"></i>
                        January 15, 2025
                    </span>
                </div>
            </div>

            <div class="update-card glass-card">
                <div class="update-badge app">App Update</div>
                <h3 class="update-title">TimeSmith App v3.2</h3>
                <p class="update-description">New prediction modes, enhanced UI, and improved watch synchronization.</p>
                <div class="update-footer">
                    <span class="update-date">
                        <i class="ph ph-calendar"></i>
                        January 10, 2025
                    </span>
                </div>
            </div>

            <div class="update-card glass-card">
                <div class="update-badge firmware">Firmware Update</div>
                <h3 class="update-title">Atom 2 Remote v1.5.2</h3>
                <p class="update-description">Bug fixes, new button configurations, and MagiScript compatibility improvements.</p>
                <div class="update-footer">
                    <span class="update-date">
                        <i class="ph ph-calendar"></i>
                        January 5, 2025
                    </span>
                </div>
            </div>

            <div class="update-card glass-card">
                <div class="update-badge feature">New Feature</div>
                <h3 class="update-title">Multi-Device Hub Mode</h3>
                <p class="update-description">PeekSmith 3 can now act as a hub to control multiple devices simultaneously.</p>
                <div class="update-footer">
                    <span class="update-date">
                        <i class="ph ph-calendar"></i>
                        December 28, 2024
                    </span>
                </div>
            </div>
        </div>

        <div class="updates-cta">
            <a href="#" class="btn btn-secondary">View All Updates</a>
        </div>
    </div>
</section>

<section class="featured-articles">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Popular articles.</h2>
        </div>

        <div class="articles-grid">
            <a href="/docs/devices/peeking/peeksmith-3" class="article-card glass-card featured">
                <div class="article-card-header">
                    <div class="liquid-glass-icon-container article-icon-liquid" data-liquid-glass="blue" data-size="56" data-id="art-ps3">
                        <i class="ph-fill ph-eye"></i>
                    </div>
                    <span class="article-badge">Popular</span>
                </div>
                <h3 class="article-title">PeekSmith 3 User Guide</h3>
                <p class="article-excerpt">Complete guide to setting up and using your PeekSmith 3 device.</p>
                <div class="article-footer">
                    <span class="article-meta">
                        <i class="ph ph-clock"></i>
                        10 min read
                    </span>
                </div>
            </a>

            <a href="/docs/devices/remotes/atom-smart-remote" class="article-card glass-card">
                <div class="article-card-header">
                    <div class="liquid-glass-icon-container article-icon-liquid" data-liquid-glass="orange" data-size="56" data-id="art-atom">
                        <i class="ph-fill ph-game-controller"></i>
                    </div>
                </div>
                <h3 class="article-title">Atom Smart Remote Setup</h3>
                <p class="article-excerpt">Get your Atom remote up and running in minutes.</p>
                <div class="article-footer">
                    <span class="article-meta">
                        <i class="ph ph-clock"></i>
                        5 min read
                    </span>
                </div>
            </a>

            <a href="/docs/guides/firmware-updates" class="article-card glass-card">
                <div class="article-card-header">
                    <div class="liquid-glass-icon-container article-icon-liquid" data-liquid-glass="purple" data-size="56" data-id="art-firmware">
                        <i class="ph-fill ph-download-simple"></i>
                    </div>
                </div>
                <h3 class="article-title">How to Update Firmware</h3>
                <p class="article-excerpt">Keep your devices up to date with the latest features.</p>
                <div class="article-footer">
                    <span class="article-meta">
                        <i class="ph ph-clock"></i>
                        8 min read
                    </span>
                </div>
            </a>

            <a href="/docs/guides/bluetooth-pairing" class="article-card glass-card">
                <div class="article-card-header">
                    <div class="liquid-glass-icon-container article-icon-liquid" data-liquid-glass="teal" data-size="56" data-id="art-bluetooth">
                        <i class="ph-fill ph-bluetooth"></i>
                    </div>
                </div>
                <h3 class="article-title">Bluetooth Pairing Guide</h3>
                <p class="article-excerpt">Connect your devices to your phone effortlessly.</p>
                <div class="article-footer">
                    <span class="article-meta">
                        <i class="ph ph-clock"></i>
                        6 min read
                    </span>
                </div>
            </a>

            <a href="/docs/guides/troubleshooting-common-issues" class="article-card glass-card">
                <div class="article-card-header">
                    <div class="liquid-glass-icon-container article-icon-liquid" data-liquid-glass="pink" data-size="56" data-id="art-trouble">
                        <i class="ph-fill ph-warning"></i>
                    </div>
                </div>
                <h3 class="article-title">Troubleshooting Common Issues</h3>
                <p class="article-excerpt">Quick fixes for the most common problems.</p>
                <div class="article-footer">
                    <span class="article-meta">
                        <i class="ph ph-clock"></i>
                        12 min read
                    </span>
                </div>
            </a>

            <a href="/docs/getting-started/index" class="article-card glass-card">
                <div class="article-card-header">
                    <div class="liquid-glass-icon-container article-icon-liquid" data-liquid-glass="green" data-size="56" data-id="art-start">
                        <i class="ph-fill ph-rocket-launch"></i>
                    </div>
                </div>
                <h3 class="article-title">Getting Started Guide</h3>
                <p class="article-excerpt">New to Electricks? Start your journey here.</p>
                <div class="article-footer">
                    <span class="article-meta">
                        <i class="ph ph-clock"></i>
                        15 min read
                    </span>
                </div>
            </a>
        </div>
    </div>
</section>

<section class="help-cta">
    <div class="container">
        <div class="cta-content-centered">
            <div class="liquid-glass-icon-container cta-icon-liquid" data-liquid-glass="indigo" data-size="96" data-id="cta-support">
                <i class="ph-fill ph-lifebuoy"></i>
            </div>
            <h2 class="cta-title">Get the support you need.</h2>
            <p class="cta-description">Our support team is here to assist you with any questions or issues.</p>
            <div class="cta-actions">
                <a href="/docs/support/contact" class="btn btn-primary btn-large">
                    Contact Support
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path d="M7.5 5L12.5 10L7.5 15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
                <a href="https://www.facebook.com/groups/electricks" target="_blank" class="btn btn-secondary btn-large">
                    Join Community
                </a>
            </div>
        </div>
    </div>
</section>

<?php
$additionalScripts = ['/assets/js/mesh-gradient.js', '/assets/js/home-search.js'];
include __DIR__ . '/includes/footer.php';
?>
