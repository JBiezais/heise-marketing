<?php

namespace App\NumberQueue\Actions\ConvertNextNumber\Enums;

use App\NumberQueue\Services\NumberToWordsConverter\EnglishNumberToWordsConverter;
use App\NumberQueue\Services\NumberToWordsConverter\LatvianNumberToWordsConverter;
use App\NumberQueue\Services\NumberToWordsConverter\NumberToWordsConverter;

enum NumberQueueLocale: string
{
    case EN = 'en';
    case LV = 'lv';

    public function getConverter(): NumberToWordsConverter
    {
        return match ($this) {
            self::EN => new EnglishNumberToWordsConverter,
            self::LV => new LatvianNumberToWordsConverter,
        };
    }
}
