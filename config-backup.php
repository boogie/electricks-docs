<?php
/**
 * Electricks Help Portal Configuration
 */

// Site Configuration
define('SITE_TITLE', 'Electricks Help Center');
define('SITE_URL', 'https://help.electricks.info');
define('BASE_PATH', __DIR__);
define('CONTENT_PATH', BASE_PATH . '/content/docs');

// Asset Versioning - Update this when you release changes
define('ASSET_VERSION', '1.0.0');

// Database Configuration (for search indexing - optional)
define('DB_HOST', 'localhost');
define('DB_NAME', 'electricks_help');
define('DB_USER', 'your_db_user');
define('DB_PASS', 'your_db_password');

// Feature Flags
define('ENABLE_SEARCH', true);
define('ENABLE_ANALYTICS', false);

// Navigation Structure - Product Documentation Categories
$NAVIGATION = [
    'getting-started' => [
        'title' => 'Getting Started',
        'description' => 'New to Electricks? Start here with setup guides.',
        'icon' => 'rocket-launch',
        'icon_color' => 'green',
        'devices' => [],
        'items' => [
            'index' => 'Overview',
            'first-time-setup' => 'First Time Setup',
            'choosing-your-device' => 'Choosing Your Device',
            'troubleshooting' => 'Quick Troubleshooting',
        ]
    ],
    'devices/peeking' => [
        'title' => 'Peeking Devices',
        'description' => 'Discreet information displays for mentalism.',
        'icon' => 'eye',
        'icon_color' => 'blue',
        'devices' => ['PeekSmith 3', 'Bond', 'MrCard'],
        'items' => [
            'peeksmith-3' => 'PeekSmith 3',
            'bond' => 'Bond',
            'mrcard' => 'MrCard',
            'superpeek' => 'SuperPeek',
            'sharpeek' => 'Sharpeek',
        ]
    ],
    'devices/watches' => [
        'title' => 'Prediction Watches',
        'description' => 'Time prediction and smart watches.',
        'icon' => 'watch',
        'icon_color' => 'purple',
        'devices' => ['SB Watch', 'SB Watch 2'],
        'items' => [
            'sb-watch' => 'SB Watch',
            'sb-watch-2' => 'SB Watch 2',
            'sb-watch-pocket' => 'SB Watch Pocket',
            'sb-watch-steel' => 'SB Watch Steel',
        ]
    ],
    'devices/remotes' => [
        'title' => 'Remote Controls',
        'description' => 'Wireless control for LED lights.',
        'icon' => 'game-controller',
        'icon_color' => 'orange',
        'devices' => ['Atom 2', 'ATC'],
        'items' => [
            'atom-smart-remote' => 'Atom Smart Remote',
            'atc-thumbtip' => 'ATC Thumbtip Remote',
            'sb-mote' => 'SB Mote',
        ]
    ],
    'devices/teleport' => [
        'title' => 'Teleport',
        'description' => 'Reality-bending prediction device.',
        'icon' => 'swap',
        'icon_color' => 'teal',
        'devices' => ['Teleport QD'],
        'items' => [
            'teleport' => 'Teleport',
        ]
    ],
    'devices/quantum' => [
        'title' => 'Quantum Calculator',
        'description' => 'Mind-reading calculation device.',
        'icon' => 'calculator',
        'icon_color' => 'indigo',
        'devices' => ['Quantum Calculator'],
        'items' => [
            'quantum' => 'Quantum Calculator',
        ]
    ],
    'devices/other' => [
        'title' => 'More Devices',
        'description' => 'Other innovative products.',
        'icon' => 'cube',
        'icon_color' => 'pink',
        'devices' => ['Spotted Dice', 'CubeSmith', 'GhostMove', 'SoulMate Scale', 'and more...'],
        'items' => [
            'spotted-dice' => 'Spotted Dice',
            'cubesmith' => 'CubeSmith',
            'ghostmove' => 'GhostMove',
            'soulmate-scale' => 'SoulMate Smart Scale',
            'ray-magnet-sensor' => 'Ray Magnet Sensor',
            'vision-glasses' => 'Vision Glasses',
            'mental-wave' => 'Mental Wave',
            'luna-cards' => 'Luna Cards',
            'nfc-rfid-cards' => 'NFC/RFID Cards',
        ]
    ],
    'apps' => [
        'title' => 'Mobile Apps',
        'description' => 'Companion apps & software.',
        'icon' => 'device-mobile',
        'icon_color' => 'teal',
        'devices' => ['MagiScript', 'PeekSmith App', 'TimeSmith', 'DiceSmith', 'ScaleSmith'],
        'items' => [
            'magiscript' => 'MagiScript',
            'peeksmith-app' => 'PeekSmith App',
            'timesmith-app' => 'TimeSmith App',
            'dicesmith-app' => 'DiceSmith App',
            'scalesmith-app' => 'ScaleSmith App',
        ]
    ],
    'guides' => [
        'title' => 'Guides & Tutorials',
        'description' => 'Learn tips and techniques.',
        'icon' => 'book-open',
        'icon_color' => 'indigo',
        'devices' => [],
        'items' => [
            'firmware-updates' => 'Firmware Updates',
            'bluetooth-pairing' => 'Bluetooth Pairing',
            'battery-care' => 'Battery Care',
            'troubleshooting-common-issues' => 'Common Issues',
        ]
    ],
    'support' => [
        'title' => 'Support',
        'description' => 'Get help and contact us.',
        'icon' => 'lifebuoy',
        'icon_color' => 'red',
        'devices' => [],
        'items' => [
            'shipping' => 'Shipping & Delivery',
            'returns' => 'Returns & Exchanges',
            'warranty' => 'Warranty Information',
            'contact' => 'Contact Us',
        ]
    ],
];

// Environment Detection
$isLocalhost = in_array($_SERVER['SERVER_NAME'] ?? '', ['localhost', '127.0.0.1', '::1'])
    || strpos($_SERVER['SERVER_NAME'] ?? '', '.local') !== false;

// Error Reporting
if ($isLocalhost) {
    // Development: Show all errors
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    // Production: Log errors, don't display
    error_reporting(E_ALL);
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
}

// Database Connection Helper
function getDB() {
    static $pdo = null;
    if ($pdo === null) {
        try {
            $pdo = new PDO(
                'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
                DB_USER,
                DB_PASS,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        } catch (PDOException $e) {
            error_log('Database connection failed: ' . $e->getMessage());
            return null;
        }
    }
    return $pdo;
}
