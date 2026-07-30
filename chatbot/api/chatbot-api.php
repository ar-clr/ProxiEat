<?php

header("Content-Type: application/json");

require_once __DIR__ . "/../services/context-builder.php";
require_once __DIR__ . "/../services/gemini-service.php";

// Read user input
$input = json_decode(file_get_contents("php://input"), true);
$message = trim($input["message"] ?? "");

if ($message === "") {
    echo json_encode([
        "text" => "No message received.",
        "model" => null,
        "suggestions" => []
    ]);
    exit;
}

// ============================================
// Load System Prompt
// ============================================

$files = glob(__DIR__ . "/prompts/*.txt");
sort($files);

$systemPrompt = "";

foreach ($files as $file) {
    $systemPrompt .= file_get_contents($file) . "\n\n";
}

// ============================================
// Build Live Context
// ============================================

$context = buildContext();

// ============================================
// Call Gemini
// ============================================

$response = callGemini(

    $systemPrompt . "\n\n" . $context,

    $message

);

// ============================================
// Return Response
// ============================================

echo json_encode([

    "text" => $response["text"],

    "model" => $response["model"],

    "success" => $response["success"],

    "suggestions" => []

]);