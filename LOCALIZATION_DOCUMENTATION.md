# Filament Resources Localization Documentation

This document describes the implementation of multi-language support for Filament resources in Pashto, Dari, and English.

## Overview

The localization system has been implemented to support three languages:
- **English (en)** - Default language
- **Pashto (ps)** - پښتو
- **Dari (fa)** - دری

## File Structure

### Language Files
```
lang/
├── en/
│   ├── car.php          # Car resource translations
│   ├── user.php         # User resource translations
│   └── common.php       # Common translations
├── ps/
│   ├── car.php          # Car resource translations (Pashto)
│   ├── user.php         # User resource translations (Pashto)
│   └── common.php       # Common translations (Pashto)
└── fa/
    ├── car.php          # Car resource translations (Dari)
    ├── user.php         # User resource translations (Dari)
    └── common.php       # Common translations (Dari)
```

### New Components
```
app/
├── Console/Commands/
│   └── TestTranslations.php    # Command to test translations
├── Filament/Pages/
│   └── LanguageSettings.php    # Language switcher page
├── Http/Middleware/
│   └── SetLocale.php           # Locale middleware
└── Providers/Filament/
    └── AdminPanelProvider.php  # Updated panel configuration

resources/views/filament/pages/
└── language-settings.blade.php # Language settings view
```

## Features Implemented

### 1. Resource Localization
- **CarResource**: All labels, field names, navigation, and actions translated
- **UserResource**: All labels, field names, navigation, and actions translated
- **RoleResource**: Uses filament-shield translations (already multilingual)

### 2. Language Switching
- **Language Settings Page**: Accessible from admin panel navigation
- **Session-based**: Language preference stored in session
- **Instant switching**: Changes take effect immediately
- **Persistent**: Language choice remembered across sessions

### 3. Middleware Integration
- **SetLocale Middleware**: Automatically sets application locale based on session
- **Integrated with Filament**: Added to admin panel middleware stack

### 4. Translation Structure
Each resource has structured translations with:
- `title` - Singular resource name
- `plural` - Plural resource name
- `navigation_label` - Navigation menu label
- `navigation_group` - Navigation group name
- `fields` - All field labels
- `labels` - Additional labels and help text
- `pages` - Page titles
- `actions` - Action button labels

## Usage Instructions

### 1. Accessing Language Settings
1. Log into the admin panel
2. Navigate to "Language" in the main navigation
3. Select your preferred language from the dropdown
4. Changes apply immediately

### 2. Adding New Translations
To add translations for new fields or resources:

1. Update the appropriate language file in `lang/{locale}/`
2. Use the `__()` helper function in your Filament resources:
   ```php
   Forms\Components\TextInput::make('field_name')
       ->label(__('resource.fields.field_name'))
   ```

### 3. Testing Translations
Run the translation test command:
```bash
php artisan test:translations
```

## Language Support Details

### Pashto (پښتو)
- Script: Arabic/Persian script (right-to-left)
- Locale code: `ps`
- Font requirements: Supports Arabic/Persian fonts
- Character encoding: UTF-8

### Dari (دری) 
- Script: Arabic/Persian script (right-to-left)
- Locale code: `fa` 
- Font requirements: Supports Arabic/Persian fonts
- Character encoding: UTF-8

### English
- Script: Latin script (left-to-right)
- Locale code: `en`
- Default fallback language

## Technical Implementation

### Translation Keys Structure
```php
// Example from car.php
return [
    'title' => 'Car',
    'plural' => 'Cars',
    'navigation_label' => 'Cars',
    'navigation_group' => 'Vehicle Management',
    'fields' => [
        'title' => 'Title',
        'year' => 'Year',
        // ... more fields
    ],
    'actions' => [
        'view' => 'View',
        'edit' => 'Edit',
        'delete' => 'Delete',
    ],
];
```

### Resource Implementation Example
```php
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
```

## Maintenance

### Adding New Languages
1. Create new language directory: `lang/{locale}/`
2. Copy translation files from existing language
3. Translate all strings
4. Add locale to supported locales in `SetLocale` middleware
5. Update language dropdown in `LanguageSettings.php`

### Updating Translations
1. Modify the appropriate language file
2. Clear cache: `php artisan cache:clear`
3. Test with: `php artisan test:translations`

## Best Practices

1. **Consistent Keys**: Use the same translation keys across all languages
2. **Descriptive Keys**: Use clear, hierarchical key names
3. **Fallback**: English serves as the fallback language
4. **Testing**: Always test translations after changes
5. **Context**: Provide context for translators when needed

## Troubleshooting

### Common Issues
1. **Missing translations**: Check if translation key exists in all language files
2. **Cache issues**: Clear cache after translation updates
3. **Encoding issues**: Ensure all files are saved in UTF-8 encoding
4. **RTL display**: Ensure RTL languages display correctly in the interface

### Debug Commands
```bash
# Test translations
php artisan test:translations

# Clear caches
php artisan cache:clear
php artisan config:clear

# Check current locale
php artisan tinker
> app()->getLocale()
```

This implementation provides a robust, scalable localization system for the Filament admin panel supporting Pashto, Dari, and English languages.