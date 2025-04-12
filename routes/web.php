<?php

use App\Http\Controllers\MqttController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use PhpMqtt\Client\Facades\MQTT;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;
use Illuminate\Http\Request;
use Inertia\Inertia;

Route::get('/dashboard', function () {
    return view('dash');
})->name('dashboard');

Route::post('/mqtt/publish',[MqttController::class, 'publish'])->name('mqtt.publish');

Route::get('/gemini2.0', function () {
    $apiKey = env('GEMINI');
    $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=" . $apiKey;
    $payload = [
        "contents" => [
            [
                "parts" => [
                    ["text" => "Explain how AI works"]
                ]
            ]
        ]
    ];
    $maxRetries = 3;
    $retryDelay = 1; // Initial delay in seconds
    for ($attempt = 0; $attempt < $maxRetries; $attempt++) {
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($url, $payload);
            if ($response->successful()) {
                return response()->json($response->json());
            } elseif ($response->status() !== 503) {
                return response()->json([
                    'error' => 'Failed to fetch data from Gemini API',
                    'details' => $response->body(),
                ], $response->status());
            }
            // 503 error, retry after delay
            sleep($retryDelay);
            $retryDelay *= 2; // Exponential backoff
        } catch (\Exception $e) {
            // Handle other exceptions
            if($attempt == ($maxRetries -1)){
                return response()->json([
                    'error' => 'An error occurred while communicating with the Gemini API',
                    'details' => $e->getMessage(),
                ], 500);
            }
            sleep($retryDelay);
            $retryDelay *= 2;
        }
    }
    return response()->json([
        'error' => 'Gemini API unavailable after multiple retries',
    ], 503);
});

Route::get('/print', function () {
    $response = 'Calling bambu labs to print file';

    $scriptPath = base_path('javascript-scripts/QRCodePrint.js');

    if(!file_exists($scriptPath)) {
        return response()->json(['error' => 'Script not found'], 404);
    }

    $process = new Process(['C:\Program Files\nodejs\node.exe', $scriptPath]);
    $process->run();

    if (!$process->isSuccessful()) {
        return response()->json([
            'error' => 'Process failed',
            'output' => $process->getErrorOutput()
        ], 500);
    }

});

Route::get('/', function () {
    return response()->json([
        'message' => 'Connection established from server ',
        'status' => 'success',
    ]);
});

Route::get('/desktop_lamp_on', function () {
    $picoIp = 'http://192.168.1.244:8080/on';

    try {
        $response = Http::withHeaders([
            'Content-Type' => 'text/plain',
        ])->withBody('on', 'text/plain')->post($picoIp);

        if ($response->successful()) {
            return response()->json([
                'message' => 'Turning on Desktop lamp command was successfully sent to the device.',
                'status' => 'success',
            ]);
        } else {
            return response()->json([
                'message' => 'Failed to send command to the device.',
                'status' => 'error',
            ], 500);
        }
    } catch (\Exception $e) {
        Log::error("Device Communication Error: " . $e->getMessage());

        return response()->json([
            'message' => 'Error connecting to the device.',
            'status' => 'error',
        ], 500);
    }
});

Route::get('/desktop_lamp_off', function () {
    $picoIp = 'http://192.168.1.244:8080/off';

    try {
        $response = Http::withHeaders([
            'Content-Type' => 'text/plain',
        ])->withBody('off', 'text/plain')->post($picoIp);

        if ($response->successful()) {
            return response()->json([
                'message' => 'Turning on Desktop lamp command was successfully sent to the Pico.',
                'status' => 'success',
            ]);
        } else {
            return response()->json([
                'message' => 'Failed to send command to Pico.',
                'status' => 'error',
            ], 500);
        }
    } catch (\Exception $e) {
        Log::error("Pico W Communication Error: " . $e->getMessage());

        return response()->json([
            'message' => 'Error connecting to the Pico.',
            'status' => 'error',
        ], 500);
    } 
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
