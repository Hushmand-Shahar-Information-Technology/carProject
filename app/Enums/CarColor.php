<?php

namespace App\Enums;

class CarColor
{
    public const BLACK = 'black';
    public const WHITE = 'white';
    public const GRAY = 'gray';
    public const SILVER = 'silver';
    public const NAVY = 'navy';
    public const BLUE = 'blue';
    public const GOLD = 'gold';
    public const YELLOW = 'yellow';
    public const RED = 'red';
    public const GREEN = 'green';
    public const BROWN = 'brown';
    public const CHESTNUT = 'chestnut';
    public const ORANGE = 'orange';
    public const PURPLE = 'purple';
    public const CORAL = 'coral';
    public const RUBY = 'ruby';
    public const SKY_BLUE = 'sky_blue';
    public const OLIVE = 'olive';
    public const TURQUOISE = 'turquoise';
    public const ICE = 'ice';

    // Get multilingual labels for colors
    public static function labels(): array
    {
        $locale = app()->getLocale();
        
        $labels = [
            'en' => [
                self::BLACK => 'Black',
                self::WHITE => 'White',
                self::GRAY => 'Gray',
                self::SILVER => 'Silver',
                self::NAVY => 'Navy',
                self::BLUE => 'Blue',
                self::GOLD => 'Gold',
                self::YELLOW => 'Yellow',
                self::RED => 'Red',
                self::GREEN => 'Green',
                self::BROWN => 'Brown',
                self::CHESTNUT => 'Chestnut',
                self::ORANGE => 'Orange',
                self::PURPLE => 'Purple',
                self::CORAL => 'Coral',
                self::RUBY => 'Ruby',
                self::SKY_BLUE => 'Sky Blue',
                self::OLIVE => 'Olive',
                self::TURQUOISE => 'Turquoise',
                self::ICE => 'Ice',
            ],
            'fa' => [
                self::BLACK => 'سیاه',
                self::WHITE => 'سفید',
                self::GRAY => 'خاکستری',
                self::SILVER => 'نقره‌ای',
                self::NAVY => 'سرمه‌ای',
                self::BLUE => 'آبی',
                self::GOLD => 'طلایی',
                self::YELLOW => 'زرد',
                self::RED => 'قرمز',
                self::GREEN => 'سبز',
                self::BROWN => 'قهوه‌ای',
                self::CHESTNUT => 'قهوه‌ای سوخته',
                self::ORANGE => 'نارنجی',
                self::PURPLE => 'بنفش',
                self::CORAL => 'مرجانی',
                self::RUBY => 'یاقوتی',
                self::SKY_BLUE => 'آبی آسمانی',
                self::OLIVE => 'زیتونی',
                self::TURQUOISE => 'فیروزه‌ای',
                self::ICE => 'یخی',
            ],
            'ps' => [
                self::BLACK => 'توره',
                self::WHITE => 'سپین',
                self::GRAY => 'خړ',
                self::SILVER => 'وره',
                self::NAVY => 'دېری',
                self::BLUE => 'شین',
                self::GOLD => 'ذهري',
                self::YELLOW => 'زرغون',
                self::RED => 'سور',
                self::GREEN => 'زر',
                self::BROWN => 'شاکولي',
                self::CHESTNUT => 'پسته ای',
                self::ORANGE => 'لېمو',
                self::PURPLE => 'ارغوانی',
                self::CORAL => 'مرجان',
                self::RUBY => 'یاقوت',
                self::SKY_BLUE => 'آسمانی شین',
                self::OLIVE => 'زیتون',
                self::TURQUOISE => 'فیروزه',
                self::ICE => 'یخ',
            ],
        ];
        
        return $labels[$locale] ?? $labels['en'];
    }

    // Get label by value and locale
    public static function label(string $value): string
    {
        return self::labels()[$value] ?? $value;
    }

    // Get all color values as array
    public static function values(): array
    {
        return array_keys(self::labels());
    }
}