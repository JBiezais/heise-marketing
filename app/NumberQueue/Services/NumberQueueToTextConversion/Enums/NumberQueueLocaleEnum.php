<?php

namespace App\NumberQueue\Services\NumberQueueToTextConversion\Enums;

use App\NumberQueue\Services\NumberQueueToTextConversion\Services\EnglishNumberConverter;
use App\NumberQueue\Services\NumberQueueToTextConversion\Services\Interface\LocaleNumberConverterInterface;
use App\NumberQueue\Services\NumberQueueToTextConversion\Services\LatvianNumberConverter;

enum NumberQueueLocaleEnum: string
{
    case EN = 'en';
    case LV = 'lv';

    public function getConverter(): LocaleNumberConverterInterface
    {
        return match ($this) {
            self::EN => new EnglishNumberConverter,
            self::LV => new LatvianNumberConverter,
        };
    }
}
