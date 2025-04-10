<?php

namespace Tests\Unit\Repositories;

use App\Models\CustomProjectRole;
use App\Models\Project;
use App\Models\ProjectRole;
use App\Repositories\Interfaces\CustomProjectRoleRepository;
use App\ValueObjects\ProjectRoleId;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Group;
use Tests\TestCase;

#[Group('repository')]
#[Group('custom_project_role')]
class CustomProjectRoleRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected CustomProjectRoleRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = app(CustomProjectRoleRepository::class);
    }

    public function test_it_can_find_custom_project_role_by_project_role_id()
    {
        // 準備
        $customProjectRole = CustomProjectRole::factory()->create();

        // 実行
        $foundCustomProjectRole = $this->repository->findByProjectRoleId($customProjectRole->project_role_id);

        // 検証
        $this->assertNotNull($foundCustomProjectRole);
        $this->assertTrue($customProjectRole->project_role_id->equals($foundCustomProjectRole->project_role_id));
    }

    public function test_it_returns_null_when_custom_project_role_not_found()
    {
        // 実行
        $foundCustomProjectRole = $this->repository->findByProjectRoleId(new ProjectRoleId(999));

        // 検証
        $this->assertNull($foundCustomProjectRole);
    }


    public function test_it_can_find_custom_project_role_by_project_id_and_role_number()
    {
        // 準備
        $customProjectRole = CustomProjectRole::factory()->create();

        // 実行
        $foundCustomProjectRole = $this->repository->findByProjectIdAndRoleNumber($customProjectRole->project_id, $customProjectRole->role_number);

        // 検証
        $this->assertNotNull($foundCustomProjectRole);
        $this->assertTrue($customProjectRole->project_role_id->equals($foundCustomProjectRole->project_role_id));
    }

    public function test_it_can_find_all_custom_project_roles_by_project_id()
    {
        // 準備
        $project = Project::factory()->create();
        for ($i = 1; $i <= 3; $i++) {
            CustomProjectRole::factory()->create([
                'project_id' => $project->id,
            ]);
        }
        
        // 他のプロジェクトのカスタムロール
        $otherProject = Project::factory()->create();
        for ($i = 1; $i <= 3; $i++) {
            CustomProjectRole::factory()->create([
                'project_id' => $otherProject->id,
            ]);
        }

        // 実行
        $foundCustomProjectRoles = $this->repository->findAllByProjectId($project->id);

        // 検証
        $this->assertCount(3, $foundCustomProjectRoles);
    }

    public function test_it_can_find_custom_project_roles_by_project_id_paginated()
    {
        // 準備
        $project = Project::factory()->create();
        for ($i = 1; $i <= 10; $i++) {
            CustomProjectRole::factory()->create([
                'project_id' => $project->id,
            ]);
        }

        // 実行
        $foundCustomProjectRoles = $this->repository->findByProjectIdPaginated($project->id, 2);

        // 検証
        $this->assertEquals(10, $foundCustomProjectRoles->total());
        $this->assertEquals(2, $foundCustomProjectRoles->count());
    }

    public function test_it_can_create_custom_project_role()
    {
        // 準備
        $projectRole = ProjectRole::factory()->create();
        $project = Project::factory()->create();

        $attributes = [
            'project_id' => $project->id,
            'name' => 'NewCustomRole',
            'description' => 'New custom role description',
        ];

        // 実行
        $customProjectRole = $this->repository->create($projectRole->id, $attributes);

        // 検証
        $this->assertNotNull($customProjectRole);
        $this->assertEquals('NewCustomRole', $customProjectRole->name);
        $this->assertEquals('New custom role description', $customProjectRole->description);
        $this->assertTrue($project->id->equals($customProjectRole->project_id));
    }

    public function test_it_can_update_custom_project_role()
    {
        // 準備
        $customProjectRole = CustomProjectRole::factory()->create();
        $project = Project::factory()->create();

        $attributes = [
            'project_id' => $project->id,
            'name' => 'UpdatedName',
            'description' => 'Updated description',
        ];
        // 実行
        $result = $this->repository->update($customProjectRole->project_role_id, $attributes);

        // 検証
        $this->assertTrue($result);
        
        $updatedCustomProjectRole = CustomProjectRole::where('project_role_id', $customProjectRole->project_role_id)->first();
        $this->assertEquals('UpdatedName', $updatedCustomProjectRole->name);
        $this->assertEquals('Updated description', $updatedCustomProjectRole->description);
    }

    public function test_it_returns_false_when_updating_non_existent_custom_project_role()
    {
        // 実行
        $result = $this->repository->update(new ProjectRoleId(999), [
            'name' => 'UpdatedName',
        ]);

        // 検証
        $this->assertFalse($result);
    }

    public function test_it_can_delete_custom_project_role()
    {
        // 準備
        $customProjectRole = CustomProjectRole::factory()->create();

        // 実行
        $result = $this->repository->delete($customProjectRole->project_role_id);

        // 検証
        $this->assertTrue($result);
        $this->assertNull(CustomProjectRole::where('project_role_id', $customProjectRole->project_role_id)->first());
    }

    public function test_it_returns_false_when_deleting_non_existent_custom_project_role()
    {
        // 実行
        $result = $this->repository->delete(new ProjectRoleId(999));

        // 検証
        $this->assertFalse($result);
    }

    public function test_it_can_check_if_custom_project_role_exists()
    {
        // 準備
        $customProjectRole = CustomProjectRole::factory()->create();

        // 実行
        $exists = $this->repository->exists($customProjectRole->project_role_id);

        // 検証
        $this->assertTrue($exists);
    }

    public function test_it_can_check_if_project_role_is_custom_role()
    {
        // 準備
        $customProjectRole = CustomProjectRole::factory()->create();

        // 実行
        $isCustomRole = $this->repository->isCustomRole($customProjectRole->project_role_id);

        // 検証
        $this->assertTrue($isCustomRole);
    }
} 