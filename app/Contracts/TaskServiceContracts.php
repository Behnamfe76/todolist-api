<?php

namespace App\Contracts;

use App\Models\SubTask;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Throwable;
use App\Models\Task;
use App\Data\TaskData;
use App\Data\SubTaskData;
use Illuminate\Http\Request;
use App\Http\Requests\V1\TaskStoreRequest;
use App\Http\Requests\V1\TaskUpdateRequest;
use App\Http\Requests\V1\SubTaskStoreRequest;
use App\Http\Requests\V1\TaskTypeUpdateRequest;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Requests\V1\TaskStatusUpdateRequest;
use App\Http\Requests\V1\TaskPriorityUpdateRequest;

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
     * @param SubTaskStoreRequest $request
     * @param Task $task
     * @return SubTaskData|Throwable|Exception
     */
    public function storeSubTask(SubTaskStoreRequest $request, Task $task): SubTaskData|Throwable|Exception;

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

    /**
     * @param TaskUpdateRequest $request
     * @param Task $task
     * @return Throwable|Exception|bool
     */
    public function updateInfo(TaskUpdateRequest $request, Task $task): Throwable|Exception|bool;

    /**
     * @param Task $task
     * @return Collection|Throwable|Exception
     */
    public function getSubTasks(Task $task): Collection|Throwable|Exception;

    /**
     * @param SubTask $subTask
     * @return Throwable|Exception|bool
     */
    public function changeSubTaskStatus(SubTask $subTask): Throwable|Exception|bool;
}
