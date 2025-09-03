<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local') && class_exists(\Laravel\Telescope\TelescopeServiceProvider::class)) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Ensure legacy morph types resolve correctly
        Relation::enforceMorphMap([
            'car' => \App\Models\Car::class,
            'bargain' => \App\Models\Bargain::class,
            // Fallbacks for legacy namespaces
            'App\\Car' => \App\Models\Car::class,
            'App\\Bargain' => \App\Models\Bargain::class,
            'App\\Models\\Car' => \App\Models\Car::class,
            'App\\Models\\Bargain' => \App\Models\Bargain::class,
        ]);
    }
}
