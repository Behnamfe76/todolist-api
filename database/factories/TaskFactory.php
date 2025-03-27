<?php

namespace Database\Factories;

use App\Enums\TaskPriorityEnum;
use App\Enums\TaskStatusEnum;
use App\Enums\TaskTypeEnum;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => Str::uuid()->toString(),
            'user_id' => User::inRandomOrder()->value('id'),
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'type' => $this->faker->randomElement(TaskTypeEnum::cases()),
            'priority' => $this->faker->randomElement(TaskPriorityEnum::cases()),
            'status' => $this->faker->randomElement(TaskStatusEnum::cases()),
            'due_date' => now()->addDays($this->faker->numberBetween(1, 30)),
            'done_date' => $this->faker->optional()->dateTimeBetween('now', '+30 days'),
            'is_completed' => $this->faker->boolean(),
        ];
    }
}
