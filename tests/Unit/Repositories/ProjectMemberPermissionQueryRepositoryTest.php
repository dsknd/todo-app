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

}