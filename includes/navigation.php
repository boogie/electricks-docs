<?php
/**
 * Navigation Builder
 * Generates sidebar navigation from config
 */

function buildNavigation($currentPath = '') {
    global $NAVIGATION;

    if (!isset($NAVIGATION) || empty($NAVIGATION)) {
        return '';
    }

    $html = '<nav class="doc-sidebar">';

    // Group sections by category
    $grouped = [];
    $standalone = [];

    foreach ($NAVIGATION as $sectionSlug => $section) {
        if (isset($section['category'])) {
            $category = $section['category'];
            if (!isset($grouped[$category])) {
                $grouped[$category] = [];
            }
            $grouped[$category][$sectionSlug] = $section;
        } else {
            $standalone[$sectionSlug] = $section;
        }
    }

    // Render standalone sections first
    foreach ($standalone as $sectionSlug => $section) {
        $html .= renderNavSection($sectionSlug, $section, $currentPath);
    }

    // Render grouped sections
    foreach ($grouped as $categoryName => $sections) {
        $html .= '<div class="nav-category">';
        $html .= '<h4 class="doc-sidebar-heading">' . htmlspecialchars($categoryName) . '</h4>';

        $html .= '<ul class="doc-sidebar-links">';
        foreach ($sections as $sectionSlug => $section) {
            $html .= renderNavSection($sectionSlug, $section, $currentPath, true);
        }
        $html .= '</ul>';

        $html .= '</div>';
    }

    $html .= '</nav>';

    return $html;
}

/**
 * Render a single navigation section
 */
function renderNavSection($sectionSlug, $section, $currentPath, $isGrouped = false) {
    // Extract the product slug from section (e.g., "docs/peeksmith-3" -> "peeksmith-3")
    $productSlug = str_replace('docs/', '', $sectionSlug);

    // Check if current path matches this product
    $sectionActive = strpos($currentPath, $productSlug) === 0;
    $isActive = ($currentPath === $productSlug);

    if ($isGrouped) {
        // Grouped section - render as list item with icon
        $emoji = $section['emoji'] ?? '📄';

        $html = '<li' . ($isActive ? ' class="active"' : '') . '>';
        $html .= '<a href="/docs/' . htmlspecialchars($productSlug) . '">';
        $html .= '<span class="doc-link-icon">' . $emoji . '</span>';
        $html .= '<span class="doc-link-text">' . htmlspecialchars($section['title']) . '</span>';
        $html .= '</a>';
        $html .= '</li>';
    } else {
        // Standalone section - render with heading
        $emoji = $section['emoji'] ?? '📄';

        $html = '<div class="nav-section">';
        $html .= '<h4 class="doc-sidebar-heading">' . htmlspecialchars($section['title']) . '</h4>';
        $html .= '<ul class="doc-sidebar-links">';
        $html .= '<li' . ($isActive ? ' class="active"' : '') . '>';
        $html .= '<a href="/docs/' . htmlspecialchars($productSlug) . '">';
        $html .= '<span class="doc-link-icon">' . $emoji . '</span>';
        $html .= '<span class="doc-link-text">Overview</span>';
        $html .= '</a>';
        $html .= '</li>';
        $html .= '</ul>';
        $html .= '</div>';
    }

    return $html;
}

/**
 * Build product page navigation (for right sidebar)
 */
function buildProductPageNav($currentPath) {
    global $NAVIGATION;

    // Find which product section this path belongs to
    $productSlug = null;
    $productSection = null;

    foreach ($NAVIGATION as $sectionSlug => $section) {
        $slug = str_replace('docs/', '', $sectionSlug);
        if (strpos($currentPath, $slug) === 0) {
            $productSlug = $slug;
            $productSection = $section;
            break;
        }
    }

    if (!$productSection) {
        return '';
    }

    $html = '<div class="product-page-nav">';
    $html .= '<h4>' . htmlspecialchars($productSection['title']) . '</h4>';

    // Use grouped navigation if available, otherwise fall back to flat list
    if (isset($productSection['groups']) && !empty($productSection['groups'])) {
        $groupTitles = [
            'overview' => 'Overview',
            'general' => 'General',
            'features' => 'Features',
            'compatibility' => 'Compatibility',
            'accessories' => 'Accessories',
            'other' => 'Other'
        ];

        foreach ($productSection['groups'] as $groupKey => $items) {
            if (empty($items)) continue;

            // Skip "Overview" group title if it only has one item
            if ($groupKey !== 'overview' || count($items) > 1) {
                $html .= '<h5 class="product-nav-group">' . $groupTitles[$groupKey] . '</h5>';
            }

            $html .= '<ul>';
            foreach ($items as $itemSlug => $itemTitle) {
                $itemUrl = str_replace('docs/', '', $itemSlug);
                $isActive = ($currentPath === $itemUrl);

                $html .= '<li class="' . ($isActive ? 'active' : '') . '">';
                $html .= '<a href="/docs/' . htmlspecialchars($itemUrl) . '">';
                $html .= htmlspecialchars($itemTitle);
                $html .= '</a>';
                $html .= '</li>';
            }
            $html .= '</ul>';
        }
    } else {
        // Fallback to flat list
        if (!empty($productSection['items'])) {
            $html .= '<ul>';
            foreach ($productSection['items'] as $itemSlug => $itemTitle) {
                $itemUrl = str_replace('docs/', '', $itemSlug);
                $isActive = ($currentPath === $itemUrl);

                $html .= '<li class="' . ($isActive ? 'active' : '') . '">';
                $html .= '<a href="/docs/' . htmlspecialchars($itemUrl) . '">';
                $html .= htmlspecialchars($itemTitle);
                $html .= '</a>';
                $html .= '</li>';
            }
            $html .= '</ul>';
        }
    }

    $html .= '</div>';

    return $html;
}

/**
 * Build reusable sidebar from sidebars.json
 */
function buildReusableSidebar($sidebarId, $currentPath = '') {
    $sidebarsFile = __DIR__ . '/../sidebars.json';

    if (!file_exists($sidebarsFile)) {
        return '';
    }

    $sidebars = json_decode(file_get_contents($sidebarsFile), true);

    if (!isset($sidebars[$sidebarId])) {
        return '';
    }

    $sidebar = $sidebars[$sidebarId];
    $html = '';

    // Normalize current path for comparison (add /docs/ prefix if not present)
    $currentPath = trim($currentPath, '/');
    if (strpos($currentPath, 'docs/') !== 0) {
        $currentPath = 'docs/' . $currentPath;
    }
    $currentPath = '/' . $currentPath;

    foreach ($sidebar['sections'] as $section) {
        $sectionType = $section['type'] ?? 'normal';
        $isRelatedProducts = ($sectionType === 'related-products');

        // Check if current page is in this section
        $isSectionActive = false;
        foreach ($section['links'] as $link) {
            $linkPath = '/' . trim($link['url'], '/');
            $normalizedCurrent = '/' . trim($currentPath, '/');
            if ($normalizedCurrent === $linkPath) {
                $isSectionActive = true;
                break;
            }
        }

        // Add active class to section wrapper if page is in this section
        $sectionClasses = [];
        if ($isRelatedProducts) {
            $sectionClasses[] = 'related-products-section';
        }
        if ($isSectionActive) {
            $sectionClasses[] = 'active-section';
        }

        // Always wrap sections (for active highlighting)
        $sectionClassAttr = !empty($sectionClasses) ? ' class="' . implode(' ', $sectionClasses) . '"' : '';
        $html .= '<div' . $sectionClassAttr . '>';

        if ($isRelatedProducts) {
            $html .= '<div class="docs-group-nav">';
        }

        // Section heading
        $headingClass = $isRelatedProducts ? 'related-products-heading' : '';
        $html .= '<h4 class="sidebar-section-heading ' . $headingClass . '">' . htmlspecialchars($section['heading']) . '</h4>';

        // Section links
        $html .= '<ul class="sidebar-links">';
        foreach ($section['links'] as $link) {
            $linkPath = '/' . trim($link['url'], '/');
            $normalizedCurrent = '/' . trim($currentPath, '/');
            $isActive = ($normalizedCurrent === $linkPath);
            $classes = [];
            if (isset($link['highlight']) && $link['highlight']) {
                $classes[] = 'highlight';
            }
            if ($isActive) {
                $classes[] = 'active';
            }

            $classAttr = !empty($classes) ? ' class="' . implode(' ', $classes) . '"' : '';

            $html .= '<li' . $classAttr . '>';
            $html .= '<a href="' . htmlspecialchars($link['url']) . '"';
            if ($isActive) {
                $html .= ' aria-current="page"';
            }
            $html .= '>';
            $html .= '<span class="link-icon">' . htmlspecialchars($link['icon']) . '</span>';
            $html .= '<span class="link-text">' . htmlspecialchars($link['text']) . '</span>';
            $html .= '</a>';
            $html .= '</li>';
        }
        $html .= '</ul>';

        if ($isRelatedProducts) {
            $html .= '</div>'; // close docs-group-nav
        }

        $html .= '</div>'; // close section wrapper
    }

    return $html;
}

/**
 * Build Table of Contents from parsed markdown
 */
function buildTableOfContents($toc) {
    if (empty($toc)) {
        return '';
    }

    $html = '<div class="table-of-contents">';
    $html .= '<h4>On This Page</h4>';
    $html .= '<ul>';

    foreach ($toc as $item) {
        // Only show h2 (main sections) in TOC for compact view
        if ($item['level'] != 2) {
            continue;
        }

        $html .= '<li class="toc-level-' . $item['level'] . '">';
        $html .= '<a href="#' . htmlspecialchars($item['id']) . '">';
        $html .= htmlspecialchars($item['title']);
        $html .= '</a>';
        $html .= '</li>';
    }

    $html .= '</ul>';
    $html .= '</div>';

    return $html;
}

/**
 * Get breadcrumbs for current page
 */
function getBreadcrumbs($path, $frontMatter = []) {
    $parts = explode('/', trim($path, '/'));
    $breadcrumbs = [
        ['title' => 'Documentation', 'url' => '/']
    ];

    // Get page title from frontmatter
    $pageTitle = isset($frontMatter['title']) ? $frontMatter['title'] : null;

    // If we have a page title, add it as the current page
    if ($pageTitle) {
        // Check if this is a top-level product page (docs/product-name)
        if (count($parts) === 1) {
            $breadcrumbs[] = [
                'title' => $pageTitle,
                'url' => null // Current page
            ];
        } else {
            // This is a subpage, so we need to figure out the parent
            // For now, assume the first part is the product
            $productSlug = $parts[0];

            // Try to get the parent page title
            $parentPath = CONTENT_PATH . '/docs/' . $productSlug . '.md';
            if (file_exists($parentPath)) {
                $parentFrontMatter = ElectricksMarkdownParser::extractFrontMatter($parentPath);
                if (isset($parentFrontMatter['title'])) {
                    $breadcrumbs[] = [
                        'title' => $parentFrontMatter['title'],
                        'url' => '/docs/' . $productSlug
                    ];
                }
            }

            // Add current page
            $breadcrumbs[] = [
                'title' => $pageTitle,
                'url' => null // Current page
            ];
        }
    }

    return $breadcrumbs;
}

/**
 * Render breadcrumbs HTML
 */
function renderBreadcrumbs($breadcrumbs) {
    if (empty($breadcrumbs)) {
        return '';
    }

    $html = '<nav class="breadcrumbs" aria-label="Breadcrumb">';
    $html .= '<a href="/"><img src="/assets/images/favicon-32x32.png" alt="" class="breadcrumb-icon"></a>';
    $html .= '<img src="/assets/images/chevron.svg" alt="" class="breadcrumb-chevron">';
    $html .= '<ol>';

    foreach ($breadcrumbs as $index => $crumb) {
        $isLast = ($index === count($breadcrumbs) - 1);

        $html .= '<li>';

        if ($isLast || $crumb['url'] === null) {
            $html .= '<span>' . htmlspecialchars($crumb['title']) . '</span>';
        } else {
            $html .= '<a href="' . htmlspecialchars($crumb['url']) . '">';
            $html .= htmlspecialchars($crumb['title']);
            $html .= '</a>';
        }

        if (!$isLast) {
            $html .= '<img src="/assets/images/chevron.svg" alt="" class="breadcrumb-chevron">';
        }

        $html .= '</li>';
    }

    $html .= '</ol>';
    $html .= '</nav>';

    return $html;
}

/**
 * Get next/previous page navigation
 */
function getPageNavigation($currentPath) {
    global $NAVIGATION;

    $allPages = [];

    foreach ($NAVIGATION as $sectionSlug => $section) {
        if (isset($section['items'])) {
            foreach ($section['items'] as $itemSlug => $itemTitle) {
                $allPages[] = [
                    'path' => $sectionSlug . '/' . $itemSlug,
                    'title' => $itemTitle,
                    'section' => $section['title']
                ];
            }
        }
    }

    $currentIndex = -1;
    foreach ($allPages as $index => $page) {
        if ($page['path'] === $currentPath) {
            $currentIndex = $index;
            break;
        }
    }

    $prev = ($currentIndex > 0) ? $allPages[$currentIndex - 1] : null;
    $next = ($currentIndex < count($allPages) - 1) ? $allPages[$currentIndex + 1] : null;

    return ['prev' => $prev, 'next' => $next];
}

/**
 * Render prev/next navigation
 */
function renderPageNavigation($navigation) {
    if (!$navigation['prev'] && !$navigation['next']) {
        return '';
    }

    $html = '<div class="page-navigation">';

    if ($navigation['prev']) {
        $prev = $navigation['prev'];
        $html .= '<a href="/docs/' . htmlspecialchars($prev['path']) . '" class="page-nav-link prev">';
        $html .= '<span class="page-nav-label">Previous</span>';
        $html .= '<span class="page-nav-title">' . htmlspecialchars($prev['title']) . '</span>';
        $html .= '</a>';
    } else {
        $html .= '<div></div>';
    }

    if ($navigation['next']) {
        $next = $navigation['next'];
        $html .= '<a href="/docs/' . htmlspecialchars($next['path']) . '" class="page-nav-link next">';
        $html .= '<span class="page-nav-label">Next</span>';
        $html .= '<span class="page-nav-title">' . htmlspecialchars($next['title']) . '</span>';
        $html .= '</a>';
    }

    $html .= '</div>';

    return $html;
}
