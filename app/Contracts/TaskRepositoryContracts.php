<?php

namespace App\Contracts;

use App\Data\TaskData;
use App\Models\Task;
use Exception;
use Throwable;

interface TaskRepositoryContracts{
    /**
     * @param TaskData $data
     * @return Task|Throwable|Exception
     */
    public function store(TaskData $data): Task|Throwable|Exception;
}
