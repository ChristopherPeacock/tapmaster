<?php

use App\Http\Controllers\MqttController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/dash', function () {
    return view('dash');
})->name('dashboard');

Route::get('/dashboard', function () {
    return Inertia('dashboard');
})->name('dashboard');

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

Route::get('/', function () {
    return response()->json([
        'message' => 'Connection established from server ',
        'status' => 'success',
    ]);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
