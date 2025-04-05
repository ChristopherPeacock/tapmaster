<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ObjectDetection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:object-detection';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $scriptPath = base_path('python-scripts/ObjectDetection.py');
    }
}
