<?php

namespace App\NumberQueue\Services\NumberToWordsConverter;

use NumberToWords\NumberToWords;

class EnglishNumberToWordsConverter implements NumberToWordsConverter
{
    public function convert(int $number): string
    {
        $numberToWords = new NumberToWords;
        $transformer = $numberToWords->getNumberTransformer('en');
        $words = $transformer->toWords($number);

        return ucfirst($words);
    }
}
