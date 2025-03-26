<?php

namespace App\Models;

use App\Enums\TaskPriorityEnum;
use App\Enums\TaskStatusEnum;
use App\Enums\TaskTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Task extends Model
{
    protected $table = 'tasks';

    protected $fillable = ['uuid', 'user_id', 'title', 'description', 'type', 'status', 'priority', 'due_date', 'done_date', 'is_completed'];

    /**
     * @return BelongsTo
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany
     */
    public function subTasks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(SubTask::class);
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
