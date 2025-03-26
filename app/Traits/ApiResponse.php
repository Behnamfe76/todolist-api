<?php

namespace App\Traits;

use Spatie\LaravelData\Data;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Resources\Json\JsonResource;

trait ApiResponse
{

    /**
     * @param array|Data|LengthAwarePaginator|JsonResource $data
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    public function successResponse(array|Data|LengthAwarePaginator|JsonResource $data, string $message, int $code): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    /**
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    public function errorResponse(string $message, int $code): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
        ], $code);
    }
}
