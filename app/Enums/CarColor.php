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

    // Get Persian labels for colors
    public static function labels(): array
    {
        return [
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
        ];
    }

    // Get Persian label by value
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
