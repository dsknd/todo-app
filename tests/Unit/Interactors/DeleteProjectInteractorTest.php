<?php

namespace Tests\Unit\Interactors;

use App\Exceptions\ProjectNotFoundException;
use App\Interactors\DeleteProjectInteractor;
use App\Models\Project;
use App\Models\ProjectMember;
use App\Repositories\EloquentProjectRepository;
use App\ValueObjects\ProjectId;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Group;

#[Group('interactor')]
#[Group('delete_project')]
class DeleteProjectInteractorTest extends TestCase
{
    use RefreshDatabase;

    private DeleteProjectInteractor $interactor;

    protected function setUp(): void
    {
        parent::setUp();
        $this->interactor = new DeleteProjectInteractor(
            new EloquentProjectRepository()
        );
    }

    public function test_execute_deletes_project_successfully(): void
    {
        // 準備
        $project = Project::factory()->create();
        $projectId = $project->id;

        // プロジェクトメンバーも作成
        ProjectMember::factory()->create([
            'project_id' => $project->id,
        ]);

        // 実行
        $result = $this->interactor->execute($projectId);

        // 検証
        $this->assertTrue($result);
        $this->assertDatabaseMissing('projects', [
            'id' => $projectId->getValue(),
        ]);
        // 関連するプロジェクトメンバーも削除されていることを確認
        $this->assertDatabaseMissing('project_members', [
            'project_id' => $projectId->getValue(),
        ]);
    }

    // public function test_execute_returns_false_when_project_not_found(): void
    // {
    //     // 準備
    //     $nonExistentId = new ProjectId(99999);

    //     // 実行
    //     $this->expectException(ProjectNotFoundException::class);
    //     $result = $this->interactor->execute($nonExistentId);

    //     // 検証
    //     $this->assertFalse($result);
    // }
} 