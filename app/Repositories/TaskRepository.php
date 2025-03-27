<?php

namespace App\Repositories;

use App\Contracts\TaskRepositoryContracts;
use App\Enums\TaskStatusEnum;
use App\Models\Task;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Throwable;

use function Pest\Laravel\json;

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

            Log::info(
                Task::when($request->has('query'), function ($query) use ($request) {
                    $input = $request->get('query');
                    if ($input) {
                        $query->where(function ($q) use ($input) {
                            $q->where('title', 'LIKE', "%$input%")
                                ->orWhere('description', 'LIKE', "%$input%");
                        });
                    }
                })
                    ->when($request->has('status'), function ($query) use ($request) {
                        $input = $request->get('status');
                        $status = TaskStatusEnum::tryFrom($input);
                        if ($status) {
                            $query->where('status', $status);
                        }
                    })
                    ->when($request->has('completed'), function ($query) use ($request) {
                        $input = match ($request->get('completed')) {
                            'completed' => true,
                            'not_completed' => false,
                            default => 'all'
                        };
                        if ($input !== 'all') {
                            $query->where('is_completed', $input);
                        }
                    })
                    ->select('id', 'uuid', 'user_id', 'title', 'description', 'is_completed', 'status', 'due_date')
                    ->where('user_id', $user->id)
                    ->withCount([
                        'subTasks as sub_tasks',
                        'subTasks as completed_sub_tasks' => function ($query) {
                            $query->where('is_completed', true);
                        }
                    ])->toSql()

            );

            return Task::when($request->has('query'), function ($query) use ($request) {
                $input = $request->get('query');
                if ($input) {
                    $query->where(function ($q) use ($input) {
                        $q->where('title', 'LIKE', "%$input%")
                            ->orWhere('description', 'LIKE', "%$input%");
                    });
                }
            })
                ->when($request->has('status'), function ($query) use ($request) {
                    $input = $request->get('status');
                    $status = TaskStatusEnum::tryFrom($input);
                    if ($status) {
                        $query->where('status', $status);
                    }
                })
                ->when($request->has('completed'), function ($query) use ($request) {
                    $input = match ($request->get('completed')) {
                        'completed' => true,
                        'not_completed' => false,
                        default => 'all'
                    };
                    if ($input !== 'all') {
                        $query->where('is_completed', $input);
                    }
                })
                ->select('id', 'uuid', 'user_id', 'title', 'description', 'is_completed', 'status', 'due_date')
                ->where('user_id', $user->id)
                ->orderByDesc('user_id')
                ->withCount([
                    'subTasks as sub_tasks',
                    'subTasks as completed_sub_tasks' => function ($query) {
                        $query->where('is_completed', true);
                    }
                ])->paginate(9);
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
