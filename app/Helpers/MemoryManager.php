<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;

class MemoryManager
{
    /**
     * Increase memory limit temporarily
     */
    public static function increaseLimit(string $limit = '512M'): string
    {
        $currentLimit = ini_get('memory_limit');
        ini_set('memory_limit', $limit);
        return $currentLimit;
    }

    /**
     * Restore memory limit
     */
    public static function restoreLimit(string $originalLimit): void
    {
        ini_set('memory_limit', $originalLimit);
    }

    /**
     * Get current memory usage
     */
    public static function getCurrentUsage(bool $realUsage = true): array
    {
        return [
            'current' => memory_get_usage($realUsage),
            'peak' => memory_get_peak_usage($realUsage),
            'limit' => self::convertToBytes(ini_get('memory_limit')),
            'formatted' => [
                'current' => self::formatBytes(memory_get_usage($realUsage)),
                'peak' => self::formatBytes(memory_get_peak_usage($realUsage)),
                'limit' => ini_get('memory_limit')
            ]
        ];
    }

    /**
     * Check if memory usage is approaching limit
     */
    public static function isApproachingLimit(float $threshold = 0.8): bool
    {
        $usage = memory_get_usage(true);
        $limit = self::convertToBytes(ini_get('memory_limit'));
        
        return ($usage / $limit) > $threshold;
    }

    /**
     * Force garbage collection
     */
    public static function cleanup(): int
    {
        return gc_collect_cycles();
    }

    /**
     * Execute a callback with increased memory limit
     */
    public static function withIncreasedLimit(callable $callback, string $limit = '512M')
    {
        $originalLimit = self::increaseLimit($limit);
        
        try {
            return $callback();
        } finally {
            self::restoreLimit($originalLimit);
        }
    }

    /**
     * Execute a callback with memory monitoring
     */
    public static function withMonitoring(callable $callback, ?callable $warningCallback = null)
    {
        $initialUsage = memory_get_usage(true);
        
        try {
            $result = $callback();
            
            if ($warningCallback && self::isApproachingLimit()) {
                $warningCallback(self::getCurrentUsage());
            }
            
            return $result;
        } finally {
            $finalUsage = memory_get_usage(true);
            $memoryUsed = $finalUsage - $initialUsage;
            
            // Log memory usage if significant
            if ($memoryUsed > 10 * 1024 * 1024) { // 10MB
                Log::info('High memory usage detected', [
                    'memory_used' => self::formatBytes($memoryUsed),
                    'peak_usage' => self::formatBytes(memory_get_peak_usage(true))
                ]);
            }
        }
    }

    /**
     * Convert memory limit string to bytes
     */
    private static function convertToBytes(string $limit): int
    {
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

    /**
     * Format bytes to human readable
     */
    private static function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }

    /**
     * Get memory recommendations based on current usage
     */
    public static function getRecommendations(): array
    {
        $usage = self::getCurrentUsage();
        $recommendations = [];
        
        // Check if approaching limit
        if (self::isApproachingLimit(0.8)) {
            $recommendations[] = 'Consider increasing memory_limit in php.ini';
        }
        
        // Check if peak usage is high
        if ($usage['peak'] > 100 * 1024 * 1024) { // 100MB
            $recommendations[] = 'High peak memory usage detected - consider optimizing data processing';
        }
        
        // Check for memory leaks
        $current = $usage['current'];
        $peak = $usage['peak'];
        if (($peak - $current) / $peak > 0.5) {
            $recommendations[] = 'Good memory cleanup - no obvious leaks detected';
        } else {
            $recommendations[] = 'Consider calling gc_collect_cycles() after heavy operations';
        }
        
        return $recommendations;
    }
}