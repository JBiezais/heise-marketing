<?php

namespace App\NumberQueue\Services\NumberQueueStore\Data;

use App\NumberQueue\Http\Requests\NumberQueueStoreRequest;

class NumberQueueStoreData
{
    public function __construct(
        public readonly int $number
    ) {}

    public static function fromRequest(NumberQueueStoreRequest $request): self
    {
        $data = $request->validated();

        return new self(
            number: $data['number']
        );
    }
}
