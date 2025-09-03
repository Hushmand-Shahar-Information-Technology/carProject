<?php

namespace App\Providers;

use App\Helpers\MemoryManager;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;

class MemoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register MemoryManager as singleton
        $this->app->singleton('memory.manager', function () {
            return new MemoryManager();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Set memory limits based on environment
        $this->configureMemoryLimits();
        
        // Add memory monitoring for heavy operations
        $this->addMemoryMonitoring();
    }

    /**
     * Configure memory limits based on environment and operations
     */
    private function configureMemoryLimits(): void
    {
        $currentLimit = ini_get('memory_limit');
        $requiredLimit = $this->getRequiredMemoryLimit();
        
        if ($this->shouldIncreaseMemoryLimit($currentLimit, $requiredLimit)) {
            ini_set('memory_limit', $requiredLimit);
            
            Log::info('Memory limit increased', [
                'from' => $currentLimit,
                'to' => $requiredLimit,
                'reason' => 'CarProject requirements'
            ]);
        }
    }

    /**
     * Get required memory limit based on current operation
     */
    private function getRequiredMemoryLimit(): string
    {
        // Check if running in console (Artisan commands)
        if (app()->runningInConsole()) {
            return '512M'; // Higher limit for console operations
        }
        
        // Check if running heavy operations
        if ($this->isHeavyOperation()) {
            return '384M';
        }
        
        // Default web request limit
        return '256M';
    }

    /**
     * Check if current request involves heavy operations
     */
    private function isHeavyOperation(): bool
    {
        if (!app('request')) {
            return false;
        }
        
        $path = app('request')->path();
        $heavyPaths = [
            'admin/cars/create',
            'admin/cars/edit',
            'admin/users/export',
            'admin/reports',
            'api/cars/import'
        ];
        
        foreach ($heavyPaths as $heavyPath) {
            if (str_contains($path, $heavyPath)) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Check if memory limit should be increased
     */
    private function shouldIncreaseMemoryLimit(string $current, string $required): bool
    {
        $currentBytes = $this->convertToBytes($current);
        $requiredBytes = $this->convertToBytes($required);
        
        return $requiredBytes > $currentBytes;
    }

    /**
     * Add memory monitoring for specific operations
     */
    private function addMemoryMonitoring(): void
    {
        // Monitor Filament operations
        if (class_exists('\Filament\Facades\Filament')) {
            $this->monitorFilamentOperations();
        }
        
        // Monitor file uploads
        $this->monitorFileUploads();
    }

    /**
     * Monitor Filament operations for memory usage
     */
    private function monitorFilamentOperations(): void
    {
        // This would be implemented with Filament hooks when available
        // For now, we'll add it to the middleware stack in AdminPanelProvider
    }

    /**
     * Monitor file upload operations
     */
    private function monitorFileUploads(): void
    {
        // Monitor large file uploads that might cause memory issues
        if (app('request') && app('request')->hasFile('images')) {
            $files = app('request')->file('images');
            $totalSize = 0;
            
            if (is_array($files)) {
                foreach ($files as $file) {
                    $totalSize += $file->getSize();
                }
            } else {
                $totalSize = $files->getSize();
            }
            
            // If total upload size > 50MB, increase memory limit
            if ($totalSize > 50 * 1024 * 1024) {
                ini_set('memory_limit', '512M');
            }
        }
    }

    /**
     * Convert memory limit string to bytes
     */
    private function convertToBytes(string $limit): int
    {
        if ($limit === '-1') {
            return PHP_INT_MAX;
        }
        
        $value = (int) $limit;
        $unit = strtolower(substr($limit, -1));
        
        switch ($unit) {
            case 'g':
                $value *= 1024;
            case 'm':
                $value *= 1024;
            case 'k':
                $value *= 1024;
        }
        
        return $value;
    }
}