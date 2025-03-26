<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\V1\TaskPriorityUpdateRequest;
use App\Http\Requests\V1\TaskStatusUpdateRequest;
use App\Models\Task;
use App\Data\TaskData;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Contracts\TaskServiceContracts;
use App\Http\Resources\V1\TaskResource;
use Illuminate\Container\Attributes\Auth;
use App\Http\Requests\V1\TaskStoreRequest;
use App\Http\Requests\V1\TaskTypeUpdateRequest;

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
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $result = $this->taskService->index($request);

        if ($result instanceof \Throwable) {
            return $this->errorResponse('server error', 500);
        }

        return $this->successResponse($result, 'all available tasks', 200);
    }

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

    /**
     * @param Task $task
     * @return JsonResponse
     */
    public function show(Task $task): JsonResponse
    {
        return $this->successResponse(new TaskResource($task->load(['user', 'subTasks'])), 'task found successfully', 200);
    }

    /**
     * @param TaskTypeUpdateRequest $request
     * @param Task $task
     * @return JsonResponse
     */
    public function updateType(TaskTypeUpdateRequest $request, Task $task): JsonResponse
    {
        $result = $this->taskService->updateType($request, $task);

        if ($result instanceof \Throwable) {
            return $this->errorResponse('server error', 500);
        }

        return $this->successResponse(new TaskResource($task->load(['user', 'subTasks'])), 'task type updated successfully', 200);
    }

    /**
     * @param TaskStatusUpdateRequest $request
     * @param Task $task
     * @return JsonResponse
     */
    public function updateStatus(TaskStatusUpdateRequest $request, Task $task): JsonResponse
    {
        $result = $this->taskService->updateStatus($request, $task);

        if ($result instanceof \Throwable) {
            return $this->errorResponse('server error', 500);
        }

        return $this->successResponse(new TaskResource($task->load(['user', 'subTasks'])), 'task status updated successfully', 200);
    }

    /**
     * @param TaskPriorityUpdateRequest $request
     * @param Task $task
     * @return JsonResponse
     */
    public function updatePriority(TaskPriorityUpdateRequest $request, Task $task): JsonResponse
    {
        $result = $this->taskService->updatePriority($request, $task);

        if ($result instanceof \Throwable) {
            return $this->errorResponse('server error', 500);
        }

        return $this->successResponse(new TaskResource($task->load(['user', 'subTasks'])), 'task priority updated successfully', 200);
    }

}
