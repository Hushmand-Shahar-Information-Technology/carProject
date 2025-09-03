<?php

namespace App\Filament\Widgets;

use App\Models\Offer;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class OfferAnalyticsWidget extends ChartWidget
{
    protected static ?string $heading = '';
    protected static ?string $description = '';
    
    public  function getHeading(): string
    {
        return __('dashboard.widgets.offer_analytics.title');
    }
    
    public  function getDescription(): ?string
    {
        return __('dashboard.widgets.offer_analytics.description');
    }
    protected static string $color = 'primary';
    
    protected function getData(): array
    {
        // Get offers by month for the last 6 months
        $months = [];
        $offersData = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $months[] = __(
                'dashboard.widgets.car_sales_chart.months.' . strtolower($month->format('M'))
            );
            
            $offersCount = Offer::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
            $offersData[] = $offersCount;
        }
        
        return [
            'datasets' => [
                [
                    'label' => __('dashboard.widgets.offer_analytics.total_offers'),
                    'data' => $offersData,
                    'backgroundColor' => '#3b82f6', // blue
                    'borderColor' => '#3b82f6',
                ],
            ],
            'labels' => $months,
        ];
    }
    
    protected function getType(): string
    {
        return 'bar';
    }
    
    public static function canView(): bool
    {
        return true;
    }
}