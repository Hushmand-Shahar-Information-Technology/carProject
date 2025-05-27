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

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Forms\Components\TextInput::make('title'),
                    Forms\Components\TextInput::make('year'),
                    Forms\Components\TextInput::make('make'),
                    Forms\Components\TextInput::make('model'),
                    Forms\Components\TextInput::make('VIN_number'),
                    Forms\Components\TextInput::make('regular_price')
                        ->numeric(),
                    Forms\Components\TextInput::make('sale_price')
                        ->numeric(),
                    Forms\Components\TextInput::make('request_price')
                        ->numeric(),
                    Forms\Components\Toggle::make('request_price_status')
                        ->required(),
                ])->columns(3),
                LeafletMapPicker::make('location')
                    ->label('Select Location')->columnSpanFull(),
                Forms\Components\FileUpload::make('images')
                    ->image()
                    ->multiple()
                    ->maxFiles(10)
                    ->helperText('Upload up to 10 images, max size 10MB, only JPEG, PNG, GIF, and BMP files are allowed')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('year')
                    ->searchable(),
                Tables\Columns\TextColumn::make('make')
                    ->searchable(),
                Tables\Columns\TextColumn::make('model')
                    ->searchable(),
                Tables\Columns\TextColumn::make('VIN_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('regular_price')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sale_price')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('request_price_status')
                    ->boolean(),
                Tables\Columns\TextColumn::make('request_price')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
