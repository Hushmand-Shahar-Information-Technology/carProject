<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters;
use Filament\Tables\Enums\FiltersLayout;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getModelLabel(): string
    {
        return __('user.title');
    }

    public static function getPluralModelLabel(): string
    {
        return __('user.plural');
    }

    public static function getNavigationLabel(): string
    {
        return __('user.navigation_label');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('user.navigation_group');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('user.fields.name'))
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->label(__('user.fields.email'))
                    ->email()
                    ->required(),
                Forms\Components\DateTimePicker::make('email_verified_at')
                    ->label(__('user.fields.email_verified_at')),
                Forms\Components\TextInput::make('password')
                    ->label(__('user.fields.password'))
                    ->password()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('user.fields.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label(__('user.fields.email'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->label(__('user.fields.email_verified_at'))
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('cars_count')
                    ->label('Cars Count')
                    ->counts('cars')
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match (true) {
                        $state == 0 => 'gray',
                        $state >= 1 && $state <= 3 => 'success',
                        $state >= 4 && $state <= 10 => 'warning',
                        default => 'danger',
                    }),
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
                // Name Search Filter
                Filters\Filter::make('name')
                    ->form([
                        Forms\Components\TextInput::make('name')
                            ->label(__('user.filters.name'))
                            ->placeholder(__('user.filters.search_name_placeholder'))
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['name'] ?? null,
                                fn (Builder $query, $name): Builder => $query->where('name', 'like', "%{$name}%")
                            );
                    })
                    ->indicateUsing(function (array $data): ?string {
                        if (!$data['name']) {
                            return null;
                        }
                        return __('user.filters.name_indicator', ['name' => $data['name']]);
                    }),

                // Email Search Filter
                Filters\Filter::make('email')
                    ->form([
                        Forms\Components\TextInput::make('email')
                            ->label(__('user.filters.email'))
                            ->placeholder(__('user.filters.search_email_placeholder'))
                            ->email()
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['email'] ?? null,
                                fn (Builder $query, $email): Builder => $query->where('email', 'like', "%{$email}%")
                            );
                    })
                    ->indicateUsing(function (array $data): ?string {
                        if (!$data['email']) {
                            return null;
                        }
                        return __('user.filters.email_indicator', ['email' => $data['email']]);
                    }),

                // Email Verification Status Filter
                Filters\TernaryFilter::make('email_verified_at')
                    ->label(__('user.filters.email_verified'))
                    ->placeholder(__('user.filters.all_users'))
                    ->trueLabel(__('user.filters.verified_users'))
                    ->falseLabel(__('user.filters.unverified_users'))
                    ->queries(
                        true: fn (Builder $query) => $query->whereNotNull('email_verified_at'),
                        false: fn (Builder $query) => $query->whereNull('email_verified_at'),
                        blank: fn (Builder $query) => $query,
                    )
                    ->indicateUsing(function (array $data): ?string {
                        $state = $data['isActive'] ?? null;
                        if ($state === true) {
                            return __('user.filters.verified_indicator');
                        }
                        if ($state === false) {
                            return __('user.filters.unverified_indicator');
                        }
                        return null;
                    }),

                // Registration Date Range Filter
                Filters\Filter::make('registration_date')
                    ->form([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\DatePicker::make('registered_from')
                                    ->label(__('user.filters.registered_from'))
                                    ->placeholder(__('user.filters.select_date')),
                                Forms\Components\DatePicker::make('registered_until')
                                    ->label(__('user.filters.registered_until'))
                                    ->placeholder(__('user.filters.select_date')),
                            ])
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['registered_from'] ?? null,
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date)
                            )
                            ->when(
                                $data['registered_until'] ?? null,
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date)
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['registered_from'] ?? null) {
                            $indicators[] = __('user.filters.registered_from_indicator', ['date' => $data['registered_from']]);
                        }
                        if ($data['registered_until'] ?? null) {
                            $indicators[] = __('user.filters.registered_until_indicator', ['date' => $data['registered_until']]);
                        }
                        return $indicators;
                    }),

                // Users with Cars Filter
                Filters\TernaryFilter::make('has_cars')
                    ->label(__('user.filters.has_cars'))
                    ->placeholder(__('user.filters.all_users_cars'))
                    ->trueLabel(__('user.filters.users_with_cars'))
                    ->falseLabel(__('user.filters.users_without_cars'))
                    ->queries(
                        true: fn (Builder $query) => $query->whereHas('cars'),
                        false: fn (Builder $query) => $query->whereDoesntHave('cars'),
                        blank: fn (Builder $query) => $query,
                    ),

                // Car Count Range Filter
                Filters\Filter::make('car_count')
                    ->label(__('user.filters.car_count'))
                    ->form([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('min_cars')
                                    ->label(__('user.filters.min_cars'))
                                    ->numeric()
                                    ->placeholder('0'),
                                Forms\Components\TextInput::make('max_cars')
                                    ->label(__('user.filters.max_cars'))
                                    ->numeric()
                                    ->placeholder('∞'),
                            ])
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->withCount('cars')
                            ->when(
                                $data['min_cars'] ?? null,
                                fn (Builder $query, $min): Builder => $query->having('cars_count', '>=', $min)
                            )
                            ->when(
                                $data['max_cars'] ?? null,
                                fn (Builder $query, $max): Builder => $query->having('cars_count', '<=', $max)
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['min_cars'] ?? null) {
                            $indicators[] = __('user.filters.min_cars_indicator', ['count' => $data['min_cars']]);
                        }
                        if ($data['max_cars'] ?? null) {
                            $indicators[] = __('user.filters.max_cars_indicator', ['count' => $data['max_cars']]);
                        }
                        return $indicators;
                    }),
            ], layout: FiltersLayout::AboveContent)
            ->filtersFormColumns(3)
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
