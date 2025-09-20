<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class TestSchedulerCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'test:scheduler';

    /**
     * The console command description.
     */
    protected $description = 'Test command to verify scheduler is working';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $message = '[' . now()->toDateTimeString() . '] Test scheduler command executed successfully.';
            $this->info($message);
            Log::info($message, [
                'timestamp' => now()->toDateTimeString()
            ]);
            return 0;
        } catch (\Exception $e) {
            $errorMessage = 'Error in test scheduler command: ' . $e->getMessage();
            $this->error($errorMessage);
            Log::error($errorMessage, [
                'timestamp' => now()->toDateTimeString(),
                'exception' => $e
            ]);
            return 1;
        }
    }
}