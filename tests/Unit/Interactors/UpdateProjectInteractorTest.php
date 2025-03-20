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
use App\DataTransferObjects\UpdateProjectDto;
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

        $dto = UpdateProjectDto::builder()
            ->name('新しいプロジェクト名')
            ->description('新しい説明')
            ->build();

        // 実行
        $result = $this->interactor->execute($project->id, $dto);

        // 検証
        $this->assertTrue($result instanceof Project);
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
        $dto = UpdateProjectDto::builder()
            ->name('新しいプロジェクト名')
            ->build();

        // 実行
        $result = $this->interactor->execute($nonExistentId, $dto);

        // 検証
        $this->assertNull($result);
    }

    public function test_execute_updates_only_specified_attributes(): void
    {
        // 準備
        $project = Project::factory()->create([
            'name' => '元のプロジェクト名',
            'description' => '元の説明',
        ]);

        $dto = UpdateProjectDto::builder()
            ->name('新しいプロジェクト名')
            ->build();

        // 実行
        $result = $this->interactor->execute($project->id, $dto);

        // 検証
        $this->assertTrue($result instanceof Project);
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
        $result = $this->interactor->execute($project->id, UpdateProjectDto::builder()->build());

        // 検証
        $this->assertTrue($result instanceof Project);
        $this->assertDatabaseHas('projects', [
            'id' => $project->id->getValue(),
            'name' => '元のプロジェクト名',
            'description' => '元の説明',
        ]);
    }
} 