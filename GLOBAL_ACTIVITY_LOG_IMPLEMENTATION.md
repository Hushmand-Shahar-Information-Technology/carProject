# Global Activity Log Page Implementation

## Overview

This document describes the implementation of a global activity log page in the FilamentPHP admin panel. This page provides a centralized view of all activities across all models in the application.

## Implementation Details

### 1. Created Global Activity Log Page

Created `app/Filament/Pages/ActivityLog.php`:

```php
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
```

### 2. Created View Template

Created `resources/views/filament/pages/activity-log.blade.php`:

```blade
<x-filament-panels::page>
    {{ $this->table }}
</x-filament-panels::page>
```

### 3. Added Navigation Registration

Registered the page in `app/Providers/Filament/AdminPanelProvider.php`:

```php
->pages([
    CustomDashboard::class,
    LanguageSettings::class,
    ActivityLog::class, // Added global activity log page
])
```

### 4. Added Translations

Added 'activity_log' translation key to all language files:

**English (en/common.php):**
```php
'navigation' => [
    // ... existing navigation items
    'activity_log' => 'Activity Log',
],
```

**Persian (fa/common.php):**
```php
'navigation' => [
    // ... existing navigation items
    'activity_log' => 'لاگ فعالیت‌ها',
],
```

**Pashto (ps/common.php):**
```php
'navigation' => [
    // ... existing navigation items
    'activity_log' => 'د فعالیت لاگ',
],
```

## Features

- Shows all activities across all models in the application
- Displays created, updated, and deleted events
- Organized by timestamp with newest activities first
- Filterable by model type, event type, and date range
- Searchable by description or user
- Clean, user-friendly interface with colored badges for event types
- Supports all three languages (English, Persian, Pashto)

## Accessing the Global Activity Log

1. Navigate to the admin panel
2. Look for "Activity Log" in the "System" section of the navigation menu
3. Click on the "Activity Log" link to view all activities

## Requirements

- Spatie Laravel Activity Log package installed and configured
- Models must use the `LogsActivity` trait (already implemented through BaseModel)

## Technical Details

The global activity log page:
- Implements Filament's table interface
- Queries all activities from the Spatie Activity model
- Displays user, model type, event type, description, and timestamp
- Provides filtering by event type, model type, and date range using custom filter with date pickers
- Uses colored badges to visually distinguish event types
- Appears in the "System" navigation group
- Has a navigation sort order of 3
- Uses the clipboard-document-list icon
- Supports localization through the common translation files

## Verification

The implementation has been verified by:
1. Creating the ActivityLog page class with table implementation
2. Creating the view template
3. Registering it in the AdminPanelProvider
4. Adding translations for all supported languages
5. Clearing the Filament component cache

The global activity log page should now be accessible from the System section in the FilamentPHP admin panel.