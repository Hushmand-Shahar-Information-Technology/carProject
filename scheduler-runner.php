<?php

/**
 * This script runs the Laravel scheduler in a loop
 * It should be run in the background to ensure expired auctions are processed
 */

require_once __DIR__ . '/vendor/autoload.php';

// Load Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Run scheduler every minute
while (true) {
    echo "[" . date('Y-m-d H:i:s') . "] Running scheduler...\n";
    
    try {
        // Run the scheduler
        $status = $kernel->call('schedule:run');
        echo "[" . date('Y-m-d H:i:s') . "] Scheduler completed with status: " . $status . "\n";
    } catch (Exception $e) {
        echo "[" . date('Y-m-d H:i:s') . "] Error running scheduler: " . $e->getMessage() . "\n";
    }
    
    // Wait for 60 seconds before next run
    sleep(60);
}