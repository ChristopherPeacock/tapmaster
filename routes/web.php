<?php
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

Route::get('/bambu_a1_status', function () {
    $scriptPath = base_path('python-scripts/bambuLabs.py');
    
    if (!file_exists($scriptPath)) {
        return response()->json(['error' => 'Script not found'], 404);
    }

    $process = new Process(['C:\Users\Robyn Peacock\AppData\Local\Programs\Python\Python313\python.exe', $scriptPath]);
    $process->run();
    
    if (!$process->isSuccessful()) {
        return response()->json([
            'error' => 'Process failed',
            'output' => $process->getErrorOutput()
        ], 500);
    }
    
    $output = trim($process->getOutput());
    
    // Debug the raw output
    return response($output, 200, ['Content-Type' => 'text/plain']);
});

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
