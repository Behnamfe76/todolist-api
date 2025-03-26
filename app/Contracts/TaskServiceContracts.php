<?php

namespace App\Contracts;

use App\Http\Requests\V1\TaskPriorityUpdateRequest;
use App\Http\Requests\V1\TaskStatusUpdateRequest;
use Exception;
use Throwable;
use App\Models\Task;
use App\Data\TaskData;
use Illuminate\Http\Request;
use App\Http\Requests\V1\TaskStoreRequest;
use App\Http\Requests\V1\TaskTypeUpdateRequest;
use Illuminate\Pagination\LengthAwarePaginator;

interface TaskServiceContracts{

    /**
     * @param Request $request
     * @return Throwable|Exception|LengthAwarePaginator
     */
    public function index(Request $request): Throwable|Exception|LengthAwarePaginator;

    /**
     * @param TaskStoreRequest $request
     * @return TaskData|Throwable|Exception
     */
    public function store(TaskStoreRequest $request): TaskData|Throwable|Exception;

    /**
     * @param TaskTypeUpdateRequest $request
     * @param Task $task
     * @return Throwable|Exception|bool
     */
    public function updateType(TaskTypeUpdateRequest $request, Task $task): Throwable|Exception|bool;

    /**
     * @param TaskStatusUpdateRequest $request
     * @param Task $task
     * @return Throwable|Exception|bool
     */
    public function updateStatus(TaskStatusUpdateRequest $request, Task $task): Throwable|Exception|bool;

    /**
     * @param TaskPriorityUpdateRequest $request
     * @param Task $task
     * @return Throwable|Exception|bool
     */
    public function updatePriority(TaskPriorityUpdateRequest $request, Task $task): Throwable|Exception|bool;
}
