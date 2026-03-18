<?php

namespace Tests\Unit\NumberQueue\Services\NumberToWordsConverter;

use App\NumberQueue\Services\NumberToWordsConverter\EnglishNumberToWordsConverter;
use App\NumberQueue\Services\NumberToWordsConverter\NumberToWordsConverter;
use PHPUnit\Framework\TestCase;

class EnglishNumberToWordsConverterTest extends TestCase
{
    public function test_convert_returns_words_for_single_digit(): void
    {
        $converter = new EnglishNumberToWordsConverter;

        $this->assertSame('One', $converter->convert(1));
        $this->assertSame('Five', $converter->convert(5));
    }

    public function test_convert_returns_words_for_multiple_digits(): void
    {
        $converter = new EnglishNumberToWordsConverter;

        $this->assertSame('Forty-two', $converter->convert(42));
        $this->assertSame('One hundred', $converter->convert(100));
    }

    public function test_convert_implements_number_to_words_converter(): void
    {
        $converter = new EnglishNumberToWordsConverter;

        $this->assertInstanceOf(NumberToWordsConverter::class, $converter);
    }
}
