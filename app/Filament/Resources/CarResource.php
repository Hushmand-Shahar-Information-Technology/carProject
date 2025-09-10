<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CarResource\Pages;
use App\Models\Car;
use App\Enums\CarColor;
use App\Enums\TransmissionType;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Support\Enums\MaxWidth;
use Afsakar\LeafletMapPicker\LeafletMapPicker;
use Illuminate\Database\Eloquent\Builder;
class CarResource extends Resource
{
    protected static ?string $model = Car::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->sortable(),
                Tables\Columns\TextColumn::make('make')
                    ->label(__('car.fields.make'))
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->searchable(),
                Tables\Columns\TextColumn::make('model')
                    ->label(__('car.fields.model'))
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->searchable(),
                Tables\Columns\TextColumn::make('VIN_number')
                    ->label(__('car.fields.vin_number'))
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->searchable(),
                Tables\Columns\TextColumn::make('regular_price')
                    ->label(__('car.fields.regular_price'))
                    ->money('USD')
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->sortable(),

                Tables\Columns\IconColumn::make('request_price_status')
                    ->label(__('car.fields.request_price_status'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->boolean(),
                Tables\Columns\TextColumn::make('request_price')
                    ->label(__('car.fields.request_price'))
                    ->money('USD')
                    ->toggleable(isToggledHiddenByDefault: true)
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
                // Main Filter Modal with Enhanced 4-Column Grid
                Filters\Filter::make('car_filters')
                    ->label(__('car.filters.advanced_filters'))
                    ->form([
                        Forms\Components\Grid::make([
                            'default' => 1,
                            'md' => 2,
                            'lg' => 4,
                        ])
                            ->schema([
                                // Column 1: Basic Information
                                Forms\Components\Section::make(__('car.filters.basic_info'))
                                    ->description(__('car.filters.basic_info_description'))
                                    ->schema([
                                        Forms\Components\TextInput::make('title')
                                            ->label(__('car.fields.title'))
                                            ->placeholder(__('car.filters.search_title_placeholder'))
                                            ->maxLength(255),
                                        
                                        Forms\Components\TextInput::make('vin_number')
                                            ->label(__('car.fields.vin_number'))
                                            ->placeholder(__('car.filters.search_vin_placeholder'))
                                            ->maxLength(17),
                                        
                                        Forms\Components\Select::make('make')
                                            ->label(__('car.fields.make'))
                                            ->options(function (): array {
                                                return Car::query()
                                                    ->whereNotNull('make')
                                                    ->distinct()
                                                    ->pluck('make', 'make')
                                                    ->toArray();
                                            })
                                            ->searchable()
                                            ->multiple()
                                            ->preload()
                                            ->live()
                                            ->hintIcon('heroicon-o-information-circle', tooltip: __('car.filters.make_tooltip')),
                                        
                                        Forms\Components\Select::make('model')
                                            ->label(__('car.fields.model'))
                                            ->options(function (): array {
                                                return Car::query()
                                                    ->whereNotNull('model')
                                                    ->distinct()
                                                    ->pluck('model', 'model')
                                                    ->toArray();
                                            })
                                            ->searchable()
                                            ->multiple()
                                            ->preload()
                                            ->hintIcon('heroicon-o-information-circle', tooltip: __('car.filters.model_tooltip')),
                                    ])->columnSpan(1),

                                
                                // Column 2: Specifications
                                Forms\Components\Section::make(__('car.filters.specifications'))
                                    ->description(__('car.filters.specifications_description'))
                                    ->schema([
                                        Forms\Components\Grid::make(2)
                                            ->schema([
                                                Forms\Components\Select::make('year_from')
                                                    ->label(__('car.filters.year_from'))
                                                    ->options(
                                                        collect(range(1990, date('Y')))
                                                            ->reverse()
                                                            ->mapWithKeys(fn($year) => [$year => $year])
                                                    )
                                                    ->searchable()
                                                    ->placeholder(__('car.filters.select_year')),
                                                
                                                Forms\Components\Select::make('year_to')
                                                    ->label(__('car.filters.year_to'))
                                                    ->options(
                                                        collect(range(1990, date('Y')))
                                                            ->reverse()
                                                            ->mapWithKeys(fn($year) => [$year => $year])
                                                    )
                                                    ->searchable()
                                                    ->placeholder(__('car.filters.select_year')),
                                            ]),
                                        
                                        Forms\Components\Select::make('transmission_type')
                                            ->label(__('car.fields.transmission_type'))
                                            ->options([
                                                'manual' => __('car.transmission.manual'),
                                                'automatic' => __('car.transmission.automatic'),
                                            ])
                                            ->multiple()
                                            ->hintIcon('heroicon-o-information-circle', tooltip: __('car.filters.transmission_tooltip')),
                                        
                                        Forms\Components\Select::make('body_type')
                                            ->label(__('car.fields.body_type'))
                                            ->options(function (): array {
                                                return Car::query()
                                                    ->whereNotNull('body_type')
                                                    ->distinct()
                                                    ->pluck('body_type', 'body_type')
                                                    ->toArray();
                                            })
                                            ->searchable()
                                            ->multiple()
                                            ->hintIcon('heroicon-o-information-circle', tooltip: __('car.filters.body_type_tooltip')),
                                    ])->columnSpan(1),
                                
                                // Column 3: Colors & Condition
                                Forms\Components\Section::make(__('car.filters.appearance'))
                                    ->description(__('car.filters.appearance_description'))
                                    ->schema([
                                        Forms\Components\Select::make('car_color')
                                            ->label(__('car.fields.car_color'))
                                            ->options(CarColor::labels())
                                            ->multiple()
                                            ->searchable()
                                            ->hintIcon('heroicon-o-information-circle', tooltip: __('car.filters.color_tooltip')),
                                        
                                        Forms\Components\Select::make('car_inside_color')
                                            ->label(__('car.fields.car_inside_color'))
                                            ->options(function (): array {
                                                return Car::query()
                                                    ->whereNotNull('car_inside_color')
                                                    ->distinct()
                                                    ->pluck('car_inside_color', 'car_inside_color')
                                                    ->toArray();
                                            })
                                            ->searchable()
                                            ->multiple()
                                            ->hintIcon('heroicon-o-information-circle', tooltip: __('car.filters.interior_color_tooltip')),
                                        
                                        Forms\Components\Select::make('car_condition')
                                            ->label(__('car.fields.car_condition'))
                                            ->options(function (): array {
                                                return Car::query()
                                                    ->whereNotNull('car_condition')
                                                    ->distinct()
                                                    ->pluck('car_condition', 'car_condition')
                                                    ->toArray();
                                            })
                                            ->searchable()
                                            ->multiple()
                                            ->hintIcon('heroicon-o-information-circle', tooltip: __('car.filters.condition_tooltip')),
                                        
                                        Forms\Components\Toggle::make('request_price_status')
                                            ->label(__('car.fields.request_price_status'))
                                            ->inline(false)
                                            ->helperText(__('car.filters.request_price_status_help')),
                                    ])->columnSpan(1),
                                
                                // Column 4: Price & Date Range
                                Forms\Components\Section::make(__('car.filters.price_date'))
                                    ->description(__('car.filters.price_date_description'))
                                    ->schema([
                                        Forms\Components\Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('price_from')
                                                    ->label(__('car.filters.price_from'))
                                                    ->numeric()
                                                    ->prefix('$')
                                                    ->placeholder('0')
                                                    ->minValue(0),
                                                
                                                Forms\Components\TextInput::make('price_to')
                                                    ->label(__('car.filters.price_to'))
                                                    ->numeric()
                                                    ->prefix('$')
                                                    ->placeholder('999999')
                                                    ->minValue(0),
                                            ]),
                                        
                                        Forms\Components\Grid::make(2)
                                            ->schema([
                                                Forms\Components\DatePicker::make('created_from')
                                                    ->label(__('car.filters.created_from'))
                                                    ->placeholder(__('car.filters.select_date'))
                                                    ->native(false),
                                                
                                                Forms\Components\DatePicker::make('created_until')
                                                    ->label(__('car.filters.created_until'))
                                                    ->placeholder(__('car.filters.select_date'))
                                                    ->native(false),
                                            ]),
                                        
                                        Forms\Components\Select::make('currency_type')
                                            ->label(__('car.fields.currency_type'))
                                            ->options(function (): array {
                                                return Car::query()
                                                    ->whereNotNull('currency_type')
                                                    ->distinct()
                                                    ->pluck('currency_type', 'currency_type')
                                                    ->toArray();
                                            })
                                            ->multiple()
                                            ->hintIcon('heroicon-o-information-circle', tooltip: __('car.filters.currency_tooltip')),
                                    ])->columnSpan(1),
                            ]),
                        
                        // Advanced Search Section (Full Width)
                        Forms\Components\Section::make(__('car.filters.advanced_search'))
                            ->description(__('car.filters.advanced_search_description'))
                            ->schema([
                                Forms\Components\TextInput::make('keyword')
                                    ->label(__('car.filters.keyword_search'))
                                    ->placeholder(__('car.filters.keyword_placeholder'))
                                    ->helperText(__('car.filters.keyword_help'))
                                    ->columnSpanFull()
                                    ->maxLength(255),
                            ])
                            ->columnSpanFull()
                            ->collapsible()
                            ->collapsed()
                            ->aside(),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            // Title filter
                            ->when(
                                $data['title'] ?? null,
                                fn (Builder $query, $title): Builder => $query->where('title', 'like', "%{$title}%")
                            )
                            // VIN filter
                            ->when(
                                $data['vin_number'] ?? null,
                                fn (Builder $query, $vin): Builder => $query->where('VIN_number', 'like', "%{$vin}%")
                            )
                            // Make filter
                            ->when(
                                !empty($data['make']),
                                fn (Builder $query): Builder => $query->whereIn('make', $data['make'])
                            )
                            // Model filter
                            ->when(
                                !empty($data['model']),
                                fn (Builder $query): Builder => $query->whereIn('model', $data['model'])
                            )
                            // Year range filter
                            ->when(
                                $data['year_from'] ?? null,
                                fn (Builder $query, $year): Builder => $query->where('year', '>=', $year)
                            )
                            ->when(
                                $data['year_to'] ?? null,
                                fn (Builder $query, $year): Builder => $query->where('year', '<=', $year)
                            )
                            // Transmission filter
                            ->when(
                                !empty($data['transmission_type']),
                                fn (Builder $query): Builder => $query->whereIn('transmission_type', $data['transmission_type'])
                            )
                            // Body type filter
                            ->when(
                                !empty($data['body_type']),
                                fn (Builder $query): Builder => $query->whereIn('body_type', $data['body_type'])
                            )
                            // Car color filter
                            ->when(
                                !empty($data['car_color']),
                                fn (Builder $query): Builder => $query->whereIn('car_color', $data['car_color'])
                            )
                            // Interior color filter
                            ->when(
                                !empty($data['car_inside_color']),
                                fn (Builder $query): Builder => $query->whereIn('car_inside_color', $data['car_inside_color'])
                            )
                            // Car condition filter
                            ->when(
                                !empty($data['car_condition']),
                                fn (Builder $query): Builder => $query->whereIn('car_condition', $data['car_condition'])
                            )
                            // Request price status filter
                            ->when(
                                $data['request_price_status'] ?? null,
                                fn (Builder $query, $status): Builder => $query->where('request_price_status', (bool) $status)
                            )
                            // Price range filter
                            ->when(
                                $data['price_from'] ?? null,
                                fn (Builder $query, $price): Builder => $query->where('regular_price', '>=', $price)
                            )
                            ->when(
                                $data['price_to'] ?? null,
                                fn (Builder $query, $price): Builder => $query->where('regular_price', '<=', $price)
                            )
                            // Date range filter
                            ->when(
                                $data['created_from'] ?? null,
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date)
                            )
                            ->when(
                                $data['created_until'] ?? null,
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date)
                            )
                            // Currency filter
                            ->when(
                                !empty($data['currency_type']),
                                fn (Builder $query): Builder => $query->whereIn('currency_type', $data['currency_type'])
                            )
                            // Advanced keyword search
                            ->when(
                                $data['keyword'] ?? null,
                                function (Builder $query, $keyword): Builder {
                                    return $query->where(function (Builder $query) use ($keyword) {
                                        $query->where('title', 'like', "%{$keyword}%")
                                            ->orWhere('make', 'like', "%{$keyword}%")
                                            ->orWhere('model', 'like', "%{$keyword}%")
                                            ->orWhere('VIN_number', 'like', "%{$keyword}%")
                                            ->orWhere('car_color', 'like', "%{$keyword}%")
                                            ->orWhere('car_inside_color', 'like', "%{$keyword}%")
                                            ->orWhere('transmission_type', 'like', "%{$keyword}%")
                                            ->orWhere('body_type', 'like', "%{$keyword}%")
                                            ->orWhere('car_condition', 'like', "%{$keyword}%");
                                    });
                                }
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        
                        if ($data['title'] ?? null) {
                            $indicators[] = __('car.filters.title_indicator', ['title' => $data['title']]);
                        }
                        
                        if ($data['vin_number'] ?? null) {
                            $indicators[] = __('car.filters.vin_indicator', ['vin' => $data['vin_number']]);
                        }
                        
                        if (!empty($data['make'])) {
                            $indicators[] = __('car.filters.make_indicator', ['makes' => implode(', ', $data['make'])]);
                        }
                        
                        if (!empty($data['model'])) {
                            $indicators[] = __('car.filters.model_indicator', ['models' => implode(', ', $data['model'])]);
                        }
                        
                        if ($data['year_from'] ?? null) {
                            $indicators[] = __('car.filters.year_from_indicator', ['year' => $data['year_from']]);
                        }
                        
                        if ($data['year_to'] ?? null) {
                            $indicators[] = __('car.filters.year_to_indicator', ['year' => $data['year_to']]);
                        }
                        
                        if ($data['price_from'] ?? null) {
                            $indicators[] = __('car.filters.price_from_indicator', ['price' => '$' . number_format($data['price_from'])]);
                        }
                        
                        if ($data['price_to'] ?? null) {
                            $indicators[] = __('car.filters.price_to_indicator', ['price' => '$' . number_format($data['price_to'])]);
                        }
                        
                        if ($data['keyword'] ?? null) {
                            $indicators[] = __('car.filters.keyword_indicator', ['keyword' => $data['keyword']]);
                        }
                        
                        return $indicators;
                    }),
            ], layout: FiltersLayout::Modal)
            ->filtersFormWidth(MaxWidth::SixExtraLarge)
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label(__('common.actions.view')),
                Tables\Actions\EditAction::make()
                    ->label(__('common.actions.edit')),
                Tables\Actions\Action::make('activities')
                    ->label(__('common.actions.activities'))
                    ->url(fn ($record) => CarResource::getUrl('activities', ['record' => $record]))
                    ->icon('heroicon-o-clipboard-document-list'),
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
            'activities' => Pages\ListCarActivities::route('/{record}/activities'),
        ];
    }
}