<?php

namespace App\Filament\Widgets;

use App\Models\Car;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class PopularCarsWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    
    protected static ?string $heading = '';
    protected static ?string $description = '';
    
    public static function getHeading(): string
    {
        return __('dashboard.widgets.popular_cars.title');
    }
    
    public static function getDescription(): ?string
    {
        return __('dashboard.widgets.popular_cars.description');
    }
    
    public function table(Table $table): Table
    {
        return $table
            ->query(Car::query())
            ->defaultSort('created_at', 'desc') // Since we don't have view counts, sort by newest
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label(__('dashboard.widgets.popular_cars.car'))
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('make')
                    ->label(__('dashboard.widgets.popular_cars.make'))
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('model')
                    ->label(__('dashboard.widgets.popular_cars.model'))
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('offers_count')
                    ->label(__('dashboard.widgets.popular_cars.offers'))
                    ->counts('offers')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('common.labels.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Add filters if needed
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Add bulk actions if needed
            ])
            ->paginated([5]);
    }
    
    public static function canView(): bool
    {
        return true;
    }
}