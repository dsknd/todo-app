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

    public function test_it_can_find_project_role_by_project_id_and_role_number()
    {
        // 準備
        $project = Project::factory()->create();
        $projectRole = ProjectRole::factory()->create([
            'project_id' => $project->id,
        ]);

        // 実行
        $foundProjectRole = $this->repository->findByProjectIdAndRoleNumber($project->id, $projectRole->role_number);

        // 検証
        $this->assertNotNull($foundProjectRole);
        $this->assertTrue($projectRole->id->equals($foundProjectRole->id));
    }

    public function test_it_returns_null_when_project_role_not_found_by_project_id_and_role_number()
    {
        // 準備
        $project = Project::factory()->create();

        // 実行
        $foundProjectRole = $this->repository->findByProjectIdAndRoleNumber($project->id, new ProjectRoleNumber(999));

        // 検証
        $this->assertNull($foundProjectRole);
    }

    public function test_it_can_find_all_project_roles_by_project_id()
    {
        // 準備
        $project = Project::factory()->create();
        $projectRoles = ProjectRole::factory()->count(3)->create([
            'project_id' => $project->id,
        ]);
        
        // 他のプロジェクトのロール
        ProjectRole::factory()->count(2)->create();

        // 実行
        $foundProjectRoles = $this->repository->findAllByProjectId($project->id);

        // 検証
        $this->assertCount(3, $foundProjectRoles);
        $this->assertEquals(
            $projectRoles->pluck('id')->map(fn($id) => $id)->sort()->values()->toArray(),
            $foundProjectRoles->pluck('id')->map(fn($id) => $id)->sort()->values()->toArray()
        );
    }

    public function test_it_can_find_project_roles_by_project_id_paginated()
    {
        // 準備
        $project = Project::factory()->create();
        ProjectRole::factory()->count(3)->create([
            'project_id' => $project->id,
        ]);
        
        // 他のプロジェクトのロール
        ProjectRole::factory()->count(2)->create();

        // 実行
        $foundProjectRoles = $this->repository->findByProjectIdPaginated($project->id, 2);

        // 検証
        $this->assertEquals(3, $foundProjectRoles->total());
        $this->assertEquals(2, $foundProjectRoles->count());
    }
} 