<?php
/**
 * Search API Endpoint
 * Provides JSON response for documentation search
 */

header('Content-Type: application/json');

require_once __DIR__ . '/../config.php';

// Get search query
$query = isset($_GET['q']) ? trim($_GET['q']) : '';

if (empty($query) || strlen($query) < 2) {
    echo json_encode(['results' => []]);
    exit;
}

// Simple file-based search (no database required)
$results = searchDocumentation($query);

echo json_encode(['results' => $results]);

/**
 * Search through documentation files
 */
function searchDocumentation($query) {
    $query = strtolower($query);
    $results = [];

    // Get all markdown files
    $files = glob(CONTENT_PATH . '/**/*.md', GLOB_BRACE);

    foreach ($files as $file) {
        $content = file_get_contents($file);
        $contentLower = strtolower($content);

        // Check if query appears in file
        if (strpos($contentLower, $query) !== false) {
            // Extract title (first # heading)
            preg_match('/^#\s+(.+)$/m', $content, $titleMatch);
            $title = isset($titleMatch[1]) ? trim($titleMatch[1]) : basename($file, '.md');

            // Get relative path
            $relativePath = str_replace(CONTENT_PATH . '/', '', $file);
            $relativePath = str_replace('.md', '', $relativePath);

            // Extract excerpt around match
            $excerpt = extractExcerpt($content, $query);

            // Calculate relevance score
            $titleRelevance = stripos($title, $query) !== false ? 100 : 0;
            $excerptRelevance = substr_count($contentLower, $query) * 10;
            $score = $titleRelevance + $excerptRelevance;

            $results[] = [
                'title' => $title,
                'path' => $relativePath,
                'url' => '/docs/' . $relativePath,
                'excerpt' => $excerpt,
                'score' => $score
            ];
        }
    }

    // Sort by relevance
    usort($results, function($a, $b) {
        return $b['score'] - $a['score'];
    });

    // Limit to top 10 results
    return array_slice($results, 0, 10);
}

/**
 * Extract excerpt around search term
 */
function extractExcerpt($content, $query, $length = 150) {
    // Remove markdown syntax for cleaner excerpts
    $content = preg_replace('/^#+\s+/m', '', $content);
    $content = preg_replace('/\[([^\]]+)\]\([^\)]+\)/', '$1', $content);
    $content = preg_replace('/`([^`]+)`/', '$1', $content);

    $contentLower = strtolower($content);
    $pos = strpos($contentLower, strtolower($query));

    if ($pos === false) {
        // Return first 150 characters if query not found
        return substr($content, 0, $length) . '...';
    }

    // Extract text around the match
    $start = max(0, $pos - 50);
    $excerpt = substr($content, $start, $length);

    // Clean up
    $excerpt = trim($excerpt);

    // Add ellipsis
    if ($start > 0) {
        $excerpt = '...' . $excerpt;
    }
    if (strlen($content) > $start + $length) {
        $excerpt .= '...';
    }

    // Highlight the search term
    $excerpt = preg_replace('/(' . preg_quote($query, '/') . ')/i', '<mark>$1</mark>', $excerpt);

    return $excerpt;
}
