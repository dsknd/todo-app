<?php

namespace Tests\Unit\Interactors;

use App\Interactors\UpdateProjectInteractor;
use App\Models\Project;
use App\Models\User;
use App\Repositories\EloquentProjectRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Group;
use App\ValueObjects\ProjectId;

#[Group('interactor')]
#[Group('update_project')]
class UpdateProjectInteractorTest extends TestCase
{
    use RefreshDatabase;

    private UpdateProjectInteractor $interactor;

    protected function setUp(): void
    {
        parent::setUp();
        $this->interactor = new UpdateProjectInteractor(
            new EloquentProjectRepository()
        );
    }

    public function test_execute_updates_project_successfully(): void
    {
        // 準備
        $user = User::factory()->create();
        $project = Project::factory()->create([
            'name' => '古いプロジェクト名',
            'description' => '古い説明',
            'user_id' => $user->id,
        ]);

        $updateData = [
            'name' => '新しいプロジェクト名',
            'description' => '新しい説明',
        ];

        // 実行
        $result = $this->interactor->execute($project->id, $updateData);

        // 検証
        $this->assertTrue($result);
        $this->assertDatabaseHas('projects', [
            'id' => $project->id->getValue(),
            'name' => '新しいプロジェクト名',
            'description' => '新しい説明',
            'user_id' => $user->id->getValue(),
        ]);
    }

    public function test_execute_returns_false_when_project_not_found(): void
    {
        // 準備
        $nonExistentId = new ProjectId(99999); // 存在しないIDを直接使用
        $updateData = [
            'name' => '新しいプロジェクト名',
        ];

        // 実行
        $result = $this->interactor->execute($nonExistentId, $updateData);

        // 検証
        $this->assertFalse($result);
    }

    public function test_execute_updates_only_specified_attributes(): void
    {
        // 準備
        $project = Project::factory()->create([
            'name' => '元のプロジェクト名',
            'description' => '元の説明',
        ]);

        $updateData = [
            'name' => '新しいプロジェクト名',
            // descriptionは更新しない
        ];

        // 実行
        $result = $this->interactor->execute($project->id, $updateData);

        // 検証
        $this->assertTrue($result);
        $this->assertDatabaseHas('projects', [
            'id' => $project->id->getValue(),
            'name' => '新しいプロジェクト名',
            'description' => '元の説明', // 変更されていないことを確認
        ]);
    }

    public function test_execute_handles_empty_update_data(): void
    {
        // 準備
        $project = Project::factory()->create([
            'name' => '元のプロジェクト名',
            'description' => '元の説明',
        ]);

        // 実行
        $result = $this->interactor->execute($project->id, []);

        // 検証
        $this->assertTrue($result);
        $this->assertDatabaseHas('projects', [
            'id' => $project->id->getValue(),
            'name' => '元のプロジェクト名',
            'description' => '元の説明',
        ]);
    }
} 