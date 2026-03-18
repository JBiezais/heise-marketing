<?php

namespace App\NumberQueue\Actions\ConvertNextNumber;

use App\NumberQueue\Actions\ConvertNextNumber\Data\ConvertNextNumberData;
use App\NumberQueue\Database\Models\NumberQueue;
use Illuminate\Support\Facades\DB;

class ConvertNextNumberAction
{
    public function execute(ConvertNextNumberData $data): ?string
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
