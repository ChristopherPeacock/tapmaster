<?php

namespace App\Listeners;

use App\Events\SensorDataReceived;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AnalyzeSensorData
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SensorDataReceived $event): void
    {
        //
    }
}
