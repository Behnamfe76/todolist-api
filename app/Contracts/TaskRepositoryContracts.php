<?php

namespace App\Contracts;

use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Throwable;
use App\Models\Task;
use App\Data\TaskData;
use Illuminate\Http\Request;

interface TaskRepositoryContracts{

    /**
     * @param Request $request
     * @return Throwable|Exception|LengthAwarePaginator
     */
    public function getAllTasks(Request $request): Throwable|Exception|LengthAwarePaginator;

    /**
     * @param TaskData $data
     * @return Task|Throwable|Exception
     */
    public function store(TaskData $data): Task|Throwable|Exception;
}
