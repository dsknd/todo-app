<?php

namespace Tests\Unit\Repositories;

use App\Models\Project;
use App\Models\ProjectRole;
use App\Repositories\Interfaces\ProjectRoleRepository;
use App\ValueObjects\ProjectRoleId;
use PHPUnit\Framework\Attributes\Group;
use Tests\TestCase;
use App\ValueObjects\ProjectRoleNumber;
use Illuminate\Foundation\Testing\RefreshDatabase;
#[Group('repository')]
#[Group('project_role')]
class ProjectRoleRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected ProjectRoleRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = app(ProjectRoleRepository::class);
    }

    public function test_it_can_find_project_role_by_id()
    {
        // 準備
        $projectRole = ProjectRole::factory()->create();

        // 実行
        $foundProjectRole = $this->repository->findById($projectRole->id);

        // 検証
        $this->assertNotNull($foundProjectRole);
        $this->assertTrue($projectRole->id->equals($foundProjectRole->id));
    }

    public function test_it_returns_null_when_project_role_not_found()
    {
        // 実行
        $foundProjectRole = $this->repository->findById(new ProjectRoleId(999));

        // 検証
        $this->assertNull($foundProjectRole);
    }
} 