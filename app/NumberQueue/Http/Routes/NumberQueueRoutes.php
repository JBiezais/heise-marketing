<?php

use App\NumberQueue\Http\Controllers\NumberQueueController;
use Illuminate\Support\Facades\Route;

Route::prefix('api')->middleware('api')->group(function () {
    Route::post('numbers', [NumberQueueController::class, 'store']);
    Route::get('numbers', [NumberQueueController::class, 'show']);
});
