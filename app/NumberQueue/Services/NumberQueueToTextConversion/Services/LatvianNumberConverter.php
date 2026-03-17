<?php

namespace App\NumberQueue\Services\NumberQueueToTextConversion\Services;

use App\NumberQueue\Services\NumberQueueToTextConversion\Services\Interface\LocaleNumberConverterInterface;
use Illuminate\Support\Str;

class LatvianNumberConverter implements LocaleNumberConverterInterface
{
    private const UNITS = [
        0 => '',
        1 => 'viens',
        2 => 'divi',
        3 => 'trīs',
        4 => 'četri',
        5 => 'pieci',
        6 => 'seši',
        7 => 'septiņi',
        8 => 'astoņi',
        9 => 'deviņi',
    ];

    private const TEENS = [
        0 => 'desmit',
        1 => 'vienpadsmit',
        2 => 'divpadsmit',
        3 => 'trīspadsmit',
        4 => 'četrpadsmit',
        5 => 'piecpadsmit',
        6 => 'sešpadsmit',
        7 => 'septiņpadsmit',
        8 => 'astoņpadsmit',
        9 => 'deviņpadsmit',
    ];

    private const TENS = [
        1 => 'desmit',
        2 => 'divdesmit',
        3 => 'trīsdesmit',
        4 => 'četrdesmit',
        5 => 'piecdesmit',
        6 => 'sešdesmit',
        7 => 'septiņdesmit',
        8 => 'astoņdesmit',
        9 => 'deviņdesmit',
    ];

    /** @var array<int, array{0: string, 1: string, 2: string}> [singular, plural 2-9, plural 11-19 and x0] */
    private const SCALES = [
        ['', '', ''],
        ['tūkstotis', 'tūkstoši', 'tūkstoši'],
        ['miljons', 'miljoni', 'miljoni'],
        ['miljards', 'miljardi', 'miljardi'],
        ['triljons', 'triljoni', 'triljoni'],
        ['kvadriljons', 'kvadriljoni', 'kvadriljoni'],
        ['kvintiljons', 'kvintiljoni', 'kvintiljoni'],
    ];

    public function convert(int $number): string
    {
        if ($number === 0) {
            return 'Nulle';
        }

        $triplets = collect($this->toTriplets($number));
        $powerCount = $triplets->count();

        $parts = $triplets
            ->filter(fn (int $triplet): bool => $triplet > 0)
            ->flatMap(function (int $triplet, int $i) use ($powerCount): array {
                $power = $powerCount - 1 - $i;
                $scale = $this->getScaleWord($triplet, $power);

                if ($triplet === 1 && $power > 0) {
                    return [$scale];
                }

                $result = [$this->tripletToWords($triplet)];
                if ($scale !== '') {
                    $result[] = $scale;
                }

                return $result;
            });

        return Str::ucfirst($parts->implode(' '));
    }

    /**
     * @return array<int>
     */
    private function toTriplets(int $number): array
    {
        $triplets = [];
        while ($number > 0) {
            $triplets[] = $number % 1000;
            $number = (int) ($number / 1000);
        }

        return array_reverse($triplets);
    }

    private function tripletToWords(int $number): string
    {
        $units = $number % 10;
        $tens = (int) ($number / 10) % 10;
        $hundreds = (int) ($number / 100) % 10;

        return collect([
            $hundreds > 0 ? ($hundreds === 1 ? 'simts' : self::UNITS[$hundreds].' simti') : null,
            $tens === 1 ? self::TEENS[$units] : ($tens > 1 ? self::TENS[$tens] : null),
            $units > 0 && $tens !== 1 ? self::UNITS[$units] : null,
        ])->filter()->implode(' ');
    }

    private function getScaleWord(int $triplet, int $power): string
    {
        if ($power === 0 || ! isset(self::SCALES[$power])) {
            return '';
        }

        $level = self::SCALES[$power];
        $units = $triplet % 10;
        $tens = (int) ($triplet / 10) % 10;

        if ($tens === 1 || ($tens > 0 && $units === 0)) {
            return $level[2];
        }
        if ($units > 1) {
            return $level[1];
        }

        return $level[0];
    }
}
