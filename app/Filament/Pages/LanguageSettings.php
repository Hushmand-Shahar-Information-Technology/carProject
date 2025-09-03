<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Session;

class LanguageSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-language';
    protected static ?int $navigationSort = 99;
    protected static string $view = 'filament.pages.language-settings';
    
    public ?string $locale = null;

    public static function getNavigationLabel(): string
    {
        return __('common.navigation.language');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('common.navigation.settings');
    }

    public function mount(): void
    {
        $this->locale = app()->getLocale();
        $this->form->fill([
            'locale' => $this->locale,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('locale')
                    ->label(__('common.labels.language'))
                    ->options([
                        'en' => 'English',
                        'ps' => 'پښتو (Pashto)',
                        'fa' => 'دری (Dari)',
                    ])
                    ->required()
                    ->native(false)
                    ->live()
                    ->afterStateUpdated(function (string $state) {
                        $this->changeLanguage($state);
                    }),
            ]);
    }

    public function changeLanguage(string $locale): void
    {
        if (in_array($locale, ['en', 'ps', 'fa'])) {
            Session::put('locale', $locale);
            app()->setLocale($locale);
            
            Notification::make()
                ->title(__('common.messages.language_changed'))
                ->success()
                ->send();
                
            $this->redirect(request()->header('Referer'));
        }
    }
}