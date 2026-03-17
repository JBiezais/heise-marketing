<?php

namespace App\NumberQueue\Services\NumberQueueToTextConversion\Data;

use App\NumberQueue\Http\Requests\NumberQueueShowRequest;
use App\NumberQueue\Services\NumberQueueToTextConversion\Enums\NumberQueueLocaleEnum;

final readonly class NumberQueueToTextConversionData
{
    public function __construct(
        public NumberQueueLocaleEnum $locale
    ) {}

    public static function fromRequest(NumberQueueShowRequest $request): self
    {
        $data = $request->validated();
        $localeValue = data_get($data, 'locale', 'en');

        return new self(
            NumberQueueLocaleEnum::tryFrom($localeValue) ?? NumberQueueLocaleEnum::EN
        );
    }
}
