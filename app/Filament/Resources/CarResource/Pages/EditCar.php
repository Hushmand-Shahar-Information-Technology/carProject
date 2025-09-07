<?php

namespace App\Filament\Resources\CarResource\Pages;

use App\Filament\Resources\CarResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCar extends EditRecord
{
    protected static string $resource = CarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\Action::make('activities')
                ->label(__('common.actions.activities'))
                ->url(fn ($record) => CarResource::getUrl('activities', ['record' => $record]))
                ->icon('heroicon-o-clipboard-document-list'),
            Actions\DeleteAction::make(),
        ];
    }
}