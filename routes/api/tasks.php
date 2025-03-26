<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\TaskController;


Route::prefix('/tasks')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [TaskController::class, 'index']);
    Route::get('/{task:uuid}', [TaskController::class, 'show']);
    Route::patch('/{task:uuid}/update-type', [TaskController::class, 'updateType']);
    Route::post('/', [TaskController::class, 'store']);
});
