<?php

namespace App\Repositories;

use App\Contracts\TaskRepositoryContracts;
use App\Models\Task;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Throwable;

class TaskRepository implements TaskRepositoryContracts
{
    /**
     * @param $request
     * @return Throwable|Exception|LengthAwarePaginator
     */
    public function getAllTasks($request): Throwable|Exception|LengthAwarePaginator
    {
        try {
            $user = $request->user();
            return Task::select('uuid', 'title', 'description', 'is_completed', 'status', 'due_date')
                ->where('user_id', $user->id)
                ->withCount([
                    'subTasks as sub_tasks',
                    'subTasks as completed_sub_tasks' => function ($query) {
                        $query->where('is_completed', true);
                    }
                ])
                ->paginate(10);
        } catch (\Throwable $tr) {
            Log::error($tr->getMessage());

            return $tr;
        }
    }

    /**
     * @param $data
     * @return Task|Throwable|Exception
     */
    public function store($data): Task|Throwable|Exception
    {
        try {
            return Task::create($data->toArray());
        } catch (Throwable $tr) {
            Log::error($tr->getMessage());

            return $tr;
        }
    }
}
