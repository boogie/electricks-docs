<?php
/**
 * Router for PHP Built-in Web Server
 * Usage: php -S localhost:8080 router.php
 */

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Serve static assets directly
if (preg_match('/\.(?:css|js|png|jpg|jpeg|gif|svg|woff|woff2|ttf|eot|ico)$/', $uri)) {
    return false; // Serve the file as-is
}

// Route API requests
if (strpos($uri, '/api/') === 0) {
    $apiFile = __DIR__ . $uri . '.php';
    if (file_exists($apiFile)) {
        require $apiFile;
        exit;
    }
    http_response_code(404);
    echo json_encode(['error' => 'API endpoint not found']);
    exit;
}

// Route documentation pages
if (strpos($uri, '/docs/') === 0) {
    $_GET['path'] = substr($uri, 6); // Remove '/docs/' prefix
    require __DIR__ . '/docs.php';
    exit;
}

// Route homepage
if ($uri === '/' || $uri === '/index.php') {
    require __DIR__ . '/index.php';
    exit;
}

// Try to find a matching PHP file
$file = __DIR__ . $uri;
if (is_dir($file) && file_exists($file . '/index.php')) {
    require $file . '/index.php';
    exit;
}
if (file_exists($file . '.php')) {
    require $file . '.php';
    exit;
}

// 404
http_response_code(404);
require __DIR__ . '/index.php';
