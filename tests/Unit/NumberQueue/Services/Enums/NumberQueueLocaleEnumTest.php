<?php

namespace Tests\Unit\NumberQueue\Services\Enums;

use App\NumberQueue\Services\NumberQueueToTextConversion\Enums\NumberQueueLocaleEnum;
use App\NumberQueue\Services\NumberQueueToTextConversion\Services\Interface\LocaleNumberConverterInterface;
use PHPUnit\Framework\TestCase;

class NumberQueueLocaleEnumTest extends TestCase
{
    public function test_get_converter_returns_locale_converter_interface(): void
    {
        $converter = NumberQueueLocaleEnum::EN->getConverter();

        $this->assertInstanceOf(LocaleNumberConverterInterface::class, $converter);
    }

    public function test_get_converter_returns_working_converter(): void
    {
        $converter = NumberQueueLocaleEnum::EN->getConverter();

        $this->assertSame('One', $converter->convert(1));
    }
}
