<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
use App\Models\Project;
use App\Enums\TaskStatusEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Enums\CategoryEnum;
use App\Models\Category;
use App\Models\Priority;
use App\Models\ProjectStatus;
use App\Models\TaskStatus;
class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var \App\Models\User&\Illuminate\Contracts\Auth\Authenticatable
     */
    private User $user;
    private Project $project;
    private Category $category;
    private Priority $priority;
    private ProjectStatus $projectStatus;
    private TaskStatus $taskStatus;
    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->category = Category::factory()->create();
        $this->priority = Priority::factory()->create();
        $this->projectStatus = ProjectStatus::factory()->create();
        $this->taskStatus = TaskStatus::factory()->create();
        $this->project = Project::factory()
            ->for($this->user)
            ->for($this->projectStatus)
            ->create();
    }

    // public function test_index_success(): void
    // {
    //     // タスクを作成
    //     Task::factory()->count(3)->create([
    //         'project_id' => $this->project->id,
    //         'created_by' => $this->user->id
    //     ]);

    //     $response = $this->actingAs($this->user)
    //         ->getJson("/api/projects/{$this->project->id}/tasks");

    //     $response->assertOk()
    //         ->assertJsonStructure([
    //             'data' => [
    //                 '*' => [
    //                     'id',
    //                     'title',
    //                     'description',
    //                     'status_id',
    //                     'project_id',
    //                     'created_by',
    //                     'created_at',
    //                     'updated_at'
    //                 ]
    //             ]
    //         ]);
    // }

    // public function test_store_success(): void
    // {
    //     $data = [
    //         'title' => 'Test Task',
    //         'description' => 'Test Description',
    //         'is_recurring' => false,
    //         'category_id' => $this->category->id,
    //         'priority_id' => $this->priority->id,
    //         'planned_start_date' => now()->addDays(1)->format('Y-m-d'),
    //         'planned_end_date' => now()->addDays(2)->format('Y-m-d'),
    //         'actual_start_date' => now()->addDays(1)->format('Y-m-d'),
    //         'actual_end_date' => now()->addDays(2)->format('Y-m-d'),
    //     ];

    //     $response = $this->actingAs($this->user)
    //         ->postJson("/api/projects/{$this->project->id}/tasks", $data);

    //     \Log::info($response->getContent());

    //     $response->assertCreated()
    //         ->assertJsonStructure([
    //             'message',
    //             'task' => [
    //                 'id',
    //                 'title',
    //                 'description',
    //                 'status_id',
    //                 'project_id',
    //                 'user_id',
    //                 'created_at',
    //                 'updated_at'
    //             ]
    //         ])
    //         ->assertJsonPath('task.title', $data['title'])
    //         ->assertJsonPath('task.description', $data['description'])
    //         ->assertJsonPath('task.status_id', TaskStatusEnum::NOT_STARTED->value);
    // }

    // public function test_store_validation_error(): void
    // {
    //     $response = $this->actingAs($this->user)
    //         ->postJson("/api/projects/{$this->project->id}/tasks", []);

    //     $response->assertUnprocessable()
    //         ->assertJsonValidationErrors(['title']);
    // }

    // public function test_show_success(): void
    // {
    //     $task = Task::factory()->create([
    //         'project_id' => $this->project->id,
    //         'created_by' => $this->user->id
    //     ]);

    //     $response = $this->actingAs($this->user)
    //         ->getJson("/api/tasks/{$task->id}");

    //     $response->assertOk()
    //         ->assertJsonStructure([
    //             'id',
    //             'title',
    //             'description',
    //             'status_id',
    //             'project_id',
    //             'created_by',
    //             'created_at',
    //             'updated_at'
    //         ]);
    // }

    // public function test_destroy_success(): void
    // {
    //     $task = Task::factory()->create([
    //         'project_id' => $this->project->id,
    //         'created_by' => $this->user->id
    //     ]);

    //     $response = $this->actingAs($this->user)
    //         ->deleteJson("/api/tasks/{$task->id}");

    //     $response->assertNoContent();
    //     $this->assertSoftDeleted($task);
    // }
} 