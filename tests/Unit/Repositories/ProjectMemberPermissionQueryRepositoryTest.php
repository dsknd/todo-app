<?php

namespace Tests\Unit\ReadModels;

use Tests\TestCase;
use App\ReadModels\ProjectMemberPermissionReadModel;
use App\Models\ProjectMember;
use App\Models\ProjectRole;
use App\Models\ProjectRolePermission;
use App\Models\ProjectPermission;
use App\Models\Permission;
use App\Models\Project;
use App\Models\User;
use App\Repositories\Interfaces\ProjectMemberPermissionQueryRepository;
use App\Repositories\EloquentProjectMemberPermissionQueryRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Group;

#[Group('repository')]
#[Group('readmodel')]
class ProjectMemberPermissionQueryRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private ProjectMemberPermissionQueryRepository $queryRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->queryRepository = new EloquentProjectMemberPermissionQueryRepository();
    }


    public function test_it_can_find_member_permissions()
    {
        // 準備
        $permission =  Permission::factory()->create();
        $projectPermission = ProjectPermission::factory()->create([
            'permission_id' => $permission->id
        ]);

        $project = Project::factory()->create();
        $user = User::factory()->create();
        $projectRole = ProjectRole::factory()->create();
        $projectRolePermission = ProjectRolePermission::factory()->create([
            'project_role_id' => $projectRole->id,
            'project_permission_id' => $projectPermission->permission_id
        ]);
        $projectMember = ProjectMember::factory()->create([
            'project_id' => $project->id,
            'user_id' => $user->id,
            'role_id' => $projectRole->id
        ]);

        // 実行
        $readModel = $this->queryRepository->findMemberPermissions($project->id, $user->id);

        // 検証
        $this->assertInstanceOf(ProjectMemberPermissionReadModel::class, $readModel);
        $this->assertEquals($user->id, $readModel->userId);
        $this->assertTrue($readModel->permissions->contains('permission_id', $permission->id->getValue()));
    }

    // /**
    //  * @test
    //  */
    // public function 権限を持っていない場合はfalseを返す()
    // {
    //     // 準備
    //     $projectId = ProjectId::fromInt(1);
    //     $userId = UserId::fromInt(1);
    //     $permissionId = PermissionId::fromString('project.view');

    //     // テストデータの作成
    //     $projectRole = ProjectRole::factory()->create();
    //     $permission = Permission::factory()->create([
    //         'id' => $permissionId->getValue(),
    //         'name' => 'project.view'
    //     ]);

    //     ProjectPermission::factory()->create([
    //         'role_id' => $projectRole->id,
    //         'permission_id' => $permission->id
    //     ]);

    //     ProjectMember::factory()->create([
    //         'project_id' => $projectId->getValue(),
    //         'user_id' => $userId->getValue(),
    //         'role_id' => $projectRole->id
    //     ]);

    //     // 実行
    //     $readModel = $this->queryRepository->findMemberPermissions($projectId, $userId);
    //     $nonExistentPermissionId = PermissionId::fromString('non.existent.permission');

    //     // 検証
    //     $this->assertFalse($readModel->hasPermission($nonExistentPermissionId));
    // }

    // /**
    //  * @test
    //  */
    // public function プロジェクトメンバーが存在しない場合は例外をスローする()
    // {
    //     // 準備
    //     $projectId = ProjectId::fromInt(999);
    //     $userId = UserId::fromInt(999);

    //     // 検証
    //     $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);
        
    //     // 実行
    //     $this->queryRepository->findMemberPermissions($projectId, $userId);
    // }

    // /**
    //  * @test
    //  */
    // public function 権限の詳細情報が正しく取得できる()
    // {
    //     // 準備
    //     $projectId = ProjectId::fromInt(1);
    //     $userId = UserId::fromInt(1);
    //     $permissionId = PermissionId::fromString('project.view');

    //     // テストデータの作成
    //     $projectRole = ProjectRole::factory()->create();
    //     $permission = Permission::factory()->create([
    //         'id' => $permissionId->getValue(),
    //         'name' => 'project.view',
    //         'scope' => 'project',
    //         'resource' => 'view',
    //         'action' => 'read'
    //     ]);

    //     ProjectPermission::factory()->create([
    //         'role_id' => $projectRole->id,
    //         'permission_id' => $permission->id
    //     ]);

    //     ProjectMember::factory()->create([
    //         'project_id' => $projectId->getValue(),
    //         'user_id' => $userId->getValue(),
    //         'role_id' => $projectRole->id
    //     ]);

    //     // 実行
    //     $readModel = $this->queryRepository->findMemberPermissions($projectId, $userId);
    //     $permissionDetails = $readModel->getPermissionDetails();

    //     // 検証
    //     $this->assertCount(1, $permissionDetails);
    //     $this->assertEquals($permissionId->getValue(), $permissionDetails[0]['id']);
    //     $this->assertEquals('project.view', $permissionDetails[0]['name']);
    //     $this->assertEquals('project', $permissionDetails[0]['scope']);
    //     $this->assertEquals('view', $permissionDetails[0]['resource']);
    //     $this->assertEquals('read', $permissionDetails[0]['action']);
    // }
}