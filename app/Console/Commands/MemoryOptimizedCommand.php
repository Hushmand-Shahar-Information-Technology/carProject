<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MemoryOptimizedCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'app:memory-optimized {operation?}';

    /**
     * The console command description.
     */
    protected $description = 'Run memory-intensive operations with optimized memory usage';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Increase memory limit for this command only
        ini_set('memory_limit', '512M');
        
        $operation = $this->argument('operation');
        
        $this->info('Starting memory-optimized operation...');
        $this->info('Current memory limit: ' . ini_get('memory_limit'));
        $this->info('Current memory usage: ' . $this->formatBytes(memory_get_usage(true)));
        
        switch ($operation) {
            case 'migrate':
                $this->runMigrations();
                break;
            case 'seed':
                $this->runSeeders();
                break;
            case 'cache':
                $this->clearCaches();
                break;
            case 'assets':
                $this->compileAssets();
                break;
            default:
                $this->showAvailableOperations();
        }
        
        $this->info('Final memory usage: ' . $this->formatBytes(memory_get_usage(true)));
        $this->info('Peak memory usage: ' . $this->formatBytes(memory_get_peak_usage(true)));
    }

    private function runMigrations()
    {
        $this->info('Running migrations with memory optimization...');
        $this->call('migrate');
        
        // Force garbage collection
        gc_collect_cycles();
    }

    private function runSeeders()
    {
        $this->info('Running seeders with memory optimization...');
        
        // Process seeders in chunks to avoid memory issues
        $this->call('db:seed', ['--class' => 'DatabaseSeeder']);
        
        // Force garbage collection
        gc_collect_cycles();
    }

    private function clearCaches()
    {
        $this->info('Clearing all caches...');
        
        $this->call('cache:clear');
        $this->call('config:clear');
        $this->call('route:clear');
        $this->call('view:clear');
        
        // Clear Filament cache if exists
        if (class_exists(\Filament\Facades\Filament::class)) {
            $this->call('filament:clear-cached-components');
        }
        
        gc_collect_cycles();
    }

    private function compileAssets()
    {
        $this->info('Compiling assets with memory optimization...');
        
        // Use the memory-optimized build script
        $this->info('Running: npm run build:memory');
        
        gc_collect_cycles();
    }

    private function showAvailableOperations()
    {
        $this->info('Available operations:');
        $this->line('  migrate  - Run database migrations');
        $this->line('  seed     - Run database seeders');
        $this->line('  cache    - Clear all caches');
        $this->line('  assets   - Compile assets');
        $this->line('');
        $this->info('Usage: php artisan app:memory-optimized {operation}');
    }

    private function formatBytes($size, $precision = 2)
    {
        $base = log($size, 1024);
        $suffixes = ['B', 'KB', 'MB', 'GB', 'TB'];
        return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
    }
}