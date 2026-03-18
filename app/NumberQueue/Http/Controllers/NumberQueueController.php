<?php

namespace App\NumberQueue\Http\Controllers;

use App\NumberQueue\Actions\ConvertNextNumber\ConvertNextNumberAction;
use App\NumberQueue\Actions\ConvertNextNumber\Data\ConvertNextNumberData;
use App\NumberQueue\Actions\StoreNumber\Data\StoreNumberData;
use App\NumberQueue\Actions\StoreNumber\StoreNumberAction;
use App\NumberQueue\Http\Requests\NumberQueueShowRequest;
use App\NumberQueue\Http\Requests\NumberQueueStoreRequest;
use App\Shared\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class NumberQueueController extends Controller
{
    public function store(NumberQueueStoreRequest $request, StoreNumberAction $storeNumberAction): JsonResponse
    {
        $data = StoreNumberData::fromRequest($request);

        try {
            $storeNumberAction->execute($data);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->json(['message' => 'Number added'], 201);
    }

    public function show(NumberQueueShowRequest $request, ConvertNextNumberAction $convertNextNumberAction): JsonResponse
    {
        $data = ConvertNextNumberData::fromRequest($request);

        try {
            $text = $convertNextNumberAction->execute($data);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($text === null) {
            return response()->json(['message' => 'No numbers available in queue'], 404);
        }

        return response()->json([
            'text' => $text,
        ]);
    }
}
