<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class TestTranslations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:translations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the translation files for all supported locales';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $locales = ['en', 'ps', 'fa'];
        
        $this->info('Testing translations for all locales...');
        $this->newLine();
        
        foreach ($locales as $locale) {
            App::setLocale($locale);
            $this->info("Testing locale: {$locale}");
            
            // Test common translations
            $this->line("Common - Dashboard: " . __('common.navigation.dashboard'));
            $this->line("Common - Language: " . __('common.navigation.language'));
            $this->line("Common - View Action: " . __('common.actions.view'));
            
            // Test car translations
            $this->line("Car - Title: " . __('car.title'));
            $this->line("Car - Navigation Label: " . __('car.navigation_label'));
            $this->line("Car - Year Field: " . __('car.fields.year'));
            
            // Test user translations
            $this->line("User - Title: " . __('user.title'));
            $this->line("User - Name Field: " . __('user.fields.name'));
            
            $this->newLine();
        }
        
        $this->info('Translation test completed!');
        return 0;
    }
}