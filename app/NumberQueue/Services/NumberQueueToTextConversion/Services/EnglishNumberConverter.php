<?php

namespace App\NumberQueue\Services\NumberQueueToTextConversion\Services;

use App\NumberQueue\Services\NumberQueueToTextConversion\Services\Interface\LocaleNumberConverterInterface;
use NumberToWords\NumberToWords;

class EnglishNumberConverter implements LocaleNumberConverterInterface
{
    public function convert(int $number): string
    {
        $numberToWords = new NumberToWords;
        $transformer = $numberToWords->getNumberTransformer('en');
        $words = $transformer->toWords($number);

        return ucfirst($words);
    }
}
