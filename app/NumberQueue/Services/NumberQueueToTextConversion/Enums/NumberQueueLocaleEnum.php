<?php

namespace App\NumberQueue\Services\NumberQueueToTextConversion\Enums;

use App\NumberQueue\Services\NumberQueueToTextConversion\Services\EnglishNumberConverter;
use App\NumberQueue\Services\NumberQueueToTextConversion\Services\Interface\LocaleNumberConverterInterface;

enum NumberQueueLocaleEnum: string
{
    case EN = 'en';

    public function getConverter(): LocaleNumberConverterInterface
    {
        return match ($this) {
            self::EN => new EnglishNumberConverter,
        };
    }
}
