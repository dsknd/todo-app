<?php

namespace Tests\Unit\UseCases;

use App\Models\Project;
use App\Repositories\EloquentProjectRepository;
use App\UseCases\FindProjectUseCase;
use App\ValueObjects\ProjectId;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FindProjectUseCaseTest extends TestCase
{
    use RefreshDatabase;

    private FindProjectUseCase $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->useCase = new FindProjectUseCase(
            new EloquentProjectRepository()
        );
    }

    public function test_it_can_find_project_by_id(): void
    {
        // Arrange
        $project = Project::factory()->create();
        $projectId = new ProjectId($project->id);

        // Act
        $foundProject = $this->useCase->execute($projectId);

        // Assert
        $this->assertNotNull($foundProject);
        $this->assertEquals($project->id, $foundProject->id);
        $this->assertEquals($project->name, $foundProject->name);
    }

    public function test_it_returns_null_when_project_not_found(): void
    {
        // Arrange
        $nonExistentId = new ProjectId(99999);

        // Act
        $result = $this->useCase->execute($nonExistentId);

        // Assert
        $this->assertNull($result);
    }
} 