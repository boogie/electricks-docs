<?php
/**
 * Generate Navigation Structure from Content Directory
 *
 * This script scans the content/docs directory and generates
 * a comprehensive navigation array based on the actual files.
 */

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../includes/markdown-parser.php';

$contentDir = __DIR__ . '/../content/docs/docs';

// Product categories and their display information
$categories = [
    'peeking' => [
        'title' => 'Peeking Devices',
        'icon' => 'eye',
        'icon_color' => 'blue',
        'products' => ['peeksmith-3', 'bond', 'mrcard']
    ],
    'watches' => [
        'title' => 'Prediction Watches',
        'icon' => 'watch',
        'icon_color' => 'purple',
        'products' => ['sbwatch', 'sb-watch-2']
    ],
    'remotes' => [
        'title' => 'Remote Controls',
        'icon' => 'game-controller',
        'icon_color' => 'orange',
        'products' => ['atom-remote', 'sbmote']
    ],
    'specialty' => [
        'title' => 'Specialty Devices',
        'icon' => 'cube',
        'icon_color' => 'pink',
        'products' => ['teleport', 'quantum', 'spotted-dice', 'cubesmith', 'ghostmove', 'soulmate', 'ray']
    ],
    'audio' => [
        'title' => 'Audio Devices',
        'icon' => 'speaker-high',
        'icon_color' => 'teal',
        'products' => ['vision', 'mental-wave']
    ],
    'cards' => [
        'title' => 'Cards & NFC',
        'icon' => 'identification-card',
        'icon_color' => 'indigo',
        'products' => ['lunacards', 'nfc-rfid', 'espyon-nfc-rfid-reader']
    ],
    'apps' => [
        'title' => 'Mobile Apps',
        'icon' => 'device-mobile',
        'icon_color' => 'green',
        'products' => ['peeksmith-app', 'timesmith-app', 'dicesmith-app', 'scalesmith-app', 'magiscript']
    ]
];

// Product display names
$productNames = [
    'peeksmith-3' => 'PeekSmith 3',
    'bond' => 'Electricks Bond',
    'mrcard' => 'Electricks MrCard',
    'sbwatch' => 'SB Watch',
    'sb-watch-2' => 'SB Watch 2',
    'atom-remote' => 'Atom Smart Remote',
    'sbmote' => 'SB Mote',
    'teleport' => 'Electricks Teleport',
    'quantum' => 'Quantum Calculator',
    'spotted-dice' => 'Spotted Dice',
    'cubesmith' => 'CubeSmith',
    'ghostmove' => 'GhostMove',
    'soulmate' => 'SoulMate Smart Scale',
    'ray' => 'Ray Magnet Sensor',
    'vision' => 'Vision Glasses',
    'mental-wave' => 'Mental Wave',
    'lunacards' => 'Luna Cards',
    'nfc-rfid' => 'NFC/RFID',
    'espyon-nfc-rfid-reader' => 'Espyon NFC/RFID Reader',
    'peeksmith-app' => 'PeekSmith App',
    'timesmith-app' => 'TimeSmith App',
    'dicesmith-app' => 'DiceSmith App',
    'scalesmith-app' => 'ScaleSmith App',
    'magiscript' => 'MagiScript'
];

/**
 * Get title from markdown file's frontmatter or first heading
 */
function getTitleFromFile($filePath) {
    if (!file_exists($filePath)) {
        return null;
    }

    $frontMatter = ElectricksMarkdownParser::extractFrontMatter($filePath);
    if (isset($frontMatter['title'])) {
        return $frontMatter['title'];
    }

    // Try to extract from first heading
    $content = file_get_contents($filePath);
    if (preg_match('/^#\s+(.+)$/m', $content, $matches)) {
        return trim($matches[1]);
    }

    return null;
}

/**
 * Convert filename to readable title
 */
function fileToTitle($filename) {
    // Remove .md extension
    $title = str_replace('.md', '', $filename);

    // Convert hyphens and underscores to spaces
    $title = str_replace(['-', '_'], ' ', $title);

    // Capitalize words
    $title = ucwords($title);

    // Handle special cases
    $title = str_replace('Nfc', 'NFC', $title);
    $title = str_replace('Rfid', 'RFID', $title);
    $title = str_replace('Api', 'API', $title);
    $title = str_replace('Ocr', 'OCR', $title);
    $title = str_replace('Faq', 'FAQ', $title);
    $title = str_replace('Sb ', 'SB ', $title);
    $title = str_replace('A I', 'A.I.', $title);

    return $title;
}

/**
 * Categorize pages into groups
 */
function categorizePages($items, $productSlug) {
    $groups = [
        'overview' => [],
        'general' => [],
        'features' => [],
        'compatibility' => [],
        'accessories' => [],
        'other' => []
    ];

    // Keywords for categorization
    $generalKeywords = ['first-steps', 'getting-started', 'troubleshooting', 'faq', 'specifications', 'specs', 'firmware', 'roadmap', 'battery'];
    $compatibilityKeywords = ['peeksmith-app', 'timesmith', 'dicesmith', 'scalesmith', 'magiscript', 'iarvel', 'sb-watch', 'atom', 'settings'];
    $accessoryKeywords = ['case', 'holder', 'stand', 'strap', 'band', 'wallet', 'notebook', 'badge'];
    $featureKeywords = ['mode', 'screen', 'audio', 'bluetooth', 'nfc', 'rfid', 'web', 'api', 'multi'];

    foreach ($items as $slug => $title) {
        $lowerSlug = strtolower($slug);
        $lowerTitle = strtolower($title);

        // Main product page goes to overview
        if ($slug === $productSlug) {
            $groups['overview'][$slug] = $title;
            continue;
        }

        // Categorize based on keywords
        $categorized = false;

        foreach ($generalKeywords as $keyword) {
            if (strpos($lowerSlug, $keyword) !== false || strpos($lowerTitle, $keyword) !== false) {
                $groups['general'][$slug] = $title;
                $categorized = true;
                break;
            }
        }

        if (!$categorized) {
            foreach ($compatibilityKeywords as $keyword) {
                if (strpos($lowerSlug, $keyword) !== false || strpos($lowerTitle, $keyword) !== false) {
                    $groups['compatibility'][$slug] = $title;
                    $categorized = true;
                    break;
                }
            }
        }

        if (!$categorized) {
            foreach ($accessoryKeywords as $keyword) {
                if (strpos($lowerSlug, $keyword) !== false || strpos($lowerTitle, $keyword) !== false) {
                    $groups['accessories'][$slug] = $title;
                    $categorized = true;
                    break;
                }
            }
        }

        if (!$categorized) {
            foreach ($featureKeywords as $keyword) {
                if (strpos($lowerSlug, $keyword) !== false || strpos($lowerTitle, $keyword) !== false) {
                    $groups['features'][$slug] = $title;
                    $categorized = true;
                    break;
                }
            }
        }

        // Default to "other" if not categorized
        if (!$categorized) {
            $groups['other'][$slug] = $title;
        }
    }

    // Remove empty groups
    return array_filter($groups, function($group) {
        return !empty($group);
    });
}

/**
 * Scan directory and get all markdown files with their structure
 */
function scanProductDirectory($productSlug, $baseDir) {
    $productDir = $baseDir . '/' . $productSlug;
    $items = [];

    // Get main product file
    $mainFile = $baseDir . '/' . $productSlug . '.md';
    if (file_exists($mainFile)) {
        $title = getTitleFromFile($mainFile) ?: fileToTitle($productSlug);
        $items[$productSlug] = $title;
    }

    // Get subdirectory files
    if (is_dir($productDir)) {
        $files = scandir($productDir);

        foreach ($files as $file) {
            if ($file === '.' || $file === '..') continue;

            $fullPath = $productDir . '/' . $file;

            if (is_file($fullPath) && pathinfo($file, PATHINFO_EXTENSION) === 'md') {
                $slug = pathinfo($file, PATHINFO_FILENAME);
                $title = getTitleFromFile($fullPath) ?: fileToTitle($file);
                $items[$productSlug . '/' . $slug] = $title;
            } elseif (is_dir($fullPath)) {
                // Handle subdirectories (like peeksmith-3/standalone-mode)
                $subfiles = scandir($fullPath);
                foreach ($subfiles as $subfile) {
                    if ($subfile === '.' || $subfile === '..') continue;

                    $subFullPath = $fullPath . '/' . $subfile;
                    if (is_file($subFullPath) && pathinfo($subfile, PATHINFO_EXTENSION) === 'md') {
                        $subSlug = pathinfo($subfile, PATHINFO_FILENAME);
                        $title = getTitleFromFile($subFullPath) ?: fileToTitle($subfile);
                        $items[$productSlug . '/' . $file . '/' . $subSlug] = $title;
                    }
                }
            }
        }
    }

    return $items;
}

// Generate navigation array
$navigation = [];

// Add Getting Started section
$navigation['docs'] = [
    'title' => 'Getting Started',
    'icon' => 'rocket-launch',
    'icon_color' => 'green',
    'items' => []
];

$docsMainFile = $contentDir . '/.md';
if (file_exists($docsMainFile)) {
    $navigation['docs']['items']['docs'] = 'Documentation';
}

// Add each category with its products
foreach ($categories as $categorySlug => $categoryInfo) {
    foreach ($categoryInfo['products'] as $productSlug) {
        $items = scanProductDirectory($productSlug, $contentDir);

        if (!empty($items)) {
            $productName = $productNames[$productSlug] ?? ucwords(str_replace('-', ' ', $productSlug));

            // Categorize items into groups
            $groups = categorizePages($items, $productSlug);

            $navigation['docs/' . $productSlug] = [
                'title' => $productName,
                'icon' => $categoryInfo['icon'],
                'icon_color' => $categoryInfo['icon_color'],
                'category' => $categoryInfo['title'],
                'items' => $items,  // Keep flat list for compatibility
                'groups' => $groups  // Add grouped structure
            ];
        }
    }
}

// Add Misc/Resources section
$miscItems = scanProductDirectory('misc', $contentDir);
if (!empty($miscItems)) {
    $navigation['docs/misc'] = [
        'title' => 'Guides & Resources',
        'icon' => 'book-open',
        'icon_color' => 'indigo',
        'items' => $miscItems
    ];
}

// Output the navigation array as PHP code
echo "<?php\n";
echo "/**\n";
echo " * Auto-generated Navigation Structure\n";
echo " * Generated on: " . date('Y-m-d H:i:s') . "\n";
echo " * Total sections: " . count($navigation) . "\n";
echo " */\n\n";
echo "\$NAVIGATION = " . var_export($navigation, true) . ";\n";
