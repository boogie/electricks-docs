<?php
/**
 * Article Feedback API
 * Records "Was this helpful?" votes for documentation pages.
 */

header('Content-Type: application/json');

require_once __DIR__ . '/../config.php';

// Only allow POST requests
if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Parse JSON payload
$payload = json_decode(file_get_contents('php://input'), true);

if (!is_array($payload)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid payload']);
    exit;
}

$article = trim($payload['article'] ?? '');
$vote = strtolower(trim($payload['vote'] ?? ''));
$title = trim($payload['title'] ?? '');
$recordVote = $payload['record_vote'] ?? true;
$comment = isset($payload['comment']) ? trim($payload['comment']) : '';
$userId = trim($payload['user_id'] ?? '');

// Basic validation
if ($article === '' || !preg_match('/^[a-z0-9\/\-_]+$/i', $article)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid article path']);
    exit;
}

if (!in_array($vote, ['yes', 'no'], true)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid vote value']);
    exit;
}

$userIdPattern = '/^[a-zA-Z0-9:_\\-]{6,120}$/';
if ($userId === '' || !preg_match($userIdPattern, $userId)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid user identifier']);
    exit;
}

$recordVote = filter_var($recordVote, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
if ($recordVote === null) {
    $recordVote = true;
}

$comment = strip_tags($comment);
$comment = trim($comment);
if (strlen($comment) > 2000) {
    $comment = substr($comment, 0, 2000);
}

if (!$recordVote && $comment === '') {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'No details provided']);
    exit;
}

$fileHandle = null;
$lockAcquired = false;

try {
    $feedbackDir = BASE_PATH . '/storage/feedback';

    if (!is_dir($feedbackDir) && !mkdir($feedbackDir, 0775, true) && !is_dir($feedbackDir)) {
        throw new RuntimeException('Unable to create feedback directory');
    }

    $dataFile = $feedbackDir . '/article-feedback.json';

    $fileHandle = fopen($dataFile, 'c+');
    if (!$fileHandle) {
        throw new RuntimeException('Unable to open feedback store');
    }

    if (!flock($fileHandle, LOCK_EX)) {
        throw new RuntimeException('Unable to obtain feedback lock');
    }
    $lockAcquired = true;

    // Ensure we read from the beginning
    rewind($fileHandle);
    $contents = stream_get_contents($fileHandle);
    $currentData = $contents ? json_decode($contents, true) : [];

    if (!is_array($currentData)) {
        $currentData = [];
    }

    if (!isset($currentData[$article])) {
        $currentData[$article] = [
            'yes' => 0,
            'no' => 0,
            'title' => $title,
            'comments' => [],
            'responses' => []
        ];
    }

    if (!isset($currentData[$article]['comments']) || !is_array($currentData[$article]['comments'])) {
        $currentData[$article]['comments'] = [];
    }
    if (!isset($currentData[$article]['responses']) || !is_array($currentData[$article]['responses'])) {
        $currentData[$article]['responses'] = [];
    }

    $previousVote = $currentData[$article]['responses'][$userId]['vote'] ?? null;

    if ($recordVote) {
        if ($previousVote && $previousVote !== $vote) {
            if (isset($currentData[$article][$previousVote]) && $currentData[$article][$previousVote] > 0) {
                $currentData[$article][$previousVote]--;
            }
        }

        if ($previousVote !== $vote) {
            $currentData[$article][$vote] = ($currentData[$article][$vote] ?? 0) + 1;
        }

        $currentData[$article]['responses'][$userId] = [
            'vote' => $vote,
            'updated_at' => gmdate('c')
        ];
    } elseif (!isset($currentData[$article]['responses'][$userId])) {
        $currentData[$article]['responses'][$userId] = [
            'vote' => $vote,
            'updated_at' => gmdate('c')
        ];
    }

    if ($comment !== '') {
        $currentData[$article]['comments'][] = [
            'vote' => $vote,
            'comment' => $comment,
            'submitted_at' => gmdate('c'),
            'user_id' => $userId
        ];

        // Keep only the latest 100 comments per article
        if (count($currentData[$article]['comments']) > 100) {
            $currentData[$article]['comments'] = array_slice($currentData[$article]['comments'], -100);
        }
    }

    $currentData[$article]['title'] = $title ?: ($currentData[$article]['title'] ?? '');
    $currentData[$article]['updated_at'] = gmdate('c');

    // Write back to file
    rewind($fileHandle);
    ftruncate($fileHandle, 0);
    fwrite($fileHandle, json_encode($currentData, JSON_PRETTY_PRINT));
    fflush($fileHandle);

    $responseMessage = 'Thanks for the feedback!';
    if ($comment !== '' && !$recordVote) {
        $responseMessage = 'Thanks for sharing the extra context!';
    } elseif ($vote === 'no' && $comment === '') {
        $responseMessage = 'Thanks for letting us know.';
    }

    echo json_encode(['success' => true, 'message' => $responseMessage]);
} catch (Throwable $e) {
    error_log('[feedback] ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Unable to save feedback']);
} finally {
    if (isset($lockAcquired) && $lockAcquired && isset($fileHandle) && is_resource($fileHandle)) {
        flock($fileHandle, LOCK_UN);
    }
    if (isset($fileHandle) && is_resource($fileHandle)) {
        fclose($fileHandle);
    }
}
