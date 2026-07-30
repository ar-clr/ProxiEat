<?php

declare(strict_types=1);

header('Content-Type: application/json');

require_once __DIR__ . '/../chatbot/services/gemini-service.php';

// echo "<pre>";

// echo "callGemini(): ";
// var_dump(function_exists('callGemini'));

// echo "callGeminiVision(): ";
// var_dump(function_exists('callGeminiVision'));

// exit;

$imagePath = __DIR__ . '/uploads/latest.jpg';

$promptPath = __DIR__ . '/prompts/feeding_prompt.txt';

if (!file_exists($imagePath)) {

    echo json_encode([

        "success" => false,

        "message" => "No captured image found."

    ]);

    exit;

}

$systemPrompt = file_get_contents($promptPath);

$result = callGeminiVision($systemPrompt, $imagePath);

/*
|--------------------------------------------------------------------------
| Return immediately if Gemini failed
|--------------------------------------------------------------------------
*/
if (!$result["success"]) {
    echo json_encode($result);
    exit;
}

/*
|--------------------------------------------------------------------------
| Clean Gemini response
|--------------------------------------------------------------------------
|
| Gemini sometimes wraps JSON inside:
|
| ```json
| { ... }
| ```
|
| Remove those wrappers before decoding.
|
*/

$json = trim($result["text"]);

$json = preg_replace('/^```json\s*/i', '', $json);
$json = preg_replace('/^```\s*/', '', $json);
$json = preg_replace('/\s*```$/', '', $json);

$analysis = json_decode($json, true);

/*
|--------------------------------------------------------------------------
| Validate JSON
|--------------------------------------------------------------------------
*/

if (json_last_error() !== JSON_ERROR_NONE || !is_array($analysis)) {

    echo json_encode([
        "success" => false,
        "model"   => $result["model"],
        "message" => "Gemini returned invalid JSON.",
        "raw"     => $result["text"]
    ]);

    exit;
}

/*
|--------------------------------------------------------------------------
| Default Analysis Structure
|--------------------------------------------------------------------------
|
| Ensures every expected field exists even if Gemini omits it.
|
*/

$defaults = [

    "summary" => "",

    "behavior" => [

        "estimated_mood"    => "Unable to determine",
        "body_posture"      => "Unable to determine",
        "head_position"     => "Unable to determine",
        "tail_position"     => "Unable to determine",
        "ears"              => "Unable to determine",
        "mouth"             => "Unable to determine",
        "attention"         => "Unable to determine",
        "feeding_readiness" => "Unable to determine"

    ],

    "visible_objects" => [],

    "environment" => [],

    "ai_notes" => [],

    "recommendations" => [],

    "confidence" => 0

];

/*
|--------------------------------------------------------------------------
| Merge Defaults
|--------------------------------------------------------------------------
*/

$analysis = array_replace_recursive($defaults, $analysis);

/*
|--------------------------------------------------------------------------
| Normalize Arrays
|--------------------------------------------------------------------------
*/

foreach (["visible_objects", "environment", "ai_notes", "recommendations"] as $key) {

    if (!is_array($analysis[$key])) {
        $analysis[$key] = [];
    }

}

/*
|--------------------------------------------------------------------------
| Normalize Confidence
|--------------------------------------------------------------------------
*/

$analysis["confidence"] = max(
    0,
    min(1, (float) $analysis["confidence"])
);

/*
|--------------------------------------------------------------------------
| Save Latest Analysis
|--------------------------------------------------------------------------
*/

$analysisDirectory = __DIR__ . '/analysis';

if (!is_dir($analysisDirectory)) {
    mkdir($analysisDirectory, 0777, true);
}

file_put_contents(
    $analysisDirectory . '/latest.json',
    json_encode($analysis, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
);

/*
|--------------------------------------------------------------------------
| Return Response
|--------------------------------------------------------------------------
*/

echo json_encode([

    "success" => true,

    "model" => $result["model"],

    "analysis" => $analysis

]);