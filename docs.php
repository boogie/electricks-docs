<?php
// Error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/config.php';

// Check if dependencies exist
if (!file_exists(__DIR__ . '/includes/markdown-parser.php')) {
    die('Error: markdown-parser.php not found');
}
if (!file_exists(__DIR__ . '/includes/navigation.php')) {
    die('Error: navigation.php not found');
}

require_once __DIR__ . '/includes/markdown-parser.php';
require_once __DIR__ . '/includes/navigation.php';

// Get the requested documentation path
$requestedPath = isset($_GET['path']) ? $_GET['path'] : 'docs';

// Sanitize path to prevent directory traversal
$requestedPath = str_replace(['..', '\\'], '', $requestedPath);
$requestedPath = trim($requestedPath, '/');

// Content is in content/docs/docs/ so we need to prepend 'docs/' if not already there
$contentPath = $requestedPath;
if (strpos($contentPath, 'docs/') !== 0) {
    $contentPath = 'docs/' . $contentPath;
}

// Build file path
$filePath = CONTENT_PATH . '/' . $contentPath;
if (!file_exists($filePath . '.md') && !file_exists($filePath)) {
    $filePath .= '.md';
} else {
    $filePath .= '.md';
}

// Check if file exists
if (!file_exists($filePath)) {
    // Try index file if directory requested
    $indexPath = CONTENT_PATH . '/' . $contentPath . '/index.md';
    if (file_exists($indexPath)) {
        $filePath = $indexPath;
    } else {
        // Show 404
        http_response_code(404);
        $pageTitle = 'Page Not Found';
        $currentPage = 'docs';
        include __DIR__ . '/includes/header.php';
        ?>
        <div class="container">
            <div class="error-page">
                <h1>404 - Page Not Found</h1>
                <p>The help article you're looking for doesn't exist.</p>
                <a href="/" class="btn btn-primary">Go to Help Center</a>
            </div>
        </div>
        <?php
        include __DIR__ . '/includes/footer.php';
        exit;
    }
}

// Parse the markdown file
$frontMatter = ElectricksMarkdownParser::extractFrontMatter($filePath);
$markdownContent = ElectricksMarkdownParser::getContentWithoutFrontMatter($filePath);

// Apply typography and convert special syntax
$markdownContent = ElectricksMarkdownParser::improveTypography($markdownContent);
$markdownContent = preg_replace(
    '/\[youtube:([a-zA-Z0-9_-]+)\]/',
    '<div class="video-embed"><iframe width="560" height="315" src="https://www.youtube.com/embed/$1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>',
    $markdownContent
);

// Convert kbd tags
$markdownContent = preg_replace('/\[kbd:([^\]]+)\]/', '<kbd>$1</kbd>', $markdownContent);

// Convert alerts
$markdownContent = preg_replace_callback(
    '/\[alert:(info|success|warning|danger)\](.*?)\[\/alert\]/s',
    function($matches) {
        $type = $matches[1];
        $content = $matches[2];

        // Split content into title and description using pipe separator
        $parts = explode('|', $content, 2);
        $title = trim($parts[0]);
        $description = isset($parts[1]) ? trim($parts[1]) : '';

        // Convert markdown links to HTML in the description
        if (!empty($description)) {
            $description = preg_replace('/\[([^\]]+)\]\(([^)]+)\)/', '<a href="$2">$1</a>', $description);
        }

        $html = '<div class="alert alert-' . $type . '" role="alert">';
        if (!empty($title)) {
            $html .= '<span class="alert-title">' . $title . '</span>';
        }
        if (!empty($description)) {
            $html .= '<span class="alert-description">' . $description . '</span>';
        }
        $html .= '</div>';

        return "\n\n" . $html . "\n\n";
    },
    $markdownContent
);

// Parse markdown to HTML
$parser = new ElectricksMarkdownParser();
$parser->setBreaksEnabled(true);
$parser->setMarkupEscaped(false);
$content = $parser->text($markdownContent);

// Post-process: unwrap alerts from <p> tags that Parsedown may have added
$content = preg_replace(
    '/<p>(\s*<div class="alert alert-(?:info|success|warning|danger)"[^>]*>.*?<\/div>\s*)<\/p>/s',
    '$1',
    $content
);

$toc = ElectricksMarkdownParser::extractTOC($filePath);

// Normalize links: convert electricks.info URLs to relative URLs
$content = preg_replace(
    '/href="https:\/\/electricks\.info(\/[^"]*?)(\?[^"]*)?"/i',
    'href="$1"',
    $content
);

// Set page title from front matter or first heading
$pageTitle = isset($frontMatter['title']) ? $frontMatter['title'] : 'Help Center';
$currentPage = 'docs';

// Get navigation elements
$breadcrumbs = getBreadcrumbs($requestedPath, $frontMatter);
$pageNav = getPageNavigation($requestedPath);

include __DIR__ . '/includes/header.php';
?>

<div class="docs-layout">
    <!-- Sidebar Navigation -->
    <?php echo buildNavigation($requestedPath); ?>

    <!-- Main Content -->
    <div class="docs-content">
        <article class="doc-article">
            <!-- Breadcrumbs -->
            <?php echo renderBreadcrumbs($breadcrumbs); ?>

            <!-- Article Content -->
            <div class="article-body">
                <?php echo $content; ?>
            </div>

            <!-- Helpful Section -->
            <div class="article-feedback">
                <h4>Was this article helpful?</h4>
                <div class="feedback-buttons">
                    <button class="btn btn-feedback" data-helpful="yes">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M14 8V2M14 2L11 5M14 2L17 5M7 11V4C7 3.46957 7.21071 2.96086 7.58579 2.58579C7.96086 2.21071 8.46957 2 9 2H13C13.5304 2 14.0391 2.21071 14.4142 2.58579C14.7893 2.96086 15 3.46957 15 4V11M7 11H4C3.46957 11 2.96086 11.2107 2.58579 11.5858C2.21071 11.9609 2 12.4696 2 13V16C2 16.5304 2.21071 17.0391 2.58579 17.4142C2.96086 17.7893 3.46957 18 4 18H13C13.5304 18 14.0391 17.7893 14.4142 17.4142C14.7893 17.0391 15 16.5304 15 16V13C15 12.4696 14.7893 11.9609 14.4142 11.5858C14.0391 11.2107 13.5304 11 13 11H7Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Yes
                    </button>
                    <button class="btn btn-feedback" data-helpful="no">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M6 12V18M6 18L3 15M6 18L9 15M13 9V16C13 16.5304 13.2107 17.0391 13.5858 17.4142C13.9609 17.7893 14.4696 18 15 18H17C17.5304 18 18.0391 17.7893 18.4142 17.4142C18.7893 17.0391 19 16.5304 19 16V9M13 9H16C16.5304 9 17.0391 8.78929 17.4142 8.41421C17.7893 8.03914 18 7.53043 18 7V4C18 3.46957 17.7893 2.96086 17.4142 2.58579C17.0391 2.21071 16.5304 2 16 2H7C6.46957 2 5.96086 2.21071 5.58579 2.58579C5.21071 2.96086 5 3.46957 5 4V7C5 7.53043 5.21071 8.03914 5.58579 8.41421C5.96086 8.78929 6.46957 9 7 9H13Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        No
                    </button>
                </div>
            </div>

            <!-- Prev/Next Navigation -->
            <?php echo renderPageNavigation($pageNav); ?>

            <!-- Last Updated -->
            <?php if (isset($frontMatter['updated'])): ?>
                <div class="doc-meta">
                    <p>Last updated: <?php echo htmlspecialchars($frontMatter['updated']); ?></p>
                </div>
            <?php else: ?>
                <div class="doc-meta">
                    <p>Last updated: <?php echo date('F j, Y', filemtime($filePath)); ?></p>
                </div>
            <?php endif; ?>
        </article>
    </div>

    <!-- Right Sidebar: Reusable Sidebar -->
    <aside class="docs-toc">
        <?php
        // Render reusable sidebar from sidebars.json
        if (isset($frontMatter['sidebar']) && !empty($frontMatter['sidebar'])) {
            echo buildReusableSidebar($frontMatter['sidebar'], $requestedPath);
        }
        ?>
    </aside>
</div>

<?php
$additionalScripts = ['/assets/js/docs.js'];
include __DIR__ . '/includes/footer.php';
?>
