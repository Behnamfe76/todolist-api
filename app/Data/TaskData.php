<?php

namespace App\Data;

use App\Enums\TaskPriorityEnum;
use App\Enums\TaskStatusEnum;
use App\Enums\TaskTypeEnum;
use App\Http\Requests\V1\TaskStoreRequest;
use App\Models\Task;
use Illuminate\Support\Str;
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

        #[Required, In(['internal', 'external'])]
        public TaskStatusEnum $status,

        #[Required, In(['todo', 'on_progress', 'done', 'expired'])]
        public TaskTypeEnum $type,

        #[Required, In(['low', 'medium', 'high', 'urgent'])]
        public TaskPriorityEnum $priority,
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
            status: $task->status,
            type: $task->type,
            priority: $task->priority,
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
            status: TaskStatusEnum::from($request->get('status')),
            type: TaskTypeEnum::from($request->get('type')),
            priority: TaskPriorityEnum::from($request->get('priority')),
        );
    }
}
