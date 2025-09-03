# Memory Management Troubleshooting Guide

## 🚨 **Memory Exhausted Error Solutions**

When you encounter "Allowed memory size exhausted" errors, follow these solutions in order:

## 📋 **Quick Fixes**

### 1. **Immediate PHP Memory Increase**
```bash
# For single command execution
php -d memory_limit=512M artisan [command]

# For web requests, edit php.ini:
memory_limit = 512M

# Or use .htaccess for Apache:
php_value memory_limit 512M
```

### 2. **Use Memory-Optimized Commands**
```bash
# Use our custom memory-optimized command
php artisan app:memory-optimized migrate
php artisan app:memory-optimized seed
php artisan app:memory-optimized cache

# Or increase memory for specific operations
php -d memory_limit=512M artisan migrate
php -d memory_limit=512M artisan db:seed
```

### 3. **Build Assets with Memory Optimization**
```bash
# Use memory-optimized build scripts
npm run build:memory        # 4GB Node.js memory
npm run build:high-memory    # 8GB Node.js memory
npm run dev:memory          # 2GB for development
```

## 🔧 **Configuration Solutions**

### 1. **PHP Configuration**
Copy `php-memory-config.ini` to your PHP configuration directory or use it with:
```bash
php -c php-memory-config.ini artisan [command]
```

### 2. **Environment Variables**
Add to your `.env` file:
```env
# Memory optimization
PHP_MEMORY_LIMIT=512M
NODE_OPTIONS=--max-old-space-size=4096
```

### 3. **Automatic Memory Management**
The `MemoryServiceProvider` automatically handles memory limits based on:
- Current operation type (web/console)
- Request path (heavy operations get more memory)
- File upload sizes
- Environment settings

## 📊 **Memory Monitoring**

### Check Current Memory Usage
```bash
# Using our memory manager
php artisan tinker
>>> App\Helpers\MemoryManager::getCurrentUsage()

# Get recommendations
>>> App\Helpers\MemoryManager::getRecommendations()
```

### Monitor During Operations
```php
use App\Helpers\MemoryManager;

// Execute with monitoring
MemoryManager::withMonitoring(function() {
    // Your heavy operation here
}, function($usage) {
    Log::warning('High memory usage', $usage);
});
```

## 🎯 **Specific Error Scenarios**

### 1. **Filament Admin Panel Operations**
```bash
# Car management with large image uploads
php -d memory_limit=512M artisan app:memory-optimized

# User bulk operations
php -d memory_limit=384M artisan filament:optimize
```

### 2. **Database Operations**
```bash
# Large migrations
php -d memory_limit=512M artisan migrate

# Heavy seeders
php -d memory_limit=1G artisan db:seed --class=CarSeeder
```

### 3. **Asset Compilation**
```bash
# Memory-safe asset building
npm run build:memory

# For very large projects
npm run build:high-memory
```

## 🛠 **Development vs Production**

### Development Settings
- Memory limit: 512M
- Detailed error reporting
- Memory monitoring enabled

### Production Settings
- Memory limit: 256M (optimized code should use less)
- Error logging only
- Performance monitoring

## ⚠️ **Common Causes**

1. **Large file uploads** (car images)
2. **Bulk data processing** (imports/exports)
3. **Complex Filament forms** with many fields
4. **Heavy asset compilation**
5. **Memory leaks** in custom code

## 🚀 **Performance Optimization**

### Code Optimization
```php
// Use lazy loading for large datasets
Car::with('images')->lazy()->each(function ($car) {
    // Process car
    unset($car); // Free memory
});

// Force garbage collection after heavy operations
gc_collect_cycles();

// Use database chunking
Car::chunk(100, function ($cars) {
    foreach ($cars as $car) {
        // Process car
    }
});
```

### Database Optimization
```php
// Use select() to limit fields
Car::select('id', 'title', 'price')->get();

// Use pagination instead of get()
Car::paginate(50);

// Clear query cache periodically
DB::flushQueryLog();
```

## 📞 **Emergency Solutions**

If all else fails:

1. **Restart PHP-FPM/Apache**
```bash
# Ubuntu/Debian
sudo service php8.2-fpm restart
sudo service apache2 restart

# Windows XAMPP
# Restart Apache from control panel
```

2. **Clear All Caches**
```bash
php artisan optimize:clear
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

3. **Temporary High Limit**
```bash
# Emergency high memory limit
php -d memory_limit=1G artisan [command]
```

## 📈 **Monitoring Commands**

```bash
# Check memory usage
php artisan app:memory-optimized

# Test translations (lighter operation)
php artisan test:translations

# Memory status
php -i | grep memory_limit
```

## 🔍 **Debugging Memory Issues**

Add to your code for debugging:
```php
// At the start of problematic functions
$start = memory_get_usage();

// Your code here

// At the end
$end = memory_get_usage();
Log::info('Memory used: ' . ($end - $start) . ' bytes');
```

Remember: The MemoryServiceProvider will automatically handle most scenarios, but manual intervention may be needed for extremely heavy operations.