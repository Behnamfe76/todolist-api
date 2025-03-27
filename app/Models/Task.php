<?php

namespace App\Models;

use App\Enums\TaskTypeEnum;
use Illuminate\Support\Str;
use App\Enums\TaskStatusEnum;
use App\Enums\TaskPriorityEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;
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
            'priority' => TaskPriorityEnum::class,
            'is_completed' => 'bool'
        ];
    }
}
