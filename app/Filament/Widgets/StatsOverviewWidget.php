<?php

namespace App\Filament\Widgets;

use App\Models\Car;
use App\Models\Offer;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class StatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        // Get total cars count
        $totalCars = Car::count();
        
        // Get total offers count
        $totalOffers = Offer::count();
        
        // Get total users count
        $totalUsers = User::count();
        
        // Get recent activities count (last 7 days) - sum of recent cars, offers, and users
        $recentActivities = Car::where('created_at', '>=', now()->subDays(7))->count() +
                           Offer::where('created_at', '>=', now()->subDays(7))->count() +
                           User::where('created_at', '>=', now()->subDays(7))->count();
        
        return [
            Stat::make(__('dashboard.widgets.stats_overview.total_cars'), $totalCars)
                ->description(__('dashboard.widgets.stats_overview.total_cars'))
                ->descriptionIcon('heroicon-o-chart-pie')
                ->color('success')
                ->chart([7, 2, 10, 3, 15, 8, 9]), // Sample data for trend line
            
            Stat::make(__('dashboard.widgets.stats_overview.total_offers'), $totalOffers)
                ->description(__('dashboard.widgets.stats_overview.total_offers'))
                ->descriptionIcon('heroicon-o-document-text')
                ->color('primary')
                ->chart([1, 5, 3, 8, 4, 12, 6]), // Sample data for trend line
            
            Stat::make(__('dashboard.widgets.stats_overview.total_users'), $totalUsers)
                ->description(__('dashboard.widgets.stats_overview.total_users'))
                ->descriptionIcon('heroicon-o-users')
                ->color('info')
                ->chart([2, 1, 4, 3, 5, 6, 7]), // Sample data for trend line
            
            Stat::make(__('dashboard.widgets.stats_overview.recent_activity'), $recentActivities)
                ->description(__('dashboard.widgets.stats_overview.recent_activity'))
                ->descriptionIcon('heroicon-o-clock')
                ->color('warning')
                ->chart([1, 2, 3, 4, 3, 2, 5]), // Sample data for trend line
        ];
    }
}