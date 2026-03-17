<?php

namespace Tests\Unit\NumberQueue\Services;

use App\NumberQueue\Services\NumberQueueToTextConversion\Services\EnglishNumberConverter;
use App\NumberQueue\Services\NumberQueueToTextConversion\Services\Interface\LocaleNumberConverterInterface;
use PHPUnit\Framework\TestCase;

class EnglishNumberConverterTest extends TestCase
{
    public function test_convert_returns_words_for_single_digit(): void
    {
        $converter = new EnglishNumberConverter;

        $this->assertSame('One', $converter->convert(1));
        $this->assertSame('Five', $converter->convert(5));
    }

    public function test_convert_returns_words_for_multiple_digits(): void
    {
        $converter = new EnglishNumberConverter;

        $this->assertSame('Forty-two', $converter->convert(42));
        $this->assertSame('One hundred', $converter->convert(100));
    }

    public function test_convert_implements_locale_converter_interface(): void
    {
        $converter = new EnglishNumberConverter;

        $this->assertInstanceOf(LocaleNumberConverterInterface::class, $converter);
    }
}
