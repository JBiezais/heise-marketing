<?php

namespace App\NumberQueue\Actions\StoreNumber\Data;

use App\NumberQueue\Http\Requests\NumberQueueStoreRequest;

class StoreNumberData
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
