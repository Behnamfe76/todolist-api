<?php

namespace App\Data;

use App\Enums\TaskPriorityEnum;
use App\Enums\TaskStatusEnum;
use App\Enums\TaskTypeEnum;
use App\Http\Requests\V1\TaskStoreRequest;
use App\Models\Task;
use Illuminate\Support\Str;
use Spatie\LaravelData\Attributes\Validation\BooleanType;
use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\In;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class TaskData extends Data
{
    public function __construct(

        public int $user_id,

        #[Required, StringType]
        public string $uuid,

        #[Required, StringType]
        public string $title,

        #[Nullable, StringType]
        public ?string $description,

        #[Nullable, BooleanType]
        public ?bool $is_completed,

        #[Required, In(['internal', 'external'])]
        public TaskStatusEnum $status,

        #[Required, In(['todo', 'on_progress', 'done', 'expired'])]
        public TaskTypeEnum $type,

        #[Required, In(['low', 'medium', 'high', 'urgent'])]
        public TaskPriorityEnum $priority,

        #[Required, Date]
        public string $due_date,

        #[Nullable, Date]
        public ?string $done_date,
    ) {}

    /**
     * @param Task $task
     * @return self
     */
    public static function fromModel(Task $task): self
    {
        return new self(
            user_id: $task->user_id,
            uuid: $task->uuid,
            title: $task->title,
            description: $task->description,
            is_completed: $task->is_completed,
            status: $task->status,
            type: $task->type,
            priority: $task->priority,
            due_date: $task->due_date,
            done_date: $task->done_date,
        );
    }

    /**
     * @param TaskStoreRequest $request
     * @return self
     */
    public static function fromRequest(TaskStoreRequest $request): self
    {
        return new self(
            user_id: $request->user()->id,
            uuid: Str::uuid()->toString(),
            title: $request->get('title'),
            description: $request->get('description'),
            is_completed: false,
            status: TaskStatusEnum::from($request->get('status')),
            type: TaskTypeEnum::from($request->get('type')),
            priority: TaskPriorityEnum::from($request->get('priority')),
            due_date: $request->get('date'),
            done_date: null,
        );
    }
}
