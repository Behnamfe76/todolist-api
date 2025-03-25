<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Spatie\LaravelData\Data;

trait ApiResponse
{

    /**
     * @param array|Data $data
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    public function successResponse(array|Data $data, string $message, int $code): \Illuminate\Http\JsonResponse
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
