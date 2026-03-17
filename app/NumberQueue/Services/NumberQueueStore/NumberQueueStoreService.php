<?php

namespace App\NumberQueue\Services\NumberQueueStore;

use App\NumberQueue\Database\Models\NumberQueue;
use App\NumberQueue\Services\NumberQueueStore\Data\NumberQueueStoreData;

final class NumberQueueStoreService
{
    public function execute(NumberQueueStoreData $data): void
    {
        NumberQueue::create([
            'value' => $data->number,
        ]);
    }
}
