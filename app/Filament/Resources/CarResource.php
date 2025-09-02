<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CarResource\Pages;
use App\Models\Car;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Afsakar\LeafletMapPicker\LeafletMapPicker;
class CarResource extends Resource
{
    protected static ?string $model = Car::class;

    protected static ?string $navigationIcon = 'car';

    public static function getModelLabel(): string
    {
        return __('car.title');
    }

    public static function getPluralModelLabel(): string
    {
        return __('car.plural');
    }

    public static function getNavigationLabel(): string
    {
        return __('car.navigation_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('car.navigation_group');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Forms\Components\TextInput::make('title')
                        ->label(__('car.fields.title'))
                        ->required(),
                    Forms\Components\TextInput::make('year')
                        ->label(__('car.fields.year'))
                        ->numeric()
                        ->required(),
                    Forms\Components\TextInput::make('make')
                        ->label(__('car.fields.make'))
                        ->required(),
                    Forms\Components\TextInput::make('model')
                        ->label(__('car.fields.model'))
                        ->required(),
                    Forms\Components\TextInput::make('VIN_number')
                        ->label(__('car.fields.vin_number'))
                        ->required(),
                    Forms\Components\TextInput::make('regular_price')
                        ->label(__('car.fields.regular_price'))
                        ->numeric()
                        ->prefix('$')
                        ->required(),
                    Forms\Components\TextInput::make('sale_price')
                        ->label(__('car.fields.sale_price'))
                        ->numeric()
                        ->prefix('$'),
                    Forms\Components\TextInput::make('request_price')
                        ->label(__('car.fields.request_price'))
                        ->numeric()
                        ->prefix('$'),
                    Forms\Components\Toggle::make('request_price_status')
                        ->label(__('car.fields.request_price_status'))
                        ->required(),
                ])->columns(3),
                LeafletMapPicker::make('location')
                    ->label(__('car.labels.select_location'))->columnSpanFull(),
                Forms\Components\FileUpload::make('images')
                    ->label(__('car.fields.images'))
                    ->image()
                    ->multiple()
                    ->maxFiles(10)
                    ->helperText(__('car.labels.upload_images_help'))
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label(__('car.fields.title'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('year')
                    ->label(__('car.fields.year'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('make')
                    ->label(__('car.fields.make'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('model')
                    ->label(__('car.fields.model'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('VIN_number')
                    ->label(__('car.fields.vin_number'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('regular_price')
                    ->label(__('car.fields.regular_price'))
                    ->money('USD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('sale_price')
                    ->label(__('car.fields.sale_price'))
                    ->money('USD')
                    ->sortable(),
                Tables\Columns\IconColumn::make('request_price_status')
                    ->label(__('car.fields.request_price_status'))
                    ->boolean(),
                Tables\Columns\TextColumn::make('request_price')
                    ->label(__('car.fields.request_price'))
                    ->money('USD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('common.labels.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('common.labels.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label(__('common.actions.view')),
                Tables\Actions\EditAction::make()
                    ->label(__('common.actions.edit')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label(__('common.actions.delete')),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCars::route('/'),
            'create' => Pages\CreateCar::route('/create'),
            'view' => Pages\ViewCar::route('/{record}'),
            'edit' => Pages\EditCar::route('/{record}/edit'),
        ];
    }
}
