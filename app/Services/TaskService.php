<?php

namespace App\Services;

use App\Contracts\TaskRepositoryContracts;
use App\Contracts\TaskServiceContracts;
use App\Data\TaskData;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class TaskService implements TaskServiceContracts{
    public function __construct(
        private readonly  TaskRepositoryContracts $taskRepository,
    ){}

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
}
