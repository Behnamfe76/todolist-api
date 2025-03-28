<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\SubTask;
use App\Models\Task;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Contracts\TaskServiceContracts;
use App\Http\Resources\V1\TaskResource;
use App\Http\Requests\V1\TaskStoreRequest;
use App\Http\Requests\V1\TaskUpdateRequest;
use App\Http\Requests\V1\SubTaskStoreRequest;
use App\Http\Requests\V1\TaskTypeUpdateRequest;
use App\Http\Requests\V1\TaskStatusUpdateRequest;
use App\Http\Requests\V1\TaskPriorityUpdateRequest;

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
        // Check if the task belongs to the authenticated user
        if ($task->user_id !== auth()->id()) {
            return $this->errorResponse('Unauthorized access', 403);
        }

        return $this->successResponse(new TaskResource($task->load(['user', 'subTasks'])), 'task found successfully', 200);
    }

    /**
     * @param TaskTypeUpdateRequest $request
     * @param Task $task
     * @return JsonResponse
     */
    public function updateType(TaskTypeUpdateRequest $request, Task $task): JsonResponse
    {
        // Check if the task belongs to the authenticated user
        if ($task->user_id !== auth()->id()) {
            return $this->errorResponse('Unauthorized access', 403);
        }

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
        // Check if the task belongs to the authenticated user
        if ($task->user_id !== auth()->id()) {
            return $this->errorResponse('Unauthorized access', 403);
        }

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
        // Check if the task belongs to the authenticated user
        if ($task->user_id !== auth()->id()) {
            return $this->errorResponse('Unauthorized access', 403);
        }

        $result = $this->taskService->updatePriority($request, $task);

        if ($result instanceof \Throwable) {
            return $this->errorResponse('server error', 500);
        }

        return $this->successResponse(new TaskResource($task->load(['user', 'subTasks'])), 'task priority updated successfully', 200);
    }

    /**
     * @param TaskUpdateRequest $request
     * @param Task $task
     * @return JsonResponse
     */
    public function updateInfo(TaskUpdateRequest $request, Task $task): JsonResponse
    {
        // Check if the task belongs to the authenticated user
        if ($task->user_id !== auth()->id()) {
            return $this->errorResponse('Unauthorized access', 403);
        }

        $result = $this->taskService->updateInfo($request, $task);

        if ($result instanceof \Throwable) {
            return $this->errorResponse('server error', 500);
        }

        return $this->successResponse(new TaskResource($task->load(['user', 'subTasks'])), 'task info updated successfully', 200);
    }

    /**
     * @param Task $task
     * @return JsonResponse
     */
    public function deleteTask(Task $task): JsonResponse
    {
        // Check if the task belongs to the authenticated user
        if ($task->user_id !== auth()->id()) {
            return $this->errorResponse('Unauthorized access', 403);
        }

        $task->delete();

        return $this->successResponse([], 'task deleted successfully', 200);
    }


    /**
     * @param SubTaskStoreRequest $request
     * @param Task $task
     * @return JsonResponse
     */
    public function storeSubTask(SubTaskStoreRequest $request, Task $task): \Illuminate\Http\JsonResponse
    {
        // Check if the task belongs to the authenticated user
        if ($task->user_id !== auth()->id()) {
            return $this->errorResponse('Unauthorized access', 403);
        }

        $result = $this->taskService->storeSubTask($request, $task);

        if ($result instanceof \Throwable) {
            return $this->errorResponse('server error', 500);
        }

        return $this->successResponse($result, 'sub task created successfully', 201);
    }

    /**
     * @param Task $task
     * @return JsonResponse
     */
    public function getSubTasks(Task $task): JsonResponse
    {
        // Check if the task belongs to the authenticated user
        if ($task->user_id !== auth()->id()) {
            return $this->errorResponse('Unauthorized access', 403);
        }

        $result = $this->taskService->getSubTasks($task);

        if ($result instanceof \Throwable) {
            return $this->errorResponse('server error', 500);
        }

        return $this->successResponse($result, 'all available tasks', 200);
    }

    /**
     * @param SubTask $subTask
     * @return JsonResponse
     */
    public function changeSubTaskStatus(SubTask $subTask): JsonResponse
    {
        // Check if the subtask belongs to the authenticated user
        if ($subTask->user_id !== auth()->id()) {
            return $this->errorResponse('Unauthorized access', 403);
        }

        $result = $this->taskService->changeSubTaskStatus($subTask);

        if ($result instanceof \Throwable) {
            return $this->errorResponse('server error', 500);
        }

        return $this->successResponse([], 'sub-task status changed successfully', 200);
    }

    /**
     * @param SubTask $subTask
     * @return JsonResponse
     */
    public function deleteSubTask(SubTask $subTask): JsonResponse
    {
        // Check if the subtask belongs to the authenticated user
        if ($subTask->user_id !== auth()->id()) {
            return $this->errorResponse('Unauthorized access', 403);
        }

        $subTask->delete();

        return $this->successResponse([], 'sub task deleted successfully', 200);
    }
}
