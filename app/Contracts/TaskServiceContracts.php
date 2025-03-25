<?php

namespace App\Contracts;

use App\Data\TaskData;
use App\Http\Requests\V1\TaskStoreRequest;
use Exception;
use Throwable;

interface TaskServiceContracts{

    /**
     * @param TaskStoreRequest $request
     * @return TaskData|Throwable|Exception
     */
    public function store(TaskStoreRequest $request): TaskData|Throwable|Exception;
}
