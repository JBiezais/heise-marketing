<?php

namespace Tests\Unit\NumberQueue\Actions\ConvertNextNumber\Enums;

use App\NumberQueue\Actions\ConvertNextNumber\Enums\NumberQueueLocale;
use App\NumberQueue\Services\NumberToWordsConverter\NumberToWordsConverter;
use PHPUnit\Framework\TestCase;

class NumberQueueLocaleTest extends TestCase
{
    public function test_get_converter_returns_number_to_words_converter(): void
    {
        $converter = NumberQueueLocale::EN->getConverter();

        $this->assertInstanceOf(NumberToWordsConverter::class, $converter);
    }

    public function test_get_converter_returns_working_converter(): void
    {
        $converter = NumberQueueLocale::EN->getConverter();

        $this->assertSame('One', $converter->convert(1));
    }

    public function test_get_converter_returns_latvian_converter_for_lv(): void
    {
        $converter = NumberQueueLocale::LV->getConverter();

        $this->assertInstanceOf(NumberToWordsConverter::class, $converter);
        $this->assertSame('Viens', $converter->convert(1));
    }
}
