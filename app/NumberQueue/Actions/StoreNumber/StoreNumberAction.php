<?php

namespace App\NumberQueue\Actions\StoreNumber;

use App\NumberQueue\Actions\StoreNumber\Data\StoreNumberData;
use App\NumberQueue\Database\Models\NumberQueue;

final class StoreNumberAction
{
    public function execute(StoreNumberData $data): void
    {
        NumberQueue::create([
            'value' => $data->number,
        ]);
    }
}
