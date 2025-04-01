<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeminiApiService
{
    public function analyzeData(array $sensorData)
    {
        $apiKey = env('GEMINI');
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=" . $apiKey;
        $prompt = "Analyze the following sensor data: Temperature={$sensorData['temperature']}, Humidity={$sensorData['humidity']}";

        $payload = [
            "contents" => [
                [
                    "parts" => [
                        ["text" => $prompt]
                    ]
                ]
            ]
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post($url, $payload);

        // Handle the Gemini API response (e.g., log, send to MQTT, etc.)
        // ...
        return $response->json();
    }
}