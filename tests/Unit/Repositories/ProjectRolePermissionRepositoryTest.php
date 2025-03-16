<?php

namespace Tests\Unit\Repositories;

use App\Models\ProjectPermission;
use App\Models\ProjectRole;
use App\Models\ProjectRolePermission;
use App\Repositories\Interfaces\ProjectRolePermissionRepository;
use App\ValueObjects\ProjectPermissionId;
use App\ValueObjects\ProjectRoleId;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Group;
use Tests\TestCase;
use Database\Factories\ProjectRolePermissionFactory;
use App\Models\Permission;
#[Group('repository')]
#[Group('project_role_permission')]
class ProjectRolePermissionRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected ProjectRolePermissionRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = app(ProjectRolePermissionRepository::class);
    }

    public function test_it_can_find_by_role_id_and_permission_id()
    {
        // 準備

        $projectRolePermission = ProjectRolePermission::factory()->create();

        // 実行
        $foundRolePermission = $this->repository->findByRoleIdAndPermissionId(
            $projectRolePermission->project_role_id,
            $projectRolePermission->project_permission_id
        );

        // 検証
        $this->assertNotNull($foundRolePermission);
        $this->assertEquals($projectRolePermission->project_role_id, $foundRolePermission->project_role_id);
        $this->assertEquals($projectRolePermission->project_permission_id, $foundRolePermission->project_permission_id);
    }

    public function test_it_returns_null_when_role_permission_not_found()
    {
        // 準備
        $projectPermission = ProjectPermission::factory()->create();
        $projectRole = ProjectRole::factory()->create();

        // 実行
        $foundRolePermission = $this->repository->findByRoleIdAndPermissionId(
            $projectRole->id,
            $projectPermission->permission_id
        );

        // 検証
        $this->assertNull($foundRolePermission);
    }

    public function test_it_can_find_all_by_role_id()
    {
        // 準備
        $projectRole = ProjectRole::factory()->create();
        ProjectRolePermission::factory()->count(3)->create(['project_role_id' => $projectRole->id]);

        // 実行
        $foundRolePermissions = $this->repository->findAllByRoleId($projectRole->id);

        // 検証
        $this->assertCount(3, $foundRolePermissions);
    }

    public function test_it_can_find_all_by_permission_id()
    {
        // 準備
        $permissionCount = 10;
        $projectPermission = ProjectPermission::factory()->create();
        $projectRolePermission = ProjectRolePermission::factory()->count($permissionCount)->create([
            'project_permission_id' => $projectPermission->permission_id
        ]);

        // 実行
        $foundRolePermissions = $this->repository->findAllByPermissionId($projectPermission->permission_id);

        // 検証
        $this->assertCount($permissionCount, $foundRolePermissions);
    }

    public function test_it_can_create_role_permission()
    {
        // 準備
        $projectRole = ProjectRole::factory()->create();
        $projectPermission = ProjectPermission::factory()->create();

        // 実行
        $rolePermission = $this->repository->create(
            $projectRole->id,
            $projectPermission->permission_id
        );

        $foundRolePermission = $this->repository->findByRoleIdAndPermissionId($projectRole->id, $projectPermission->permission_id);

        // 検証
        $this->assertNotNull($rolePermission);
        $this->assertEquals($projectRole->id, $rolePermission->project_role_id);
        $this->assertEquals($projectPermission->permission_id, $rolePermission->project_permission_id);
        
        $this->assertDatabaseHas('project_role_permissions', [
            'project_role_id' => $projectRole->id,
            'project_permission_id' => $projectPermission->permission_id,
        ]);
    }

    public function test_it_returns_existing_role_permission_when_creating_duplicate()
    {
        // 準備
        $projectRolePermission = ProjectRolePermission::factory()->create();

        // 実行
        $createdRolePermission = $this->repository->create(
            $projectRolePermission->project_role_id,
            $projectRolePermission->project_permission_id
        );

        // 検証
        $this->assertNotNull($createdRolePermission);
        $this->assertEquals($projectRolePermission->project_role_id, $createdRolePermission->project_role_id);
        $this->assertEquals($projectRolePermission->project_permission_id, $createdRolePermission->project_permission_id);
        
        // 重複して作成されていないことを確認
        $count = ProjectRolePermission::where('project_role_id', $projectRolePermission->project_role_id)
            ->where('project_permission_id', $projectRolePermission->project_permission_id)
            ->count();
        $this->assertEquals(1, $count);
    }

    // public function test_it_can_delete_role_permission()
    // {
    //     // 準備
    //     $projectRole = ProjectRole::factory()->create();
    //     $projectPermission = ProjectPermission::factory()->create();
        
    //     $rolePermission = new ProjectRolePermission();
    //     $rolePermission->project_role_id = $projectRole->id->getValue();
    //     $rolePermission->project_permission_id = $projectPermission->id->getValue();
    //     $rolePermission->save();

    //     // 実行
    //     $result = $this->repository->delete(
    //         $projectRole->id,
    //         $projectPermission->id
    //     );

    //     // 検証
    //     $this->assertTrue($result);
    //     $this->assertDatabaseMissing('project_role_permissions', [
    //         'project_role_id' => $projectRole->id->getValue(),
    //         'project_permission_id' => $projectPermission->id->getValue(),
    //     ]);
    // }

    // public function test_it_returns_false_when_deleting_non_existent_role_permission()
    // {
    //     // 準備
    //     $projectRole = ProjectRole::factory()->create();
    //     $projectPermission = ProjectPermission::factory()->create();

    //     // 実行
    //     $result = $this->repository->delete(
    //         $projectRole->id,
    //         $projectPermission->id
    //     );

    //     // 検証
    //     $this->assertFalse($result);
    // }

    // public function test_it_can_delete_all_by_role_id()
    // {
    //     // 準備
    //     $projectRole = ProjectRole::factory()->create();
    //     $projectPermissions = ProjectPermission::factory()->count(3)->create();
        
    //     foreach ($projectPermissions as $projectPermission) {
    //         $rolePermission = new ProjectRolePermission();
    //         $rolePermission->project_role_id = $projectRole->id->getValue();
    //         $rolePermission->project_permission_id = $projectPermission->id->getValue();
    //         $rolePermission->save();
    //     }

    //     // 実行
    //     $result = $this->repository->deleteAllByRoleId($projectRole->id);

    //     // 検証
    //     $this->assertTrue($result);
    //     $this->assertDatabaseMissing('project_role_permissions', [
    //         'project_role_id' => $projectRole->id->getValue(),
    //     ]);
    // }

    // public function test_it_can_delete_all_by_permission_id()
    // {
    //     // 準備
    //     $projectRoles = ProjectRole::factory()->count(3)->create();
    //     $projectPermission = ProjectPermission::factory()->create();
        
    //     foreach ($projectRoles as $projectRole) {
    //         $rolePermission = new ProjectRolePermission();
    //         $rolePermission->project_role_id = $projectRole->id->getValue();
    //         $rolePermission->project_permission_id = $projectPermission->id->getValue();
    //         $rolePermission->save();
    //     }

    //     // 実行
    //     $result = $this->repository->deleteAllByPermissionId($projectPermission->id);

    //     // 検証
    //     $this->assertTrue($result);
    //     $this->assertDatabaseMissing('project_role_permissions', [
    //         'project_permission_id' => $projectPermission->id->getValue(),
    //     ]);
    // }

    // public function test_it_can_check_if_role_permission_exists()
    // {
    //     // 準備
    //     $projectRole = ProjectRole::factory()->create();
    //     $projectPermission = ProjectPermission::factory()->create();
        
    //     $rolePermission = new ProjectRolePermission();
    //     $rolePermission->project_role_id = $projectRole->id->getValue();
    //     $rolePermission->project_permission_id = $projectPermission->id->getValue();
    //     $rolePermission->save();

    //     // 実行
    //     $exists = $this->repository->exists(
    //         $projectRole->id,
    //         $projectPermission->id
    //     );

    //     // 検証
    //     $this->assertTrue($exists);
    // }

    // public function test_it_returns_false_when_checking_if_non_existent_role_permission_exists()
    // {
    //     // 準備
    //     $projectRole = ProjectRole::factory()->create();
    //     $projectPermission = ProjectPermission::factory()->create();

    //     // 実行
    //     $exists = $this->repository->exists(
    //         $projectRole->id,
    //         $projectPermission->id
    //     );

    //     // 検証
    //     $this->assertFalse($exists);
    // }

    // public function test_it_can_assign_permissions()
    // {
    //     // 準備
    //     $projectRole = ProjectRole::factory()->create();
    //     $projectPermissions = ProjectPermission::factory()->count(3)->create();
        
    //     $permissionIds = $projectPermissions->map(function ($permission) {
    //         return $permission->id;
    //     })->toArray();

    //     // 実行
    //     $result = $this->repository->assignPermissions(
    //         $projectRole->id,
    //         $permissionIds
    //     );

    //     // 検証
    //     $this->assertTrue($result);
        
    //     foreach ($projectPermissions as $permission) {
    //         $this->assertDatabaseHas('project_role_permissions', [
    //             'project_role_id' => $projectRole->id->getValue(),
    //             'project_permission_id' => $permission->id->getValue(),
    //         ]);
    //     }
    // }

    // public function test_it_can_remove_permissions()
    // {
    //     // 準備
    //     $projectRole = ProjectRole::factory()->create();
    //     $projectPermissions = ProjectPermission::factory()->count(3)->create();
        
    //     foreach ($projectPermissions as $projectPermission) {
    //         $rolePermission = new ProjectRolePermission();
    //         $rolePermission->project_role_id = $projectRole->id->getValue();
    //         $rolePermission->project_permission_id = $projectPermission->id->getValue();
    //         $rolePermission->save();
    //     }
        
    //     $permissionIdsToRemove = $projectPermissions->take(2)->map(function ($permission) {
    //         return $permission->id;
    //     })->toArray();

    //     // 実行
    //     $result = $this->repository->removePermissions(
    //         $projectRole->id,
    //         $permissionIdsToRemove
    //     );

    //     // 検証
    //     $this->assertTrue($result);
        
    //     foreach ($projectPermissions->take(2) as $permission) {
    //         $this->assertDatabaseMissing('project_role_permissions', [
    //             'project_role_id' => $projectRole->id->getValue(),
    //             'project_permission_id' => $permission->id->getValue(),
    //         ]);
    //     }
        
    //     // 3つ目の権限は削除されていないことを確認
    //     $this->assertDatabaseHas('project_role_permissions', [
    //         'project_role_id' => $projectRole->id->getValue(),
    //         'project_permission_id' => $projectPermissions[2]->id->getValue(),
    //     ]);
    // }

    // public function test_it_can_sync_permissions()
    // {
    //     // 準備
    //     $projectRole = ProjectRole::factory()->create();
    //     $allPermissions = ProjectPermission::factory()->count(5)->create();
        
    //     // 最初に3つの権限を割り当て
    //     foreach ($allPermissions->take(3) as $permission) {
    //         $rolePermission = new ProjectRolePermission();
    //         $rolePermission->project_role_id = $projectRole->id->getValue();
    //         $rolePermission->project_permission_id = $permission->id->getValue();
    //         $rolePermission->save();
    //     }
        
    //     // 新しい権限セット（最後の3つ）
    //     $newPermissionIds = $allPermissions->slice(2, 3)->map(function ($permission) {
    //         return $permission->id;
    //     })->toArray();

    //     // 実行
    //     $result = $this->repository->syncPermissions(
    //         $projectRole->id,
    //         $newPermissionIds
    //     );

    //     // 検証
    //     $this->assertTrue($result);
        
    //     // 最初の2つの権限は削除されていることを確認
    //     foreach ($allPermissions->take(2) as $permission) {
    //         $this->assertDatabaseMissing('project_role_permissions', [
    //             'project_role_id' => $projectRole->id->getValue(),
    //             'project_permission_id' => $permission->id->getValue(),
    //         ]);
    //     }
        
    //     // 新しい権限セットが存在することを確認
    //     foreach ($allPermissions->slice(2, 3) as $permission) {
    //         $this->assertDatabaseHas('project_role_permissions', [
    //             'project_role_id' => $projectRole->id->getValue(),
    //             'project_permission_id' => $permission->id->getValue(),
    //         ]);
    //     }
    // }
} 