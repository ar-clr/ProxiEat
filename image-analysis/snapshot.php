<?php

declare(strict_types=1);

header('Content-Type: application/json');

require_once __DIR__ . '/config/config.php';

/**
 * Send JSON response and terminate.
 */
function jsonResponse(bool $success, string $message, array $data = []): void
{
    echo json_encode(array_merge([
        'success' => $success,
        'message' => $message
    ], $data));

    exit;
}

/**
 * Only allow POST requests.
 */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);

    jsonResponse(
        false,
        'Method Not Allowed.'
    );
}

/**
 * Ensure uploads folder exists.
 */
if (!is_dir(UPLOAD_PATH)) {

    if (!mkdir(UPLOAD_PATH, 0777, true)) {

        jsonResponse(
            false,
            'Unable to create uploads directory.'
        );
    }

}

/**
 * Generate filename.
 */
$timestamp = date('Ymd_His');

$filename = "capture_{$timestamp}.jpg";

$filepath = UPLOAD_PATH . $filename;

$latestPath = LATEST_IMAGE;

/**
 * Capture image from ESP32.
 */
$context = stream_context_create([
    'http' => [
        'timeout' => 10
    ]
]);

$image = @file_get_contents(
    ESP32_CAPTURE,
    false,
    $context
);

if ($image === false) {

    jsonResponse(
        false,
        'Unable to connect to the ESP32 camera.'
    );

}

/**
 * Save timestamped image.
 */
if (!file_put_contents($filepath, $image)) {

    jsonResponse(
        false,
        'Failed to save captured image.'
    );

}

/**
 * Update latest.jpg
 */
if (!copy($filepath, $latestPath)) {

    jsonResponse(
        false,
        'Failed to update latest image.'
    );

}

/**
 * Success
 */
jsonResponse(
    true,
    'Image captured successfully.',
    [
        'filename'  => $filename,
        'image'     => 'uploads/latest.jpg?' . time(),
        'timestamp' => date('Y-m-d H:i:s')
    ]
);