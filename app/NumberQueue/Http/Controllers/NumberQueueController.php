<?php

namespace App\NumberQueue\Http\Controllers;

use App\NumberQueue\Http\Requests\NumberQueueShowRequest;
use App\NumberQueue\Http\Requests\NumberQueueStoreRequest;
use App\NumberQueue\Services\NumberQueueStore\Data\NumberQueueStoreData;
use App\NumberQueue\Services\NumberQueueStore\NumberQueueStoreService;
use App\NumberQueue\Services\NumberQueueToTextConversion\Data\NumberQueueToTextConversionData;
use App\NumberQueue\Services\NumberQueueToTextConversion\NumberQueueToTextConversionService;
use App\Shared\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class NumberQueueController extends Controller
{
    public function store(NumberQueueStoreRequest $request, NumberQueueStoreService $numberQueueService): JsonResponse
    {
        $data = NumberQueueStoreData::fromRequest($request);

        try {
            $numberQueueService->execute($data);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->json(['message' => 'Number added'], 201);
    }

    public function show(NumberQueueShowRequest $request, NumberQueueToTextConversionService $numberQueueToTextConversionService): JsonResponse
    {
        $data = NumberQueueToTextConversionData::fromRequest($request);

        try {
            $text = $numberQueueToTextConversionService->execute($data);
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
