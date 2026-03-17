<?php

namespace App\NumberQueue\Services\NumberQueueToTextConversion\Services\Interface;

interface LocaleNumberConverterInterface
{
    public function convert(int $number): string;
}
