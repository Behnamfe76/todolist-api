<?php

namespace App\Models;

use App\Enums\TaskTypeEnum;
use App\Enums\TaskStatusEnum;
use App\Enums\TaskPriorityEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubTask extends Model
{
    protected $table = 'sub_tasks';

    protected $fillable = ['uuid', 'user_id', 'task_id', 'title', 'description', 'type', 'status', 'priority', 'date'];


    /**
     * @return BelongsTo
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * @return string[]
     */
    public function casts(): array
    {
        return [
            'status' => TaskStatusEnum::class,
            'type' => TaskTypeEnum::class,
            'priority' => TaskPriorityEnum::class
        ];
    }
}
