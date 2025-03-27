<?php

namespace App\Data;

use App\Http\Requests\V1\SubTaskStoreRequest;
use App\Models\SubTask;
use App\Models\Task;
use Illuminate\Support\Str;
use Spatie\LaravelData\Attributes\Validation\BooleanType;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class SubTaskData extends Data
{
    public function __construct(
        #[Required, IntegerType]
        public int $user_id,

        #[Required, IntegerType]
        public int $task_id,

        #[Required, StringType]
        public string $uuid,

        #[Required, StringType]
        public string $text,

        #[Required, BooleanType]
        public bool $is_completed,

    ) {}


    /**
     * @param SubTask $subTask
     * @return self
     */
    public static function fromModel(SubTask $subTask): self
    {
        return new self(
            user_id: $subTask->user_id,
            task_id: $subTask->task_id,
            uuid: $subTask->uuid,
            text: $subTask->text,
            is_completed: $subTask->is_completed,
        );
    }

    /**
     * @param SubTaskStoreRequest $request
     * @param Task $task
     * @return self
     */
    public static function fromRequest(SubTaskStoreRequest $request, Task $task): self
    {
        return new self(
            user_id: $request->user()->id,
            task_id: $task->id,
            uuid: Str::uuid()->toString(),
            text: $request->get('text'),
            is_completed: false,
        );
    }
}
