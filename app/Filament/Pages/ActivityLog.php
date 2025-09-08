<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Spatie\Activitylog\Models\Activity;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DatePicker;

class ActivityLog extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationGroup = 'System';

    protected static ?int $navigationSort = 3;

    protected static string $view = 'filament.pages.activity-log';

    public function getTitle(): string
    {
        return __('common.navigation.activity_log');
    }

    public static function getNavigationLabel(): string
    {
        return __('common.navigation.activity_log');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Activity::query())
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('causer.name')
                    ->label('User')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('subject_type')
                    ->label('Model')
                    ->formatStateUsing(fn (string $state): string => class_basename($state))
                    ->searchable()
                    ->sortable(),
                BadgeColumn::make('event')
                    ->label('Event')
                    ->colors([
                        'success' => 'created',
                        'warning' => 'updated',
                        'danger' => 'deleted',
                    ])
                    ->searchable()
                    ->sortable(),
                TextColumn::make('description')
                    ->label('Description')
                    ->searchable()
                    ->limit(50),
                TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('event')
                    ->options([
                        'created' => 'Created',
                        'updated' => 'Updated',
                        'deleted' => 'Deleted',
                    ]),
                SelectFilter::make('subject_type')
                    ->label('Model')
                    ->options($this->getModelTypes())
                    ->searchable(),
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from'),
                        DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                // No bulk actions for activity logs
            ]);
    }

    protected function getModelTypes(): array
    {
        $types = Activity::select('subject_type')
            ->distinct()
            ->pluck('subject_type')
            ->toArray();

        $options = [];
        foreach ($types as $type) {
            if ($type) {
                $options[$type] = class_basename($type);
            }
        }

        return $options;
    }
}