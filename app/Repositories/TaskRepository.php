<?php

namespace App\Repositories;

use App\Contracts\TaskRepositoryContracts;
use App\Models\Task;
use Exception;
use Illuminate\Support\Facades\Log;
use Throwable;

class TaskRepository implements TaskRepositoryContracts{

    /**
     * @param $data
     * @return Task|Throwable|Exception
     */
    public function store($data): Task|Throwable|Exception{
        try {
            return Task::create($data->toArray());
        }catch(Throwable $tr){
            Log::error($tr->getMessage());

            return $tr;
        }
    }

}
