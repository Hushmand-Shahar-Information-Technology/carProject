<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestScheduler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:scheduler';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test command to verify scheduler is working';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Test scheduler command executed at: ' . now()->toDateTimeString());
        \Illuminate\Support\Facades\Log::info('Test scheduler command executed', [
            'timestamp' => now()->toDateTimeString()
        ]);
        return 0;
    }
}