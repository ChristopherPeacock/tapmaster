<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Log;

Route::get('/', function () {
    return response()->json([
        'message' => 'Connection established from server ',
        'status' => 'success',
    ]);
});

Route::get('/desktop_lamp_on', function () {
    $picoIp = 'http://192.168.1.244:8080';

    try {
        $response = Http::withHeaders([
            'Content-Type' => 'text/plain',
        ])->withBody('on', 'text/plain')->post($picoIp);

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

Route::get('/desktop_lamp_off', function () {
    $picoIp = 'http://192.168.1.244:8080';

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
