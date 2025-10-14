<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use App\Models\Car;
use App\Observers\CarObserver;

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
        // Register model observers
        Car::observe(CarObserver::class);

        // Ensure legacy morph types resolve correctly
        Relation::enforceMorphMap([
            'user' => \App\Models\User::class,
            'car' => \App\Models\Car::class,
            'bargain' => \App\Models\Bargain::class,
            'promotion' => \App\Models\Promotion::class,
            // Fallbacks for legacy namespaces
            'App\\User' => \App\Models\User::class,
            'App\\Car' => \App\Models\Car::class,
            'App\\Bargain' => \App\Models\Bargain::class,
            'App\\Models\\User' => \App\Models\User::class,
            'App\\Models\\Car' => \App\Models\Car::class,
            'App\\Models\\Bargain' => \App\Models\Bargain::class,
            'App\\Models\\Promotion' => \App\Models\Promotion::class,
        ]);
    }
}
