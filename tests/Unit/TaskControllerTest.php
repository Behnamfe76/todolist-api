<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Task;
use App\Models\SubTask;
use Tests\TestCase;
use App\Enums\TaskTypeEnum;
use App\Enums\TaskStatusEnum;
use App\Enums\TaskPriorityEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected User $anotherUser;
    protected Task $task;
    protected SubTask $subTask;

    protected function setUp(): void
    {
        parent::setUp();

        // Create test users
        $this->user = User::factory()->create();
        $this->anotherUser = User::factory()->create();

        // Create a task belonging to the main test user
        $this->task = Task::create([
            'uuid' => \Illuminate\Support\Str::uuid()->toString(),
            'user_id' => $this->user->id,
            'title' => 'Test Task',
            'description' => 'Test Description',
            'type' => TaskTypeEnum::INTERNAL,
            'status' => TaskStatusEnum::TODO,
            'priority' => TaskPriorityEnum::MEDIUM,
            'due_date' => now()->addDays(7)->format('Y-m-d'),
            'is_completed' => false,
        ]);

        // Create a subtask for the task
        $this->subTask = SubTask::create([
            'uuid' => \Illuminate\Support\Str::uuid()->toString(),
            'user_id' => $this->user->id,
            'task_id' => $this->task->id,
            'text' => 'Test Subtask',
            'is_completed' => false,
        ]);
    }

    /** @test */
    public function unauthenticated_user_cannot_access_tasks()
    {
        $response = $this->getJson('/api/v1/tasks');
        $response->assertStatus(401);
    }

    /** @test */
    public function authenticated_user_can_get_their_tasks()
    {
        Sanctum::actingAs($this->user);

        $response = $this->getJson('/api/v1/tasks');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data',
            'message',
            'status'
        ]);
    }

    /** @test */
    public function user_can_create_task()
    {
        Sanctum::actingAs($this->user);

        $taskData = [
            'title' => 'New Task',
            'description' => 'New Description',
            'type' => 'todo',
            'status' => 'internal',
            'priority' => 'medium',
            'date' => now()->addDays(5)->format('Y-m-d'),
        ];

        $response = $this->postJson('/api/v1/tasks', $taskData);
        $response->assertStatus(201);
        $response->assertJsonFragment(['title' => 'New Task']);

        $this->assertDatabaseHas('tasks', [
            'title' => 'New Task',
            'user_id' => $this->user->id,
        ]);
    }

    /** @test */
    public function user_can_view_their_own_task()
    {
        Sanctum::actingAs($this->user);

        $response = $this->getJson("/api/v1/tasks/{$this->task->uuid}");
        $response->assertStatus(200);
        $response->assertJsonFragment(['title' => 'Test Task']);
    }

    /** @test */
    public function user_cannot_view_other_users_task()
    {
        Sanctum::actingAs($this->anotherUser);

        $response = $this->getJson("/api/v1/tasks/{$this->task->uuid}");
        $response->assertStatus(403);
    }

    /** @test */
    public function user_can_update_task_type()
    {
        Sanctum::actingAs($this->user);

        $response = $this->patchJson("/api/v1/tasks/{$this->task->uuid}/types", [
            'type' => 'on_progress'
        ]);

        $response->assertStatus(200);
        $this->task->refresh();
        $this->assertEquals(TaskStatusEnum::ON_PROGRESS, $this->task->type);
    }

    /** @test */
    public function other_user_cannot_update_task_type()
    {
        Sanctum::actingAs($this->anotherUser);

        $response = $this->patchJson("/api/v1/tasks/{$this->task->uuid}/types", [
            'type' => 'on_progress'
        ]);

        $response->assertStatus(403);
    }

    /** @test */
    public function user_can_update_task_status()
    {
        Sanctum::actingAs($this->user);

        $response = $this->patchJson("/api/v1/tasks/{$this->task->uuid}/statuses", [
            'status' => 'external'
        ]);

        $response->assertStatus(200);
        $this->task->refresh();
        $this->assertEquals(TaskTypeEnum::EXTERNAL, $this->task->status);
    }

    /** @test */
    public function other_user_cannot_update_task_status()
    {
        Sanctum::actingAs($this->anotherUser);

        $response = $this->patchJson("/api/v1/tasks/{$this->task->uuid}/statuses", [
            'status' => 'external'
        ]);

        $response->assertStatus(403);
    }

    /** @test */
    public function user_can_update_task_priority()
    {
        Sanctum::actingAs($this->user);

        $response = $this->patchJson("/api/v1/tasks/{$this->task->uuid}/priorities", [
            'priority' => 'high'
        ]);

        $response->assertStatus(200);
        $this->task->refresh();
        $this->assertEquals(TaskPriorityEnum::HIGH, $this->task->priority);
    }

    /** @test */
    public function other_user_cannot_update_task_priority()
    {
        Sanctum::actingAs($this->anotherUser);

        $response = $this->patchJson("/api/v1/tasks/{$this->task->uuid}/priorities", [
            'priority' => 'high'
        ]);

        $response->assertStatus(403);
    }

    /** @test */
    public function user_can_update_task_info()
    {
        Sanctum::actingAs($this->user);

        $response = $this->patchJson("/api/v1/tasks/{$this->task->uuid}/info", [
            'title' => 'Updated Title',
            'description' => 'Updated Description',
            'date' => now()->addDays(10)->format('Y-m-d')
        ]);

        $response->assertStatus(200);
        $this->task->refresh();
        $this->assertEquals('Updated Title', $this->task->title);
        $this->assertEquals('Updated Description', $this->task->description);
    }

    /** @test */
    public function other_user_cannot_update_task_info()
    {
        Sanctum::actingAs($this->anotherUser);

        $response = $this->patchJson("/api/v1/tasks/{$this->task->uuid}/info", [
            'title' => 'Updated Title',
            'description' => 'Updated Description',
            'date' => now()->addDays(10)->format('Y-m-d')
        ]);

        $response->assertStatus(403);
    }

    /** @test */
    public function user_can_delete_their_task()
    {
        Sanctum::actingAs($this->user);

        $response = $this->deleteJson("/api/v1/tasks/{$this->task->uuid}");
        $response->assertStatus(200);

        $this->assertDatabaseMissing('tasks', [
            'id' => $this->task->id
        ]);
    }

    /** @test */
    public function other_user_cannot_delete_task()
    {
        Sanctum::actingAs($this->anotherUser);

        $response = $this->deleteJson("/api/v1/tasks/{$this->task->uuid}");
        $response->assertStatus(403);

        $this->assertDatabaseHas('tasks', [
            'id' => $this->task->id
        ]);
    }

    /** @test */
    public function user_can_add_subtask()
    {
        Sanctum::actingAs($this->user);

        $response = $this->postJson("/api/v1/tasks/{$this->task->uuid}/sub-tasks", [
            'text' => 'New Subtask'
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('sub_tasks', [
            'task_id' => $this->task->id,
            'text' => 'New Subtask',
            'user_id' => $this->user->id
        ]);
    }

    /** @test */
    public function other_user_cannot_add_subtask()
    {
        Sanctum::actingAs($this->anotherUser);

        $response = $this->postJson("/api/v1/tasks/{$this->task->uuid}/sub-tasks", [
            'text' => 'New Subtask'
        ]);

        $response->assertStatus(403);
    }

    /** @test */
    public function user_can_get_subtasks()
    {
        Sanctum::actingAs($this->user);

        $response = $this->getJson("/api/v1/tasks/{$this->task->uuid}/sub-tasks");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data',
            'message',
            'status'
        ]);
    }

    /** @test */
    public function other_user_cannot_get_subtasks()
    {
        Sanctum::actingAs($this->anotherUser);

        $response = $this->getJson("/api/v1/tasks/{$this->task->uuid}/sub-tasks");

        $response->assertStatus(403);
    }

    /** @test */
    public function user_can_change_subtask_status()
    {
        Sanctum::actingAs($this->user);

        $initialStatus = $this->subTask->is_completed;

        $response = $this->patchJson("/api/v1/sub-tasks/{$this->subTask->uuid}/change-status");

        $response->assertStatus(200);

        $this->subTask->refresh();
        $this->assertNotEquals($initialStatus, $this->subTask->is_completed);
    }

    /** @test */
    public function other_user_cannot_change_subtask_status()
    {
        Sanctum::actingAs($this->anotherUser);

        $response = $this->patchJson("/api/v1/sub-tasks/{$this->subTask->uuid}/change-status");

        $response->assertStatus(403);
    }

    /** @test */
    public function user_can_delete_subtask()
    {
        Sanctum::actingAs($this->user);

        $response = $this->deleteJson("/api/v1/sub-tasks/{$this->subTask->uuid}");

        $response->assertStatus(200);

        $this->assertDatabaseMissing('sub_tasks', [
            'id' => $this->subTask->id
        ]);
    }

    /** @test */
    public function other_user_cannot_delete_subtask()
    {
        Sanctum::actingAs($this->anotherUser);

        $response = $this->deleteJson("/api/v1/sub-tasks/{$this->subTask->uuid}");

        $response->assertStatus(403);

        $this->assertDatabaseHas('sub_tasks', [
            'id' => $this->subTask->id
        ]);
    }
}
