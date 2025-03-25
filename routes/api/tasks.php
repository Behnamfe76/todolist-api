<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\TaskController;


Route::prefix('/tasks')->middleware('auth:sanctum')->group(function () {
    Route::post('/', [TaskController::class, 'store']);
});
