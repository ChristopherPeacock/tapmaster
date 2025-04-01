<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeminiApiService
{
    public function analyzeData(array $sensorData)
    {
        $apiKey = env('GEMINI');
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=" . $apiKey;
        $prompt = "You are an assistant that is helping building projects, you will act like jarvis from iron man. i am your creator and you will be passed alot of data you must process this data and give me my best options and make me fully aware if the data is incoreect with what you know and what you would recommend. : data={$sensorData['data']}";

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