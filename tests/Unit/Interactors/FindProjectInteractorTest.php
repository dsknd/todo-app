<?php

namespace Tests\Unit\Interactors;

use App\Interactors\FindProjectInteractor;
use App\Models\Project;
use App\Repositories\EloquentProjectRepository;
use App\ValueObjects\ProjectId;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Group;

#[Group('interactor')]
#[Group('find_project')]
class FindProjectInteractorTest extends TestCase
{
    use RefreshDatabase;

    private FindProjectInteractor $interactor;

    protected function setUp(): void
    {
        parent::setUp();
        $this->interactor = new FindProjectInteractor(
            new EloquentProjectRepository()
        );
    }

    public function test_execute_finds_project_by_id(): void
    {
        // 準備
        $project = Project::factory()->create();
        $projectId = $project->id;  // すでにProjectIdオブジェクト

        // 実行
        $foundProject = $this->interactor->execute($projectId);

        // 検証
        $this->assertNotNull($foundProject);
        $this->assertEquals($project->id->getValue(), $foundProject->id->getValue());
        $this->assertEquals($project->name, $foundProject->name);
    }

    public function test_execute_returns_null_for_non_existent_project(): void
    {
        // 準備
        $nonExistentId = new ProjectId(99999);

        // 実行
        $result = $this->interactor->execute($nonExistentId);

        // 検証
        $this->assertNull($result);
    }
} 