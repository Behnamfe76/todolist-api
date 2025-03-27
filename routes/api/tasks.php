<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\TaskController;


Route::prefix('/tasks')->middleware('auth:sanctum')->group(function () {
    Route::post('/', [TaskController::class, 'store']);
    Route::get('/', [TaskController::class, 'index']);
    Route::get('/{task:uuid}', [TaskController::class, 'show']);
    Route::delete('/{task:uuid}', [TaskController::class, 'deleteTask']);
    Route::patch('/{task:uuid}/update-type', [TaskController::class, 'updateType']);
    Route::patch('/{task:uuid}/update-status', [TaskController::class, 'updateStatus']);
    Route::patch('/{task:uuid}/update-priority', [TaskController::class, 'updatePriority']);
    Route::patch('/{task:uuid}/update-info', [TaskController::class, 'updateInfo']);

    Route::prefix('/sub-tasks')->group(function () {
        Route::get('/{task:uuid}', [TaskController::class, 'getSubTasks']);
        Route::post('/{task:uuid}', [TaskController::class, 'storeSubTask']);
        Route::patch('/{subTask:uuid}', [TaskController::class, 'changeSubTaskStatus']);
        Route::delete('/{subTask:uuid}', [TaskController::class, 'deleteSubTask']);
    });
});
