<?php

namespace App\Http\Controllers\Api\V1;

use App\Contracts\TaskServiceContracts;
use App\Data\TaskData;
use App\Http\Requests\V1\TaskStoreRequest;
use App\Traits\ApiResponse;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{
    use ApiResponse;

    /**
     * @param TaskServiceContracts $taskService
     */
    public function __construct(
        private readonly TaskServiceContracts $taskService
    ){}

    /**
     * @param TaskStoreRequest $request
     * @return JsonResponse
     */
    public function store(TaskStoreRequest $request): \Illuminate\Http\JsonResponse
    {
        $result = $this->taskService->store($request);

        if($result instanceof \Throwable){
            return $this->errorResponse('server error', 500);
        }

        return $this->successResponse($result, 'task created successfully', 201);
    }
}
