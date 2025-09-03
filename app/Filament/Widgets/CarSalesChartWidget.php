<?php

namespace App\Filament\Widgets;

use App\Models\Car;
use App\Models\Offer;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class CarSalesChartWidget extends ChartWidget
{
    protected static ?string $heading = '';
    protected static ?string $description = '';
    
    public function getHeading(): string
    {
        return __('dashboard.widgets.car_sales_chart.title');
    }
    
    public  function getDescription(): ?string
    {
        return __('dashboard.widgets.car_sales_chart.description');
    }
    protected static string $color = 'success';
    
    protected function getData(): array
    {
        // Get the last 12 months
        $months = [];
        $listingsData = [];
        $salesData = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $months[] = __(
                'dashboard.widgets.car_sales_chart.months.' . strtolower($month->format('M'))
            );
            
            // Get car listings for this month
            $listingsCount = Car::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
            $listingsData[] = $listingsCount;
            
            // Get offers for this month (as a proxy for sales activity)
            $salesCount = Offer::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
            $salesData[] = $salesCount;
        }
        
        return [
            'datasets' => [
                [
                    'label' => __('dashboard.widgets.car_sales_chart.listings'),
                    'data' => $listingsData,
                    'backgroundColor' => '#3b82f6', // blue
                    'borderColor' => '#3b82f6',
                ],
                [
                    'label' => __('dashboard.widgets.car_sales_chart.sales'),
                    'data' => $salesData,
                    'backgroundColor' => '#10b981', // green
                    'borderColor' => '#10b981',
                ],
            ],
            'labels' => $months,
        ];
    }
    
    protected function getType(): string
    {
        return 'line';
    }
    
    public static function canView(): bool
    {
        return true;
    }
}