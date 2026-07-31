<?php

declare(strict_types=1);

header('Content-Type: application/json');

require_once __DIR__ . '/config/config.php';

/**
 * Send JSON response.
 */
function jsonResponse(array $data): void
{
    echo json_encode($data);
    exit;
}

/**
 * Ensure uploads directory exists.
 */
if (!is_dir(UPLOAD_PATH)) {
    jsonResponse([]);
}

/**
 * Get all captured images.
 */
$files = glob(UPLOAD_PATH . 'capture_*.jpg');

if (!$files) {
    jsonResponse([]);
}

/**
 * Newest first.
 */
usort($files, function ($a, $b) {
    return filemtime($b) <=> filemtime($a);
});

$result = [];

foreach ($files as $file) {

    $filename = basename($file);

    $timestamp = filemtime($file);

    $result[] = [
        'id' => pathinfo($filename, PATHINFO_FILENAME),

        'filename' => $filename,

        'image' => 'uploads/' . $filename,

        'date' => date('Y-m-d', $timestamp),

        'time' => date('g:i A', $timestamp),

        // Temporary placeholder data until AI analysis is saved
        'observation' => 'AI analysis not available yet.',

        'mood' => 'Unknown',

        'confidence' => null,

        'analysis' => [
            'summary' => 'This capture has not been analyzed yet.',
            'behavior' => [],
            'visible_objects' => [],
            'environment' => [],
            'ai_notes' => [],
            'recommendations' => [],
            'confidence' => null
        ]
    ];
}

jsonResponse($result);