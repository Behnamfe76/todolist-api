<?php

namespace Database\Seeders;

use App\Enums\TaskStatusEnum;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            Task::factory(random_int(10, 20))->create([
                'user_id' => $user->id
            ]);
        }

        Task::cursor()->each(function ($task) {
            if($task->status === TaskStatusEnum::DONE || $task->status === TaskStatusEnum::EXPIRED){
                $task->update([
                    'is_completed' => true,
                    'done_date' => Carbon::parse($task->due_date)->addDays(random_int(1, 8))
                ]);
            }else{
                $task->update([
                    'is_completed' => false,
                    'done_date' => null
                ]);
            }
        });
    }
}
