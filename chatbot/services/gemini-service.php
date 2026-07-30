<?php

require_once __DIR__ . "/../config/gemini.php";
require_once __DIR__ . "/../config/gemini-models.php";

function callGemini($systemPrompt, $message)
{

    foreach (GEMINI_MODELS as $model) {

        $request = [

            "system_instruction" => [
                "parts" => [
                    [
                        "text" => $systemPrompt
                    ]
                ]
            ],

            "contents" => [
                [
                    "role" => "user",
                    "parts" => [
                        [
                            "text" => $message
                        ]
                    ]
                ]
            ]

        ];

        $ch = curl_init();

        curl_setopt_array($ch, [

            CURLOPT_URL =>
                "https://generativelanguage.googleapis.com/v1beta/models/" .
                $model .
                ":generateContent",

            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,

            CURLOPT_HTTPHEADER => [

                "Content-Type: application/json",
                "X-goog-api-key: " . GEMINI_API_KEY

            ],

            CURLOPT_POSTFIELDS => json_encode($request)

        ]);

        $result = curl_exec($ch);

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        $data = json_decode($result, true);

        // Success
        if ($httpCode === 200) {

            $text =
                $data["candidates"][0]["content"]["parts"][0]["text"]
                ?? "";

            return [

                "success" => true,
                "model" => $model,
                "text" => trim($text)

            ];

        }

$errorMessage = $data["error"]["message"] ?? "";

        $shouldFallback =
            $httpCode === 429 ||

            str_contains($errorMessage, "RESOURCE_EXHAUSTED") ||

            str_contains($errorMessage, "no longer available") ||

            str_contains($errorMessage, "not found") ||

            str_contains($errorMessage, "is not supported") ||

            str_contains($errorMessage, "deprecated");

        if ($shouldFallback) {
            continue;
        }

        // Any other error
        return [

            "success" => false,
            "model" => $model,
            "text" =>
                $data["error"]["message"]
                ?? "Unknown Gemini error."

        ];

    }

    return [

        "success" => false,
        "model" => null,
        "text" =>
            "All Gemini models have reached their quota."

    ];

}

// CAMERA IMAGE ANALYSIS

function callGeminiVision($systemPrompt, $imagePath)
{
    if (!file_exists($imagePath)) {
        return [
            "success" => false,
            "model" => null,
            "text" => "Image not found."
        ];
    }

    $imageData = base64_encode(file_get_contents($imagePath));

    foreach (GEMINI_MODELS as $model) {

        $request = [

            "system_instruction" => [
                "parts" => [
                    [
                        "text" => $systemPrompt
                    ]
                ]
            ],

            "contents" => [
                [
                    "role" => "user",
                    "parts" => [

                        [
                            "text" => "Analyze this image."
                        ],

                        [
                            "inline_data" => [
                                "mime_type" => "image/jpeg",
                                "data" => $imageData
                            ]
                        ]

                    ]
                ]
            ]

        ];

        $ch = curl_init();

        curl_setopt_array($ch, [

            CURLOPT_URL =>
                "https://generativelanguage.googleapis.com/v1beta/models/" .
                $model .
                ":generateContent",

            CURLOPT_RETURNTRANSFER => true,

            CURLOPT_POST => true,

            CURLOPT_HTTPHEADER => [

                "Content-Type: application/json",
                "X-goog-api-key: " . GEMINI_API_KEY

            ],

            CURLOPT_POSTFIELDS => json_encode($request)

        ]);

        $result = curl_exec($ch);

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        $data = json_decode($result, true);

        if ($httpCode === 200) {

            return [

                "success" => true,

                "model" => $model,

                "text" =>
                    trim(
                        $data["candidates"][0]["content"]["parts"][0]["text"]
                        ?? ""
                    )

            ];

        }

        $errorMessage = $data["error"]["message"] ?? "";

        $shouldFallback =
            $httpCode === 429 ||

            str_contains($errorMessage, "RESOURCE_EXHAUSTED") ||

            str_contains($errorMessage, "deprecated") ||

            str_contains($errorMessage, "not found") ||

            str_contains($errorMessage, "no longer available");

        if ($shouldFallback) {
            continue;
        }

        return [

            "success" => false,

            "model" => $model,

            "text" => $errorMessage

        ];

    }

    return [

        "success" => false,

        "model" => null,

        "text" => "All Gemini models failed."

    ];
}