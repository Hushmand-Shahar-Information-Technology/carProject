<?php

namespace App\enum;

enum TransmissionType: String
{
    case  manual = "manual";
    case  automatic= "automatic"; 
    case semiAutomatic = "semi-automatic";    
        public static function values(): array
    {
        return array_map(fn($item) => $item->value, self::cases());
    }
}