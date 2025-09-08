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
use Filament\Tables\Columns\IconColumn;

class ActivityLog extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationGroup = 'تنظیمات';

    protected static ?int $navigationSort = 3;

    protected static string $view = 'filament.pages.activity-log';

    public function getTitle(): string
    {
        return __('activity_log.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('activity_log.navigation_label');
    }
    
    public static function getNavigationGroup(): string
    {
        return __('common.navigation.admin');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Activity::query())
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('causer.name')
                    ->label(__('activity_log.columns.user'))
                    ->description(fn ($record) => $record->causer?->email)
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-user')
                    ->tooltip(__('activity_log.tooltips.user')),
                TextColumn::make('subject_type')
                    ->label(__('activity_log.columns.model'))
                    ->formatStateUsing(fn (string $state): string => class_basename($state))
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-cube')
                    ->tooltip(__('activity_log.tooltips.model')),
                BadgeColumn::make('event')
                    ->label(__('activity_log.columns.event'))
                    ->colors([
                        'success' => 'created',
                        'warning' => 'updated',
                        'danger' => 'deleted',
                        'info' => 'restored',
                    ])
                    ->icons([
                        'heroicon-o-plus-circle' => 'created',
                        'heroicon-o-pencil-square' => 'updated',
                        'heroicon-o-trash' => 'deleted',
                        'heroicon-o-arrow-path' => 'restored',
                    ])
                    ->searchable()
                    ->sortable()
                    ->tooltip(__('activity_log.tooltips.event')),
                TextColumn::make('description')
                    ->label(__('activity_log.columns.description'))
                    ->searchable()
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->description)
                    ->wrap(),
                TextColumn::make('created_at')
                    ->label(__('activity_log.columns.date_time'))
                    ->dateTime('M j, Y \\a\\t g:i A')
                    ->sortable()
                    ->icon('heroicon-o-clock')
                    ->tooltip(__('activity_log.tooltips.date_time')),
                IconColumn::make('has_subject')
                    ->label(__('activity_log.columns.has_record'))
                    ->boolean()
                    ->getStateUsing(fn ($record) => $record->subject !== null)
                    ->tooltip(__('activity_log.tooltips.has_record')),
            ])
            ->filters([
                SelectFilter::make('event')
                    ->label(__('activity_log.filters.event_type'))
                    ->options([
                        'created' => __('activity_log.events.created'),
                        'updated' => __('activity_log.events.updated'),
                        'deleted' => __('activity_log.events.deleted'),
                        'restored' => __('activity_log.events.restored'),
                    ])
                    ->placeholder(__('activity_log.filters.select_event_type'))
                    ->multiple()
                    ->indicator(__('activity_log.columns.event')),
                SelectFilter::make('subject_type')
                    ->label(__('activity_log.filters.model_type'))
                    ->options($this->getModelTypes())
                    ->searchable()
                    ->placeholder(__('activity_log.filters.select_model_type'))
                    ->indicator(__('activity_log.columns.model')),
                Filter::make('created_at')
                    ->label(__('activity_log.filters.date_range'))
                    ->form([
                        DatePicker::make('created_from')
                            ->label(__('activity_log.filters.from'))
                            ->placeholder(__('activity_log.messages.start_date')),
                        DatePicker::make('created_until')
                            ->label(__('activity_log.filters.to'))
                            ->placeholder(__('activity_log.messages.end_date')),
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
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        
                        if ($data['created_from'] ?? null) {
                            $indicators['from'] = __('activity_log.indicators.from', ['date' => \Carbon\Carbon::parse($data['created_from'])->format('M j, Y')]);
                        }
                        
                        if ($data['created_until'] ?? null) {
                            $indicators['to'] = __('activity_log.indicators.to', ['date' => \Carbon\Carbon::parse($data['created_until'])->format('M j, Y')]);
                        }
                        
                        return $indicators;
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label(__('activity_log.actions.view'))
                    ->tooltip(__('activity_log.tooltips.view_details')),
            ])
            ->bulkActions([
                // No bulk actions for activity logs
            ])
            ->emptyStateHeading(__('activity_log.messages.no_records'))
            ->emptyStateDescription(__('activity_log.messages.view_all_activities'))
            ->emptyStateIcon('heroicon-o-clipboard-document-list');
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