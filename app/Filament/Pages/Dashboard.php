<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\CarSalesChartWidget;
use App\Filament\Widgets\OfferAnalyticsWidget;
use App\Filament\Widgets\PopularCarsWidget;
use App\Filament\Widgets\RecentActivitiesWidget;
use App\Filament\Widgets\StatsOverviewWidget;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    public function getHeading(): string
    {
        return '';
    }
    
    public function getWidgets(): array
    {
        return [
            StatsOverviewWidget::class,
            CarSalesChartWidget::class,
            OfferAnalyticsWidget::class,
            PopularCarsWidget::class,
            RecentActivitiesWidget::class,
        ];
    }
    
    public function getColumns(): int
    {
        return 2;
    }
}