<?php

namespace App\Enums;

enum TransmissionType: string
{
    case manual = 'manual';
    case automatic = 'automatic';

    public static function values(): array
    {
        return array_map(fn($item) => $item->value, self::cases());
    }
}
