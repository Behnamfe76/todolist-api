<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\TaskController;


Route::prefix('/tasks')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [TaskController::class, 'index']);
    Route::get('/{task:uuid}', [TaskController::class, 'show']);
    Route::patch('/{task:uuid}/update-type', [TaskController::class, 'updateType']);
    Route::patch('/{task:uuid}/update-status', [TaskController::class, 'updateStatus']);
    Route::patch('/{task:uuid}/update-priority', [TaskController::class, 'updatePriority']);
    Route::post('/', [TaskController::class, 'store']);
});
