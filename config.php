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

// Navigation Structure - Auto-generated from content
// To regenerate: php scripts/generate-navigation.php > config-navigation-generated.php
// Then copy the $NAVIGATION array from that file here
require_once __DIR__ . '/config-navigation-generated.php';

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
