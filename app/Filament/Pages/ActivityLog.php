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
                    ->label(__('common.labels.user'))
                    ->description(fn ($record) => $record->causer?->email)
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-m-user')
                    ->tooltip('User who performed the action'),
                TextColumn::make('subject_type')
                    ->label(__('common.labels.model'))71
                    
                    ->formatStateUsing(fn (string $state): string => class_basename($state))
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-m-cube')
                    ->tooltip('Model type that was affected'),
                BadgeColumn::make('event')
                    ->label(__('common.labels.event'))
                    ->colors([
                        'success' => 'created',
                        'warning' => 'updated',
                        'danger' => 'deleted',
                        'info' => 'restored',
                    ])
                    ->icons([
                        'heroicon-m-plus-circle' => 'created',
                        'heroicon-m-pencil-square' => 'updated',
                        'heroicon-m-trash' => 'deleted',
                        'heroicon-m-arrow-path' => 'restored',
                    ])
                    ->searchable()
                    ->sortable()
                    ->tooltip('Type of action performed'),
                TextColumn::make('description')
                    ->label(__('common.labels.description'))
                    ->searchable()
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->description)
                    ->wrap(),
                TextColumn::make('created_at')
                    ->label(__('common.labels.date_time'))
                    ->dateTime('M j, Y \\a\\t g:i A')
                    ->sortable()
                    ->icon('heroicon-m-clock')
                    ->tooltip('When the action occurred'),
                IconColumn::make('has_subject')
                    ->label(__('common.labels.has_record'))
                    ->boolean()
                    ->getStateUsing(fn ($record) => $record->subject !== null)
                    ->tooltip('Whether the affected record still exists'),
            ])
            ->filters([
                SelectFilter::make('event')
                    ->label(__('common.labels.event_type'))
                    ->options([
                        'created' => 'Created',
                        'updated' => 'Updated',
                        'deleted' => 'Deleted',
                        'restored' => 'Restored',
                    ])
                    ->placeholder(__('common.messages.select_event_type'))
                    ->multiple()
                    ->indicator(__('common.labels.event')),
                SelectFilter::make('subject_type')
                    ->label(__('common.labels.model_type'))
                    ->options($this->getModelTypes())
                    ->searchable()
                    ->placeholder(__('common.messages.select_model_type'))
                    ->indicator(__('common.labels.model')),
                Filter::make('created_at')
                    ->label(__('common.labels.date_range'))
                    ->form([
                        DatePicker::make('created_from')
                            ->label(__('common.labels.from'))
                            ->placeholder(__('Start date')),
                        DatePicker::make('created_until')
                            ->label(__('common.labels.to'))
                            ->placeholder(__('End date')),
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
                            $indicators['from'] = 'From ' . \Carbon\Carbon::parse($data['created_from'])->format('M j, Y');
                        }
                        
                        if ($data['created_until'] ?? null) {
                            $indicators['to'] = 'To ' . \Carbon\Carbon::parse($data['created_until'])->format('M j, Y');
                        }
                        
                        return $indicators;
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label(__('common.actions.view'))
                    ->tooltip('View activity details'),
            ])
            ->bulkActions([
                // No bulk actions for activity logs
            ])
            ->emptyStateHeading(__('common.messages.no_records'))
            ->emptyStateDescription(__('common.messages.view_all_activities'))
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