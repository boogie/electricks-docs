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
    private $sidebarOverrides = [];
    private $sidebarBaseIndex = [];
    private $usedSidebarIds = [];

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

        $overridesPath = __DIR__ . '/../config/sidebar-overrides.php';
        if (file_exists($overridesPath)) {
            $overrides = require $overridesPath;
            if (is_array($overrides)) {
                $this->sidebarOverrides = $overrides;
            }
        }
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
        } elseif ($mode === 'local-sidebars') {
            $this->generateLocalSidebarsOnly();
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
    public function extractPage($html, $product, $url, $slug = null) {
        $dom = new DOMDocument();
        @$dom->loadHTML($html);
        $xpath = new DOMXPath($dom);

        // Extract title
        $titleNodes = $xpath->query("//h1[@class='entry-title'] | //h1");
        $title = $titleNodes->length > 0 ? trim($titleNodes->item(0)->textContent) : ucwords(str_replace('-', ' ', $slug ?? $product));

        // Extract main content - try entry-content first, then Elementor wp-page content
        $contentNodes = $xpath->query("//div[contains(@class, 'entry-content')] | //div[@data-elementor-type='wp-page'] | //article");
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

        // Remove only Elementor container/wrapper divs, keep content
        // Use DOMDocument to properly handle nested structure
        $tempDom = new DOMDocument();
        @$tempDom->loadHTML('<?xml encoding="UTF-8">' . $html);
        $tempXpath = new DOMXPath($tempDom);

        // Remove sidebar navigation widgets - these are the specific Elementor widgets used for sidebars
        $elementsToRemove = $tempXpath->query("
            //div[contains(@class, 'elementor-background-overlay')] |
            //div[contains(@class, 'elementor-shape')] |
            //div[contains(@class, 'swiper-pagination')] |
            //div[contains(@data-widget_type, 'reviews')] |
            //div[contains(@class, 'elementor-widget-nav-menu')] |
            //div[contains(@class, 'elementor-widget-ekit-nav-menu')] |
            //div[contains(@class, 'elementor-widget-shortcode') and @data-id] |
            //div[contains(@data-widget_type, 'nav-menu')] |
            //div[contains(@data-widget_type, 'ekit-nav-menu')]
        ");

        foreach ($elementsToRemove as $element) {
            if ($element->parentNode) {
                $element->parentNode->removeChild($element);
            }
        }

        $html = $tempDom->saveHTML();

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

        // Convert code blocks (pre/code tags and standalone pre tags)
        $html = preg_replace_callback('/<pre[^>]*><code[^>]*>(.*?)<\/code><\/pre>/is', function($matches) {
            $code = html_entity_decode($matches[1], ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $code = strip_tags($code);
            return "\n\n```javascript\n" . $code . "\n```\n\n";
        }, $html);

        // Also handle standalone <pre> tags without <code>
        $html = preg_replace_callback('/<pre[^>]*>(.*?)<\/pre>/is', function($matches) {
            $code = html_entity_decode($matches[1], ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $code = strip_tags($code);
            $code = trim($code);
            // Only create code block if there's actual content
            if (strlen($code) > 0) {
                return "\n\n```javascript\n" . $code . "\n```\n\n";
            }
            return '';
        }, $html);

        // Convert inline code
        $html = preg_replace('/<code[^>]*>(.*?)<\/code>/is', "`$1`", $html);

        // Convert kbd tags to markdown format [kbd:TEXT]
        $html = preg_replace('/<kbd[^>]*>(.*?)<\/kbd>/is', "[kbd:$1]", $html);

        // Convert linked images FIRST (before standalone images and links)
        // Pattern: <a href="URL"><img src="..." alt="..."></a>
        $html = preg_replace_callback('/<a\s+href="([^"]*)"\s*[^>]*>\s*<img[^>]*>\s*<\/a>/is', function($matches) {
            $linkUrl = $matches[1];
            $imgTag = $matches[0];

            // Extract image src
            if (!preg_match('/src="([^"]+)"/i', $imgTag, $srcMatch)) {
                return '';
            }
            $src = $srcMatch[1];

            // Skip data URIs
            if (strpos($src, 'data:') === 0) {
                return '';
            }

            // Extract alt text
            $alt = '';
            if (preg_match('/alt="([^"]*)"/i', $imgTag, $altMatch)) {
                $alt = $altMatch[1];
            }

            // Return linked image on a single line to prevent parsing issues
            return "\n\n[![$alt]($src)]($linkUrl)\n\n";
        }, $html);

        // Convert images - ensure proper spacing and alt text
        $html = preg_replace_callback('/<img[^>]*>/i', function($matches) {
            $img = $matches[0];
            // Extract src
            if (!preg_match('/src="([^"]+)"/i', $img, $srcMatch)) {
                return '';
            }
            $src = $srcMatch[1];

            // Skip data URIs (SVG placeholders, etc.)
            if (strpos($src, 'data:') === 0) {
                return '';
            }

            // Extract alt text
            $alt = '';
            if (preg_match('/alt="([^"]*)"/i', $img, $altMatch)) {
                $alt = $altMatch[1];
            }

            return "\n\n![$alt]($src)\n\n";
        }, $html);

        // Convert YouTube embeds to simple markdown format (let parser handle embedding)
        // Handle Elementor video widgets with data-settings containing youtube_url
        // Note: DOMDocument converts data-settings=" to data-settings=' when content has quotes
        $html = preg_replace_callback(
            '/<div[^>]*class=["\']?[^"\']*elementor-widget-video[^"\']*["\']?[^>]*data-settings=(["\'])(.*?)\1[^>]*>.*?<\/div>/is',
            function($matches) {
                // $matches[1] is the quote character (' or "), $matches[2] is the content
                $settings = html_entity_decode($matches[2], ENT_QUOTES);
                // Unescape JSON forward slashes: \/ -> /
                $settings = str_replace('\/', '/', $settings);

                // Extract YouTube video ID from all possible URL formats
                // Support youtube.com, m.youtube.com, youtu.be, youtube-nocookie.com
                // Support watch, watch/, v/, embed/, shorts/, live/, attribution_link, oembed

                // Pattern 1: youtube.com/watch?v=ID or youtube.com/watch?feature=...&v=ID
                if (preg_match('/(?:m\.)?youtube\.com\/watch(?:\/)?(?:\?|.*&)v=([a-zA-Z0-9_-]+)/', $settings, $videoMatch)) {
                    return "\n\n[youtube:" . $videoMatch[1] . "]\n\n";
                }
                // Pattern 2: youtube.com/watch/ID (without query params)
                if (preg_match('/(?:m\.)?youtube\.com\/watch\/([a-zA-Z0-9_-]+)/', $settings, $videoMatch)) {
                    return "\n\n[youtube:" . $videoMatch[1] . "]\n\n";
                }
                // Pattern 3: youtube.com/v/ID
                if (preg_match('/(?:m\.)?youtube\.com\/v\/([a-zA-Z0-9_-]+)/', $settings, $videoMatch)) {
                    return "\n\n[youtube:" . $videoMatch[1] . "]\n\n";
                }
                // Pattern 4: youtube.com/embed/ID
                if (preg_match('/(?:m\.)?youtube\.com\/embed\/([a-zA-Z0-9_-]+)/', $settings, $videoMatch)) {
                    return "\n\n[youtube:" . $videoMatch[1] . "]\n\n";
                }
                // Pattern 5: youtube.com/e/ID
                if (preg_match('/(?:m\.)?youtube\.com\/e\/([a-zA-Z0-9_-]+)/', $settings, $videoMatch)) {
                    return "\n\n[youtube:" . $videoMatch[1] . "]\n\n";
                }
                // Pattern 6: youtube.com/shorts/ID
                if (preg_match('/(?:m\.)?youtube\.com\/shorts\/([a-zA-Z0-9_-]+)/', $settings, $videoMatch)) {
                    return "\n\n[youtube:" . $videoMatch[1] . "]\n\n";
                }
                // Pattern 7: youtube.com/live/ID
                if (preg_match('/(?:m\.)?youtube\.com\/live\/([a-zA-Z0-9_-]+)/', $settings, $videoMatch)) {
                    return "\n\n[youtube:" . $videoMatch[1] . "]\n\n";
                }
                // Pattern 8: youtu.be/ID
                if (preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $settings, $videoMatch)) {
                    return "\n\n[youtube:" . $videoMatch[1] . "]\n\n";
                }
                // Pattern 9: youtube-nocookie.com/embed/ID
                if (preg_match('/youtube-nocookie\.com\/embed\/([a-zA-Z0-9_-]+)/', $settings, $videoMatch)) {
                    return "\n\n[youtube:" . $videoMatch[1] . "]\n\n";
                }
                // Pattern 10: youtube.com/attribution_link?...u=%2Fwatch%3Fv%3DID
                if (preg_match('/(?:m\.)?youtube\.com\/attribution_link\?.*u=(?:%2F|\/)?watch(?:%3F|\?)v(?:%3D|=)([a-zA-Z0-9_-]+)/', $settings, $videoMatch)) {
                    return "\n\n[youtube:" . $videoMatch[1] . "]\n\n";
                }
                // Pattern 11: youtube.com/oembed?url=...watch?v=ID
                if (preg_match('/(?:m\.)?youtube\.com\/oembed\?.*v(?:%3D|=)([a-zA-Z0-9_-]+)/', $settings, $videoMatch)) {
                    return "\n\n[youtube:" . $videoMatch[1] . "]\n\n";
                }
                return $matches[0];
            },
            $html
        );

        // Handle youtube.com/embed/ iframe format
        $html = preg_replace(
            '/<iframe[^>]*youtube(?:-nocookie)?\.com\/embed\/([a-zA-Z0-9_-]+)[^>]*>.*?<\/iframe>/is',
            "\n\n[youtube:$1]\n\n",
            $html
        );

        // Convert Elementor alert widgets to markdown format
        // Supports: elementor-alert-info, elementor-alert-success, elementor-alert-warning, elementor-alert-danger
        $html = preg_replace_callback(
            '/<div[^>]*class="[^"]*elementor-alert-(info|success|warning|danger)[^"]*"[^>]*>.*?<div class="elementor-alert"[^>]*>.*?<\/div>.*?<\/div>/is',
            function($matches) {
                $type = $matches[1];
                $alertHtml = $matches[0];

                // Extract title
                $title = '';
                if (preg_match('/<span class="elementor-alert-title"[^>]*>(.*?)<\/span>/is', $alertHtml, $titleMatch)) {
                    $title = strip_tags($titleMatch[1]);
                    $title = html_entity_decode($title, ENT_QUOTES);
                    $title = trim($title);
                }

                // Extract description
                $description = '';
                if (preg_match('/<span class="elementor-alert-description"[^>]*>(.*?)<\/span>/is', $alertHtml, $descMatch)) {
                    $description = $descMatch[1];
                    // Convert links to markdown
                    $description = preg_replace('/<a[^>]+href="([^"]+)"[^>]*>(.*?)<\/a>/is', '[$2]($1)', $description);
                    $description = strip_tags($description);
                    $description = html_entity_decode($description, ENT_QUOTES);
                    $description = trim($description);
                }

                // Build markdown alert
                $markdown = "\n\n[alert:$type]";
                if (!empty($title)) {
                    $markdown .= $title;
                }
                if (!empty($description)) {
                    if (!empty($title)) {
                        $markdown .= '|';
                    }
                    $markdown .= $description;
                }
                $markdown .= "[/alert]\n\n";

                return $markdown;
            },
            $html
        );

        // Handle lazy-loaded YouTube players with data-id attribute
        $html = preg_replace(
            '/<div[^>]*class="[^"]*rll-youtube-player[^"]*"[^>]*data-id="([a-zA-Z0-9_-]+)"[^>]*>.*?<\/div>/is',
            "\n\n[youtube:$1]\n\n",
            $html
        );

        // Handle youtu.be short URLs in links
        $html = preg_replace(
            '/https?:\/\/youtu\.be\/([a-zA-Z0-9_-]+)/',
            "\n\n[youtube:$1]\n\n",
            $html
        );

        // Convert headings
        $html = preg_replace('/<h1[^>]*>(.*?)<\/h1>/is', "# $1\n\n", $html);
        $html = preg_replace('/<h2[^>]*>(.*?)<\/h2>/is', "## $1\n\n", $html);
        $html = preg_replace('/<h3[^>]*>(.*?)<\/h3>/is', "### $1\n\n", $html);
        $html = preg_replace('/<h4[^>]*>(.*?)<\/h4>/is', "#### $1\n\n", $html);

        // Convert text formatting - add spaces around markers to prevent merging
        $html = preg_replace_callback('/<strong[^>]*>(.*?)<\/strong>/is', function($m) {
            $content = trim($m[1]);
            return $content ? ' **' . $content . '** ' : '';
        }, $html);
        $html = preg_replace_callback('/<b[^>]*>(.*?)<\/b>/is', function($m) {
            $content = trim($m[1]);
            return $content ? ' **' . $content . '** ' : '';
        }, $html);
        $html = preg_replace_callback('/<em[^>]*>(.*?)<\/em>/is', function($m) {
            $content = trim($m[1]);
            return $content ? ' *' . $content . '* ' : '';
        }, $html);
        $html = preg_replace_callback('/<i[^>]*>(.*?)<\/i>/is', function($m) {
            $content = trim($m[1]);
            return $content ? ' *' . $content . '* ' : '';
        }, $html);

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

        // Clean up incomplete markdown formatting (e.g., ** with no content or closing)
        $html = preg_replace('/\*\*\s*\*\*/', '', $html);  // Remove empty bold markers
        $html = preg_replace('/\*\s*\*/', '', $html);      // Remove empty italic markers
        $html = preg_replace('/\*\*\s*\n/', '', $html);    // Remove ** on its own line
        $html = preg_replace('/\*\*\s*$/', '', $html);     // Remove trailing **

        // Clean up whitespace while preserving paragraph structure
        // First pass: remove empty lines and excessive newlines
        $html = preg_replace('/\n\s*\n\s*\n+/', "\n\n", $html);  // Max 2 newlines with any whitespace
        $html = preg_replace('/[ \t]{2,}/', ' ', $html);          // Multiple spaces to single space
        $html = preg_replace('/ +\n/', "\n", $html);              // Remove trailing spaces before newlines
        $html = preg_replace('/\n +/', "\n", $html);              // Remove leading spaces after newlines

        // Second pass: clean up any remaining excessive whitespace
        $lines = explode("\n", $html);
        $cleanedLines = [];
        $emptyLineCount = 0;

        foreach ($lines as $line) {
            $trimmedLine = trim($line);

            if ($trimmedLine === '') {
                $emptyLineCount++;
                // Only allow one empty line in a row
                if ($emptyLineCount === 1) {
                    $cleanedLines[] = '';
                }
            } else {
                $emptyLineCount = 0;
                $cleanedLines[] = $line;
            }
        }

        $html = implode("\n", $cleanedLines);
        $html = trim($html);

        // Decode HTML entities
        $html = html_entity_decode($html, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        // Remove duplicate h1 headings - keep only the first one
        $lines = explode("\n", $html);
        $h1Found = false;
        $lastH1Text = '';
        $filteredLines = [];
        foreach ($lines as $line) {
            if (preg_match('/^#\s+(.+)$/', $line, $matches)) {
                $h1Text = trim($matches[1]);
                if ($h1Found && $h1Text === $lastH1Text) {
                    continue;  // Skip duplicate h1 with same text
                }
                $h1Found = true;
                $lastH1Text = $h1Text;
            }
            $filteredLines[] = $line;
        }
        $html = implode("\n", $filteredLines);

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
                $registeredSidebars = [];

                foreach ($sidebars as $sidebarId => $sidebarData) {
                    if (empty($sidebarData['name'])) {
                        $sidebarData['name'] = ucwords(str_replace('-', ' ', $product)) . ' Sidebar';
                    }

                    [$finalId, $isNew] = $this->registerSidebarInstance(
                        $sidebarId,
                        $sidebarData,
                        $product,
                        $allSidebars
                    );

                    if (!$finalId) {
                        continue;
                    }

                    if ($isNew) {
                        echo "  ✅ Found sidebar: $finalId\n";
                    }

                    $registeredSidebars[$finalId] = $allSidebars[$finalId];
                }

                if (!empty($registeredSidebars)) {
                    $this->navigationStructure['sidebars'][$product] = [
                        'type' => 'elementor',
                        'sidebars' => $registeredSidebars
                    ];
                }
            }

            sleep(1);
        }

        $this->applySidebarOverrides($allSidebars);

        // Save sidebars
        if (!empty($allSidebars) && !$this->dryRun) {
            $this->saveSidebars($allSidebars);
            $this->addSidebarsToMarkdownFiles();
        }

        $this->stats['sidebars'] = count($allSidebars);
    }

    /**
     * Generate only local sidebar overrides (no remote crawling)
     */
    private function generateLocalSidebarsOnly() {
        echo "\n=== Applying Local Sidebar Overrides ===\n\n";

        $allSidebars = [];
        $this->applySidebarOverrides($allSidebars);

        if (!empty($allSidebars) && !$this->dryRun) {
            $this->saveSidebars($allSidebars);
            $this->addSidebarsToMarkdownFiles();
        }

        $this->stats['sidebars'] = count($allSidebars);
    }

    /**
     * Ensure sidebar IDs remain stable and apply overrides
     */
    private function applySidebarOverrides(array &$allSidebars) {
        if (empty($this->sidebarOverrides)) {
            return;
        }

        foreach ($this->sidebarOverrides as $product => $override) {
            $mode = $override['mode'] ?? 'local';

            if ($mode === 'local') {
                $sidebar = $this->generateLocalSidebar($product, $override);
                if ($sidebar) {
                    $sidebarId = (string) $sidebar['id'];
                    $allSidebars[$sidebarId] = $sidebar;
                    $this->navigationStructure['sidebars'][$product] = [
                        'type' => 'local',
                        'sidebars' => [
                            $sidebarId => $sidebar
                        ]
                    ];
                    echo "  ✅ Applied local sidebar for $product ({$sidebarId})\n";
                }
            } elseif ($mode === 'alias' && !empty($override['sidebar_id'])) {
                $sidebarId = (string) $override['sidebar_id'];
                if (isset($allSidebars[$sidebarId])) {
                    $this->navigationStructure['sidebars'][$product] = [
                        'type' => 'alias',
                        'sidebars' => [
                            $sidebarId => $allSidebars[$sidebarId]
                        ]
                    ];
                    echo "  ✅ Applied alias sidebar {$sidebarId} to $product\n";
                }
            }
        }
    }

    /**
     * Normalize sidebar array using their explicit IDs
     */
    private function normalizeSidebarsData(array $sidebars) {
        $normalized = [];

        foreach ($sidebars as $key => $sidebar) {
            if (!is_array($sidebar) || empty($sidebar['id'])) {
                continue;
            }
            $normalized[(string) $sidebar['id']] = $sidebar;
        }

        return $normalized;
    }

    /**
     * Register sidebar instance and ensure unique IDs per product/content
     */
    private function registerSidebarInstance($sidebarId, $sidebarData, $product, array &$allSidebars) {
        $hash = $this->hashSidebarData($sidebarData);

        if (!isset($this->sidebarBaseIndex[$sidebarId])) {
            $this->sidebarBaseIndex[$sidebarId] = [];
        }

        if (isset($this->sidebarBaseIndex[$sidebarId][$hash])) {
            $finalId = $this->sidebarBaseIndex[$sidebarId][$hash];
            return [$finalId, false];
        }

        $finalId = $sidebarId;
        if (!empty($this->sidebarBaseIndex[$sidebarId])) {
            $finalId = $this->generateSidebarInstanceId($sidebarId, $product);
        }

        $sidebarData['id'] = $finalId;
        $this->sidebarBaseIndex[$sidebarId][$hash] = $finalId;
        $this->usedSidebarIds[$finalId] = true;
        $allSidebars[$finalId] = $sidebarData;

        return [$finalId, true];
    }

    /**
     * Generate stable hash for sidebar sections
     */
    private function hashSidebarData($sidebarData) {
        $sections = $sidebarData['sections'] ?? [];
        return sha1(json_encode($sections, JSON_UNESCAPED_UNICODE));
    }

    /**
     * Build a unique sidebar ID when Elementor widget IDs are reused
     */
    private function generateSidebarInstanceId($baseId, $product) {
        $candidate = "{$baseId}-{$product}";
        $suffix = 1;

        while (isset($this->usedSidebarIds[$candidate])) {
            $suffix++;
            $candidate = "{$baseId}-{$product}-{$suffix}";
        }

        return $candidate;
    }

    /**
     * Build sidebar structure from local markdown content
     */
    private function generateLocalSidebar($product, $override) {
        $sidebarId = (string) ($override['sidebar_id'] ?? $product . '-sidebar');
        $name = $override['name'] ?? ucwords(str_replace('-', ' ', $product)) . ' Sidebar';

        $icons = $override['icons'] ?? [];
        $generalIcon = $icons['general'] ?? '📃';
        $routineIcon = $icons['routines'] ?? '🎞️';

        $sections = [];
        $generalLinks = [];
        $routineLinks = [];

        $mainFile = "{$this->contentDir}/$product.md";
        if (file_exists($mainFile)) {
            $generalLinks[] = [
                'icon' => $generalIcon,
                'text' => $this->getMarkdownTitle($mainFile),
                'url' => "/docs/$product"
            ];
        }

        $productDir = "{$this->contentDir}/$product";
        if (is_dir($productDir)) {
            $files = glob("$productDir/*.md");
            sort($files, SORT_NATURAL | SORT_FLAG_CASE);

            foreach ($files as $file) {
                $slug = basename($file, '.md');
                $title = $this->getMarkdownTitle($file);
                $isGeneral = $this->isGeneralSlug($slug);

                $link = [
                    'icon' => $isGeneral ? $generalIcon : $routineIcon,
                    'text' => $title,
                    'url' => "/docs/$product/$slug"
                ];

                if ($isGeneral) {
                    $generalLinks[] = $link;
                } else {
                    $routineLinks[] = $link;
                }
            }
        }

        if (!empty($generalLinks)) {
            $sections[] = [
                'heading' => $override['section_headings']['general'] ?? 'General',
                'links' => $generalLinks,
                'type' => 'normal'
            ];
        }

        if (!empty($routineLinks)) {
            $sections[] = [
                'heading' => $override['section_headings']['routines'] ?? 'Routines',
                'links' => $routineLinks,
                'type' => 'normal'
            ];
        }

        if (empty($sections)) {
            return null;
        }

        return [
            'id' => $sidebarId,
            'name' => $name,
            'sections' => $sections
        ];
    }

    /**
     * Extract title from markdown file
     */
    private function getMarkdownTitle($filepath) {
        if (!file_exists($filepath)) {
            return ucwords(str_replace('-', ' ', basename($filepath, '.md')));
        }

        $content = file_get_contents($filepath);

        if (preg_match('/^---\s*(.*?)\s*---/s', $content, $matches)) {
            $frontMatter = $matches[1];
            if (preg_match('/^title:\s*"(.*?)"/m', $frontMatter, $titleMatch)) {
                return trim($titleMatch[1]);
            }
            if (preg_match('/^title:\s*(.+)$/m', $frontMatter, $titleMatch)) {
                return trim($titleMatch[1]);
            }
        }

        if (preg_match('/^#\s+(.+)$/m', $content, $headingMatch)) {
            return trim($headingMatch[1]);
        }

        return ucwords(str_replace('-', ' ', basename($filepath, '.md')));
    }

    /**
     * Determine if slug should be grouped under general section
     */
    private function isGeneralSlug($slug) {
        $generalKeywords = [
            'faq',
            'intro',
            'introduction',
            'overview',
            'setup',
            'install',
            'installation',
            'getting-started',
            'general',
            'basics',
            'settings'
        ];

        foreach ($generalKeywords as $keyword) {
            if (strpos($slug, $keyword) !== false) {
                return true;
            }
        }

        return false;
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

        $existing = $this->normalizeSidebarsData($existing);
        $sidebars = $this->normalizeSidebarsData($sidebars);
        $merged = array_replace($existing, $sidebars);
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
        if (!preg_match('/^---\n(.*?)\n---\n/s', $content, $matches)) {
            return false; // No frontmatter
        }

        $frontMatter = $matches[1];
        $frontMatterBlock = $matches[0];
        $updatedFrontMatter = $frontMatter;

        if (preg_match('/^sidebar:\s*"?([^"\n]+)"?/m', $frontMatter, $sidebarMatch)) {
            if ($sidebarMatch[1] === $sidebarId) {
                return false; // Already set correctly
            }
            $updatedFrontMatter = preg_replace(
                '/^sidebar:\s*"?([^"\n]+)"?/m',
                'sidebar: "' . $sidebarId . '"',
                $frontMatter,
                1
            );
        } else {
            $updatedFrontMatter = rtrim($frontMatter) . "\nsidebar: \"$sidebarId\"\n";
        }

        $newFrontMatterBlock = "---\n" . rtrim($updatedFrontMatter) . "\n---\n";
        $content = substr_replace($content, $newFrontMatterBlock, 0, strlen($frontMatterBlock));

        file_put_contents($filepath, $content);
        return true;
    }

    /**
     * Fetch page content
     */
    public function fetchPage($url) {
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

        // Check if content already starts with the title as H1
        $contentStart = ltrim($content);
        if (!preg_match('/^#\s+' . preg_quote($title, '/') . '\s*\n/', $contentStart)) {
            // Title H1 not found at start, add it
            return $frontmatter . "# $title\n\n" . $content;
        }

        // Title H1 already exists at start, don't duplicate
        return $frontmatter . $content;
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
    public function printStats() {
        echo "\n=== Crawl Complete ===\n";
        echo "Pages crawled: {$this->stats['pages']}\n";
        echo "Sidebars extracted: {$this->stats['sidebars']}\n";
        echo "Markdown files updated: {$this->stats['files_updated']}\n";
        echo "Errors: {$this->stats['errors']}\n";
    }
}

// Parse command line arguments
$options = [];
$mode = 'all'; // default: crawl both docs and sidebars
$pages = []; // specific pages to crawl

foreach (array_slice($argv, 1) as $arg) {
    if ($arg === '--help') {
        echo "Electricks Documentation Crawler\n\n";
        echo "Usage: php crawl-docs.php [options]\n\n";
        echo "Options:\n";
        echo "  --docs-only        Only crawl documentation content (skip sidebars)\n";
        echo "  --sidebars-only    Only extract sidebars (skip content)\n";
        echo "  --local-sidebars-only  Only rebuild local sidebar overrides\n";
        echo "  --page=URL         Crawl a specific page (can be used multiple times)\n";
        echo "                     Examples:\n";
        echo "                       --page=peeksmith-3/glyphs\n";
        echo "                       --page=https://electricks.info/docs/peeksmith-3/cognito/\n";
        echo "  --dry-run          Show what would be done\n";
        echo "  --help             Show this help\n\n";
        exit(0);
    }

    if ($arg === '--dry-run') {
        $options['dry-run'] = true;
    } elseif ($arg === '--docs-only') {
        $mode = 'docs';
    } elseif ($arg === '--sidebars-only') {
        $mode = 'sidebars';
    } elseif ($arg === '--local-sidebars-only') {
        $mode = 'local-sidebars';
    } elseif (strpos($arg, '--page=') === 0) {
        $page = substr($arg, 7); // Remove '--page=' prefix
        // Normalize the page URL
        $page = str_replace('https://electricks.info/docs/', '', $page);
        $page = rtrim($page, '/');
        $pages[] = $page;
    }
}

// Run crawler
$crawler = new ElectricksDocsCrawler($options);

if (!empty($pages)) {
    // Crawl specific pages
    foreach ($pages as $page) {
        $parts = explode('/', $page);
        $product = $parts[0];
        $slug = isset($parts[1]) ? $page : null;

        echo "Crawling page: $page\n";
        $url = "https://electricks.info/docs/$page/";
        $html = $crawler->fetchPage($url);

        if ($html) {
            $crawler->extractPage($html, $product, $url, $slug);
        } else {
            echo "  ❌ Failed to fetch: $url\n";
        }
    }
    $crawler->printStats();
} else {
    // Run normal crawl with specified mode
    $crawler->run($mode);
}
