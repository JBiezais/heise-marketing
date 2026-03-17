<?php

namespace Tests\Unit\NumberQueue\Services;

use App\NumberQueue\Services\NumberQueueToTextConversion\Services\Interface\LocaleNumberConverterInterface;
use App\NumberQueue\Services\NumberQueueToTextConversion\Services\LatvianNumberConverter;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class LatvianNumberConverterTest extends TestCase
{
    public function test_convert_implements_locale_converter_interface(): void
    {
        $converter = new LatvianNumberConverter;

        $this->assertInstanceOf(LocaleNumberConverterInterface::class, $converter);
    }

    #[DataProvider('latvianConversionProvider')]
    public function test_convert_returns_correct_latvian_for_number(int $number, string $expected): void
    {
        $converter = new LatvianNumberConverter;

        $this->assertSame($expected, $converter->convert($number));
    }

    /**
     * @return array<int, array{0: int, 1: string}>
     */
    public static function latvianConversionProvider(): array
    {
        return [
            [0, 'Nulle'],
            [1, 'Viens'],
            [2, 'Divi'],
            [3, 'Trīs'],
            [4, 'Četri'],
            [5, 'Pieci'],
            [6, 'Seši'],
            [7, 'Septiņi'],
            [8, 'Astoņi'],
            [9, 'Deviņi'],
            [10, 'Desmit'],
            [11, 'Vienpadsmit'],
            [12, 'Divpadsmit'],
            [15, 'Piecpadsmit'],
            [19, 'Deviņpadsmit'],
            [20, 'Divdesmit'],
            [21, 'Divdesmit viens'],
            [30, 'Trīsdesmit'],
            [40, 'Četrdesmit'],
            [50, 'Piecdesmit'],
            [90, 'Deviņdesmit'],
            [99, 'Deviņdesmit deviņi'],
            [100, 'Simts'],
            [101, 'Simts viens'],
            [111, 'Simts vienpadsmit'],
            [123, 'Simts divdesmit trīs'],
            [200, 'Divi simti'],
            [300, 'Trīs simti'],
            [900, 'Deviņi simti'],
            [999, 'Deviņi simti deviņdesmit deviņi'],
            [1000, 'Tūkstotis'],
            [1001, 'Tūkstotis viens'],
            [2000, 'Divi tūkstoši'],
            [21000, 'Divdesmit viens tūkstotis'],
            [11000, 'Vienpadsmit tūkstoši'],
            [20000, 'Divdesmit tūkstoši'],
            [1000000, 'Miljons'],
            [2000000, 'Divi miljoni'],
            [1020000, 'Miljons divdesmit tūkstoši'],
            [1000000000, 'Miljards'],
            [1000000000000, 'Triljons'],
            [1000000000000000, 'Kvadriljons'],
            [1000000000000000000, 'Kvintiljons'],
            [999999, 'Deviņi simti deviņdesmit deviņi tūkstoši deviņi simti deviņdesmit deviņi'],
            [1174315110, 'Miljards simts septiņdesmit četri miljoni trīs simti piecpadsmit tūkstoši simts desmit'],
            [1174315119, 'Miljards simts septiņdesmit četri miljoni trīs simti piecpadsmit tūkstoši simts deviņpadsmit'],
            [2935174315119, 'Divi triljoni deviņi simti trīsdesmit pieci miljardi simts septiņdesmit četri miljoni trīs simti piecpadsmit tūkstoši simts deviņpadsmit'],
        ];
    }
}
