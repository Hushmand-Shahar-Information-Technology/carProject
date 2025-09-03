<?php

namespace App\Filament\Widgets;

use App\Models\Car;
use App\Models\Offer;
use App\Models\User;
use Carbon\Carbon;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class RecentActivitiesWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    
    protected static ?string $heading = '';
    protected static ?string $description = '';
    
    public static function getHeading(): string
    {
        return __('dashboard.widgets.recent_activities.title');
    }
    
    public static function getDescription(): ?string
    {
        return __('dashboard.widgets.recent_activities.description');
    }
    
    public function table(Table $table): Table
    {
        // Create a simple approach using one model with a custom query
        return $table
            ->query(Car::query())
            ->modifyQueryUsing(function (Builder $query) {
                // We'll limit to just recent cars for now to keep it simple
                $query->latest()->limit(10);
            })
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->label(__('common.labels.type'))
                    ->formatStateUsing(fn () => '🚗')
                    ->tooltip(__('dashboard.widgets.recent_activities.car_added_tooltip')),
                
                Tables\Columns\TextColumn::make('title')
                    ->label(__('common.labels.activity'))
                    ->formatStateUsing(fn ($state) => __('dashboard.widgets.recent_activities.car_added', ['title' => $state]))
                    ->wrap(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('common.labels.time'))
                    ->formatStateUsing(fn ($state) => Carbon::parse($state)->diffForHumans())
                    ->dateTime()
                    ->sortable()
                    ->description(fn ($record) => Carbon::parse($record->created_at)->diffForHumans()),
            ])
            ->paginated([10]);
    }
    
    public static function canView(): bool
    {
        return true;
    }
}