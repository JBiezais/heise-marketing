<?php

namespace App\NumberQueue\Actions\ConvertNextNumber\Data;

use App\NumberQueue\Actions\ConvertNextNumber\Enums\NumberQueueLocale;
use App\NumberQueue\Http\Requests\NumberQueueShowRequest;

final readonly class ConvertNextNumberData
{
    public function __construct(
        public NumberQueueLocale $locale
    ) {}

    public static function fromRequest(NumberQueueShowRequest $request): self
    {
        $data = $request->validated();
        $localeValue = data_get($data, 'locale', 'en');

        return new self(
            NumberQueueLocale::tryFrom($localeValue) ?? NumberQueueLocale::EN
        );
    }
}
