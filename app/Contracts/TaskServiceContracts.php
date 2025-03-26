<?php

namespace App\Contracts;

use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Throwable;
use App\Data\TaskData;
use Illuminate\Http\Request;
use App\Http\Requests\V1\TaskStoreRequest;

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
}
