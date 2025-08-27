<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
         View::composer('*', function ($view) {
            $distinctValues = [
                'colors' => DB::table('cars')->whereNotNull('car_color')->distinct()->pluck('car_color'),
                'models' => DB::table('cars')->whereNotNull('model')->distinct()->pluck('model'),
                'make' => DB::table('cars')->whereNotNull('make')->distinct()->pluck('make'),
                'body_type' => DB::table('cars')->whereNotNull('body_type')->distinct()->pluck('body_type'),
                'car_condition' => DB::table('cars')->whereNotNull('car_condition')->distinct()->pluck('car_condition'),
                'transmissions' => DB::table('cars')->whereNotNull('transmission_type')->distinct()->pluck('transmission_type'),
            ];

            $view->with('distinctValues', $distinctValues);
        });
    }
}
