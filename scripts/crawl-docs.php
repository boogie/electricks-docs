<?php
/**
 * Electricks Documentation Crawler
 *
 * Unified script that:
 * 1. Crawls documentation pages from electricks.info
 * 2. Extracts content and converts to Markdown
 * 3. Extracts Elementor sidebar structures
 * 4. Automatically adds sidebar metadata to markdown files
 *
 * Usage:
 *   php crawl-docs.php [--options]
 *
 * Options:
 *   --docs-only        Only crawl documentation content (skip sidebars)
 *   --sidebars-only    Only extract sidebars (skip content)
 *   --dry-run          Show what would be done without making changes
 *   --help             Show this help message
 */

class ElectricksDocsCrawler {
    private $baseUrl = 'https://electricks.info';
    private $contentDir;
    private $sidebarsFile;
    private $dryRun = false;

    private $navigationStructure = [];
    private $stats = [
        'pages' => 0,
        'sidebars' => 0,
        'files_updated' => 0,
        'errors' => 0
    ];

    // Products to crawl
    private $products = [
        'peeksmith-3',
        'bond',
        'mrcard',
        'sbwatch',
        'sb-watch-2',
        'atom-remote',
        'sbmote',
        'teleport',
        'quantum',
        'spotted-dice',
        'cubesmith',
        'ghostmove',
        'soulmate',
        'ray',
        'vision',
        'mental-wave',
        'lunacards',
        'nfc-rfid',
        'magiscript',
        'peeksmith-app',
        'timesmith-app',
        'dicesmith-app',
        'scalesmith-app'
    ];

    // Products to ignore (will not be crawled)
    private $ignoredProducts = [
        'espyon-nfc-rfid-reader'
    ];

    public function __construct($options = []) {
        $this->contentDir = __DIR__ . '/../content/docs/docs';
        $this->sidebarsFile = __DIR__ . '/../sidebars.json';
        $this->dryRun = isset($options['dry-run']);
    }

    public function run($mode = 'all') {
        echo "=== Electricks Documentation Crawler ===\n\n";
        echo "Mode: " . strtoupper($mode) . "\n";
        echo "Dry Run: " . ($this->dryRun ? 'YES' : 'NO') . "\n\n";

        if ($mode === 'all' || $mode === 'docs') {
            $this->crawlDocumentation();
        }

        if ($mode === 'all' || $mode === 'sidebars') {
            $this->crawlSidebars();
        }

        $this->printStats();
    }

    /**
     * Crawl documentation pages and convert to markdown
     */
    private function crawlDocumentation() {
        echo "=== Crawling Documentation Pages ===\n\n";

        foreach ($this->products as $product) {
            $this->crawlProductPages($product);
        }
    }

    /**
     * Crawl all pages for a product
     */
    private function crawlProductPages($product) {
        echo "Crawling: $product\n";

        $url = "{$this->baseUrl}/docs/$product/";
        $html = $this->fetchPage($url);

        if (!$html) {
            echo "  ⚠️  Failed to fetch\n";
            $this->stats['errors']++;
            return;
        }

        // Extract main page
        $this->extractPage($html, $product, $url);

        // Find and crawl sub-pages
        $subPages = $this->findSubPages($html, $product);
        foreach ($subPages as $subPage) {
            $subHtml = $this->fetchPage($subPage['url']);
            if ($subHtml) {
                $this->extractPage($subHtml, $product, $subPage['url'], $subPage['slug']);
            }
            sleep(1); // Be nice to the server
        }
    }

    /**
     * Extract and save page content as markdown
     */
    private function extractPage($html, $product, $url, $slug = null) {
        $dom = new DOMDocument();
        @$dom->loadHTML($html);
        $xpath = new DOMXPath($dom);

        // Extract title
        $titleNodes = $xpath->query("//h1[@class='entry-title'] | //h1");
        $title = $titleNodes->length > 0 ? trim($titleNodes->item(0)->textContent) : ucwords(str_replace('-', ' ', $slug ?? $product));

        // Extract main content
        $contentNodes = $xpath->query("//div[contains(@class, 'entry-content')] | //article");
        $content = '';
        if ($contentNodes->length > 0) {
            $content = $this->nodeToMarkdown($contentNodes->item(0), $xpath);
        }

        // Build filename
        $filename = $slug ? "$product/$slug.md" : "$product.md";
        $filepath = "{$this->contentDir}/$filename";

        // Extract metadata
        $metadata = [
            'title' => $title,
            'updated' => date('Y-m-d'),
            'author' => 'Electricks',
            'category' => 'guides'
        ];

        // Build markdown file
        $markdown = $this->buildMarkdownFile($title, $content, $metadata);

        // Save file
        if (!$this->dryRun) {
            $dir = dirname($filepath);
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            file_put_contents($filepath, $markdown);
        }

        echo "  ✅ $filename\n";
        $this->stats['pages']++;
    }

    /**
     * Find sub-pages from main product page
     */
    private function findSubPages($html, $product) {
        $pages = [];
        $dom = new DOMDocument();
        @$dom->loadHTML($html);
        $xpath = new DOMXPath($dom);

        // Find links in content that belong to this product
        $links = $xpath->query("//a[contains(@href, '/docs/$product/')]");
        foreach ($links as $link) {
            $href = $link->getAttribute('href');
            if (preg_match('#/docs/' . preg_quote($product) . '/([^/]+)/?$#', $href, $matches)) {
                $slug = $matches[1];
                if (!isset($pages[$slug])) {
                    $pages[$slug] = [
                        'slug' => $slug,
                        'url' => $href,
                        'title' => trim($link->textContent)
                    ];
                }
            }
        }

        return array_values($pages);
    }

    /**
     * Convert DOM node to Markdown
     */
    private function nodeToMarkdown($node, $xpath) {
        // Get HTML content
        $html = $node->ownerDocument->saveHTML($node);

        // Remove Elementor sidebars and widgets
        $html = preg_replace('/<div[^>]*elementor-element[^>]*>.*?<\/div>/is', '', $html);
        $html = preg_replace('/<div[^>]*elementor-widget-wrap[^>]*>.*?<\/div>/is', '', $html);

        // Convert to markdown
        return $this->htmlToMarkdown($html);
    }

    /**
     * Convert HTML to Markdown
     */
    private function htmlToMarkdown($html) {
        // Remove comments and scripts
        $html = preg_replace('/<!--.*?-->/s', '', $html);
        $html = preg_replace('/<script[^>]*>.*?<\/script>/is', '', $html);
        $html = preg_replace('/<style[^>]*>.*?<\/style>/is', '', $html);

        // Convert code blocks (pre/code tags)
        $html = preg_replace_callback('/<pre[^>]*><code[^>]*>(.*?)<\/code><\/pre>/is', function($matches) {
            $code = html_entity_decode($matches[1], ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $code = strip_tags($code);
            return "\n\n```javascript\n" . $code . "\n```\n\n";
        }, $html);

        // Convert inline code
        $html = preg_replace('/<code[^>]*>(.*?)<\/code>/is', "`$1`", $html);

        // Convert images
        $html = preg_replace('/<img[^>]+src="([^"]+)"[^>]*alt="([^"]*)"[^>]*>/i', "\n\n![$2]($1)\n\n", $html);

        // Convert YouTube embeds
        $html = preg_replace(
            '/<iframe[^>]*youtube(?:-nocookie)?\.com\/embed\/([a-zA-Z0-9_-]+)[^>]*>.*?<\/iframe>/is',
            "\n\n[![YouTube]( https://img.youtube.com/vi/$1/0.jpg)](https://www.youtube.com/watch?v=$1)\n\n",
            $html
        );

        // Convert headings
        $html = preg_replace('/<h1[^>]*>(.*?)<\/h1>/is', "# $1\n\n", $html);
        $html = preg_replace('/<h2[^>]*>(.*?)<\/h2>/is', "## $1\n\n", $html);
        $html = preg_replace('/<h3[^>]*>(.*?)<\/h3>/is', "### $1\n\n", $html);
        $html = preg_replace('/<h4[^>]*>(.*?)<\/h4>/is', "#### $1\n\n", $html);

        // Convert text formatting
        $html = preg_replace('/<strong[^>]*>(.*?)<\/strong>/is', "**$1**", $html);
        $html = preg_replace('/<b[^>]*>(.*?)<\/b>/is', "**$1**", $html);
        $html = preg_replace('/<em[^>]*>(.*?)<\/em>/is', "*$1*", $html);
        $html = preg_replace('/<i[^>]*>(.*?)<\/i>/is', "*$1*", $html);

        // Convert links
        $html = preg_replace('/<a\s+href="([^"]*)"[^>]*>(.*?)<\/a>/is', "[$2]($1)", $html);

        // Convert lists
        $html = preg_replace('/<ul[^>]*>(.*?)<\/ul>/is', "$1\n", $html);
        $html = preg_replace('/<ol[^>]*>(.*?)<\/ol>/is', "$1\n", $html);
        $html = preg_replace('/<li[^>]*>(.*?)<\/li>/is', "- $1\n", $html);

        // Convert paragraphs
        $html = preg_replace('/<p[^>]*>(.*?)<\/p>/is', "$1\n\n", $html);
        $html = preg_replace('/<br\s*\/?>/i', "\n", $html);

        // Remove remaining HTML tags
        $html = strip_tags($html);

        // Clean up whitespace
        $html = preg_replace('/\n{3,}/', "\n\n", $html);
        $html = preg_replace('/[ \t]+/', ' ', $html);
        $html = trim($html);

        // Decode HTML entities
        $html = html_entity_decode($html, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        // Remove duplicate h1 headings
        $html = preg_replace('/^#\s+.+?\n\n/m', '', $html);

        return $html;
    }

    /**
     * Crawl sidebars from all product pages
     */
    private function crawlSidebars() {
        echo "\n=== Extracting Elementor Sidebars ===\n\n";

        $allSidebars = [];

        foreach ($this->products as $product) {
            echo "Scraping: $product\n";
            $url = "{$this->baseUrl}/docs/$product/";
            $html = $this->fetchPage($url);

            if (!$html) {
                continue;
            }

            $sidebars = $this->extractElementorSidebars($html);
            if ($sidebars) {
                foreach ($sidebars as $sidebarId => $sidebarData) {
                    if (!isset($allSidebars[$sidebarId])) {
                        if (empty($sidebarData['name'])) {
                            $sidebarData['name'] = ucwords(str_replace('-', ' ', $product)) . ' Sidebar';
                        }
                        $allSidebars[$sidebarId] = $sidebarData;
                        echo "  ✅ Found sidebar: $sidebarId\n";
                    }
                }

                // Store product-sidebar mapping
                $this->navigationStructure['sidebars'][$product] = [
                    'type' => 'elementor',
                    'sidebars' => $sidebars
                ];
            }

            sleep(1);
        }

        // Save sidebars
        if (!empty($allSidebars) && !$this->dryRun) {
            $this->saveSidebars($allSidebars);
            $this->addSidebarsToMarkdownFiles();
        }

        $this->stats['sidebars'] = count($allSidebars);
    }

    /**
     * Normalize URL - remove trailing slashes and query strings
     */
    private function normalizeUrl($url) {
        // Remove query string
        $url = preg_replace('/\?.*$/', '', $url);
        // Remove trailing slash
        $url = rtrim($url, '/');
        return $url;
    }

    /**
     * Extract Elementor sidebars from HTML
     */
    private function extractElementorSidebars($html) {
        $dom = new DOMDocument();
        @$dom->loadHTML($html);
        $xpath = new DOMXPath($dom);

        $widgets = $xpath->query("//div[@data-widget_type='shortcode.default']");
        $sidebars = [];

        foreach ($widgets as $widget) {
            $dataId = $widget->getAttribute('data-id');
            if (!$dataId) continue;

            $headings = $xpath->query(".//h2", $widget);
            $links = $xpath->query(".//a", $widget);

            if ($headings->length > 0 && $links->length > 0) {
                $sidebarData = [
                    'id' => $dataId,
                    'name' => '',
                    'sections' => []
                ];

                // Find all sections - look for divs with class 'docs-group-nav' (related products)
                // or just h2 elements (normal sections)
                $docsGroupNavs = $xpath->query(".//div[contains(@class, 'docs-group-nav')]", $widget);

                // If we have docs-group-nav sections, process them specially
                if ($docsGroupNavs->length > 0) {
                    foreach ($docsGroupNavs as $groupNav) {
                        $heading = $xpath->query(".//h2", $groupNav);
                        if ($heading->length > 0) {
                            $section = [
                                'heading' => trim($heading->item(0)->textContent),
                                'links' => [],
                                'type' => 'related-products'
                            ];

                            $paragraphs = $xpath->query(".//p[a]", $groupNav);
                            foreach ($paragraphs as $p) {
                                $linkNode = $xpath->query(".//a", $p)->item(0);
                                if ($linkNode) {
                                    $fullText = trim($p->textContent);
                                    $linkText = trim($linkNode->textContent);
                                    $icon = trim(str_replace($linkText, '', $fullText));
                                    // Remove nbsp and other whitespace from icon
                                    $icon = preg_replace('/[\x{00A0}\s]+/u', '', $icon);

                                    $url = $linkNode->getAttribute('href');
                                    if (strpos($url, 'https://electricks.info') === 0) {
                                        $url = str_replace('https://electricks.info', '', $url);
                                    }
                                    $url = $this->normalizeUrl($url);

                                    $linkData = [
                                        'icon' => $icon ?: '📃',
                                        'text' => $linkText,
                                        'url' => $url
                                    ];

                                    $section['links'][] = $linkData;
                                }
                            }

                            if (!empty($section['links'])) {
                                $sidebarData['sections'][] = $section;
                            }
                        }
                    }
                }

                // Now process remaining h2 sections (normal sections not in docs-group-nav)
                $currentSection = null;
                $elements = $xpath->query(".//h2 | .//p[a]", $widget);

                foreach ($elements as $elem) {
                    // Skip if this element is inside a docs-group-nav (already processed)
                    $parentGroupNav = $xpath->query("ancestor::div[contains(@class, 'docs-group-nav')]", $elem);
                    if ($parentGroupNav->length > 0) {
                        continue;
                    }

                    if ($elem->nodeName === 'h2') {
                        if ($currentSection) {
                            $sidebarData['sections'][] = $currentSection;
                        }

                        $currentSection = [
                            'heading' => trim($elem->textContent),
                            'links' => [],
                            'type' => 'normal'
                        ];
                    } elseif ($elem->nodeName === 'p' && $currentSection) {
                        $linkNodes = $xpath->query(".//a", $elem);
                        if ($linkNodes->length > 0) {
                            $linkNode = $linkNodes->item(0);
                            $fullText = trim($elem->textContent);
                            $linkText = trim($linkNode->textContent);
                            $icon = trim(str_replace($linkText, '', $fullText));
                            // Remove nbsp and other whitespace from icon
                            $icon = preg_replace('/[\x{00A0}\s]+/u', '', $icon);

                            $url = $linkNode->getAttribute('href');
                            // Convert to relative URL
                            if (strpos($url, 'https://electricks.info') === 0) {
                                $url = str_replace('https://electricks.info', '', $url);
                            }
                            $url = $this->normalizeUrl($url);

                            $linkData = [
                                'icon' => $icon ?: '📃',
                                'text' => $linkText,
                                'url' => $url
                            ];

                            // Check for highlight
                            $style = $elem->getAttribute('style');
                            if (stripos($style, 'background') !== false &&
                                (stripos($style, 'orange') !== false || stripos($style, '255') !== false)) {
                                $linkData['highlight'] = true;
                            }

                            $currentSection['links'][] = $linkData;
                        }
                    }
                }

                if ($currentSection) {
                    $sidebarData['sections'][] = $currentSection;
                }

                if (!empty($sidebarData['sections'])) {
                    $sidebars[$dataId] = $sidebarData;
                }
            }
        }

        return $sidebars;
    }

    /**
     * Save sidebars to JSON file
     */
    private function saveSidebars($sidebars) {
        $existing = [];
        if (file_exists($this->sidebarsFile)) {
            $existing = json_decode(file_get_contents($this->sidebarsFile), true) ?: [];
        }

        $merged = array_merge($existing, $sidebars);
        file_put_contents($this->sidebarsFile, json_encode($merged, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        echo "\n✅ Saved " . count($sidebars) . " sidebars to sidebars.json\n";
    }

    /**
     * Add sidebar metadata to markdown files
     */
    private function addSidebarsToMarkdownFiles() {
        echo "\n=== Adding Sidebar Metadata to Markdown Files ===\n\n";

        $sidebarToProducts = [];
        foreach ($this->navigationStructure['sidebars'] as $product => $sidebarData) {
            if (isset($sidebarData['sidebars'])) {
                foreach ($sidebarData['sidebars'] as $sidebarId => $structure) {
                    if (!isset($sidebarToProducts[$sidebarId])) {
                        $sidebarToProducts[$sidebarId] = [];
                    }
                    $sidebarToProducts[$sidebarId][] = $product;
                }
            }
        }

        foreach ($sidebarToProducts as $sidebarId => $products) {
            echo "Sidebar $sidebarId: " . implode(', ', $products) . "\n";
            foreach ($products as $product) {
                $updated = $this->addSidebarToProduct($product, $sidebarId);
                $this->stats['files_updated'] += $updated;
            }
        }
    }

    /**
     * Add sidebar to all files in a product
     */
    private function addSidebarToProduct($product, $sidebarId) {
        $updated = 0;

        // Main file
        $mainFile = "{$this->contentDir}/$product.md";
        if (file_exists($mainFile) && $this->addSidebarToFile($mainFile, $sidebarId)) {
            echo "  ✅ $product.md\n";
            $updated++;
        }

        // Subdirectory files
        $productDir = "{$this->contentDir}/$product";
        if (is_dir($productDir)) {
            $files = glob("$productDir/*.md");
            foreach ($files as $file) {
                if ($this->addSidebarToFile($file, $sidebarId)) {
                    echo "  ✅ $product/" . basename($file) . "\n";
                    $updated++;
                }
            }

            // Nested subdirectories
            $subdirs = glob("$productDir/*", GLOB_ONLYDIR);
            foreach ($subdirs as $subdir) {
                $subfiles = glob("$subdir/*.md");
                foreach ($subfiles as $file) {
                    if ($this->addSidebarToFile($file, $sidebarId)) {
                        $relativePath = str_replace($this->contentDir . '/', '', $file);
                        echo "  ✅ $relativePath\n";
                        $updated++;
                    }
                }
            }
        }

        return $updated;
    }

    /**
     * Add sidebar metadata to a single file
     */
    private function addSidebarToFile($filepath, $sidebarId) {
        $content = file_get_contents($filepath);

        if (preg_match('/^sidebar:/m', $content)) {
            return false; // Already has sidebar
        }

        if (!preg_match('/^---\n/', $content)) {
            return false; // No frontmatter
        }

        // Match frontmatter block and add sidebar before closing ---
        $content = preg_replace(
            '/^(---\n.*?)\n(---\n)/s',
            "$1\nsidebar: \"$sidebarId\"\n$2",
            $content,
            1
        );

        file_put_contents($filepath, $content);
        return true;
    }

    /**
     * Fetch page content
     */
    private function fetchPage($url) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Electricks-Crawler/2.0');
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $html = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return ($httpCode === 200) ? $html : false;
    }

    /**
     * Build markdown file with frontmatter
     */
    private function buildMarkdownFile($title, $content, $metadata) {
        $frontmatter = "---\n";
        foreach ($metadata as $key => $value) {
            $value = $this->escapeFrontmatterValue($value);
            $frontmatter .= "$key: $value\n";
        }
        $frontmatter .= "---\n\n";

        return $frontmatter . "# $title\n\n" . $content;
    }

    /**
     * Escape frontmatter value
     */
    private function escapeFrontmatterValue($value) {
        if (preg_match('/[:\{\}\[\],&\*#\?|\-<>=!%@`]/', $value)) {
            return '"' . str_replace('"', '\\"', $value) . '"';
        }
        return $value;
    }

    /**
     * Print statistics
     */
    private function printStats() {
        echo "\n=== Crawl Complete ===\n";
        echo "Pages crawled: {$this->stats['pages']}\n";
        echo "Sidebars extracted: {$this->stats['sidebars']}\n";
        echo "Markdown files updated: {$this->stats['files_updated']}\n";
        echo "Errors: {$this->stats['errors']}\n";
    }
}

// Parse command line arguments
$options = [];
$mode = 'all';

foreach (array_slice($argv, 1) as $arg) {
    if ($arg === '--help') {
        echo "Electricks Documentation Crawler\n\n";
        echo "Usage: php crawl-docs.php [options]\n\n";
        echo "Options:\n";
        echo "  --docs-only        Only crawl documentation content\n";
        echo "  --sidebars-only    Only extract sidebars\n";
        echo "  --dry-run          Show what would be done\n";
        echo "  --help             Show this help\n\n";
        exit(0);
    }

    if ($arg === '--docs-only') $mode = 'docs';
    if ($arg === '--sidebars-only') $mode = 'sidebars';
    if ($arg === '--dry-run') $options['dry-run'] = true;
}

// Run crawler
$crawler = new ElectricksDocsCrawler($options);
$crawler->run($mode);
