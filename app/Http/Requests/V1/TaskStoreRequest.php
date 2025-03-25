<?php

namespace App\Http\Requests\V1;

use App\Enums\TaskPriorityEnum;
use App\Enums\TaskStatusEnum;
use App\Enums\TaskTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'string|required|max:255',
            'description' => 'string|nullable|max:10240',
            'type' => ['required', Rule::enum(TaskTypeEnum::class)],
            'status' => ['required', Rule::enum(TaskStatusEnum::class)],
            'priority' => ['required', Rule::enum(TaskPriorityEnum::class)],
        ];
    }
}
