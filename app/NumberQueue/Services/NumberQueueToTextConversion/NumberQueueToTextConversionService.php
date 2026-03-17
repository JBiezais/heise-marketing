<?php

namespace App\NumberQueue\Services\NumberQueueToTextConversion;

use App\NumberQueue\Database\Models\NumberQueue;
use App\NumberQueue\Services\NumberQueueToTextConversion\Data\NumberQueueToTextConversionData;
use Illuminate\Support\Facades\DB;

class NumberQueueToTextConversionService
{
    public function execute(NumberQueueToTextConversionData $data): ?string
    {
        $row = DB::transaction(function () {
            $row = NumberQueue::query()
                ->orderByDesc('id')
                ->lockForUpdate()
                ->first();

            if (! $row) {
                return null;
            }

            $row->delete();

            return $row;
        });

        if ($row === null) {
            return null;
        }

        $converter = $data->locale->getConverter();

        return $converter->convert($row->value);
    }
}
