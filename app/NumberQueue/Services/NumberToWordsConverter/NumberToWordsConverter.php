<?php

namespace App\NumberQueue\Services\NumberToWordsConverter;

interface NumberToWordsConverter
{
    public function convert(int $number): string;
}
