<?php

namespace App\Services;

use App\Contracts\TaskRepositoryContracts;
use App\Contracts\TaskServiceContracts;
use App\Data\TaskData;
use App\Enums\TaskPriorityEnum;
use App\Enums\TaskStatusEnum;
use App\Enums\TaskTypeEnum;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class TaskService implements TaskServiceContracts{
    public function __construct(
        private readonly  TaskRepositoryContracts $taskRepository,
    ){}

    /**
     * @param $request
     * @return Throwable|Exception|LengthAwarePaginator
     */
    public function index($request): Throwable|Exception|LengthAwarePaginator
    {
        try {
            return $this->taskRepository->getAllTasks($request);
        } catch (\Throwable $tr) {
            Log::error($tr->getMessage());

            return $tr;
        }
    }

    /**
     * @param $request
     * @return TaskData|Throwable|Exception
     */
    public function store($request): TaskData|Throwable|Exception
    {
        try{
            $task = $this->taskRepository->store(TaskData::fromRequest($request));

            return TaskData::fromModel($task);
        }catch (Throwable $tr){
            Log::error($tr->getMessage());

            return $tr;
        }
    }

    /**
     * @param $request
     * @param $task
     * @return Throwable|Exception|bool
     */
    public function updateType($request, $task): Throwable|Exception|bool
    {
        try {
            $type = TaskTypeEnum::from($request->get('type'));

            return $task->update([
                'type' => $type
            ]);
        } catch (Throwable $tr) {
            Log::error($tr->getMessage());

            return $tr;
        }
    }

    /**
     * @param $request
     * @param $task
     * @return Throwable|Exception|bool
     */
    public function updateStatus($request, $task): Throwable|Exception|bool
    {
        try {
            $status = TaskStatusEnum::from($request->get('status'));

            $conditions = [
                'status' => $status,
                'is_completed' => in_array($status, [TaskStatusEnum::DONE, TaskStatusEnum::EXPIRED]),
                'done_date' => in_array($status, [TaskStatusEnum::DONE, TaskStatusEnum::EXPIRED]) ? now() : null,
            ];

            return $task->update($conditions);
        } catch (Throwable $tr) {
            Log::error($tr->getMessage());

            return $tr;
        }
    }

    /**
     * @param $request
     * @param $task
     * @return Throwable|Exception|bool
     */
    public function updatePriority($request, $task): Throwable|Exception|bool
    {
        try {
            $priority = TaskPriorityEnum::from($request->get('priority'));

            return $task->update([
                'priority' => $priority
            ]);
        } catch (Throwable $tr) {
            Log::error($tr->getMessage());

            return $tr;
        }
    }
}
