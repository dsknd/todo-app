<?php

namespace Tests\Unit\Repositories;

use App\Models\Project;
use App\Models\ProjectMember;
use App\Models\ProjectRole;
use App\Models\User;
use App\Repositories\EloquentProjectMemberRepository;
use App\Repositories\Interfaces\ProjectMemberRepository;
use App\ValueObjects\ProjectId;
use App\ValueObjects\UserId;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Group;
use DateTimeImmutable;
#[Group('repository')]
#[Group('project_member')]
class ProjectMemberRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private ProjectMemberRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new EloquentProjectMemberRepository();
    }



    public function test_it_can_find_member_by_project_id_and_user_id()
    {
        // 準備
        $project = Project::factory()->create();
        $user = User::factory()->create();
        ProjectMember::factory()->create([
            'project_id' => $project->id,
            'user_id' => $user->id,
        ]);
        
        // 実行
        $member = $this->repository->findByProjectIdAndUserId($project->id, $user->id);
        
        // 検証
        $this->assertNotNull($member);
        $this->assertEquals($project->id, $member->project_id);
        $this->assertEquals($user->id, $member->user_id);
    }

    public function test_it_returns_null_when_member_not_found()
    {
        // 準備
        $project = Project::factory()->create();
        $user = User::factory()->create();
        
        // 実行
        $member = $this->repository->findByProjectIdAndUserId($project->id, $user->id);
        
        // 検証
        $this->assertNull($member);
    }

    public function test_it_can_find_members_by_project_id()
    {
        // 準備
        $project = Project::factory()->create();
        $users = User::factory()->count(3)->create();
        
        foreach ($users as $user) {
            ProjectMember::factory()->create([
                'project_id' => $project->id,
                'user_id' => $user->id,
            ]);
        }
        
        // 実行
        $members = $this->repository->findByProjectId($project->id);
        
        // 検証
        $this->assertCount(3, $members);
        $this->assertEquals(
            $users->pluck('id')->sort()->values()->toArray(),
            $members->pluck('user_id')->sort()->values()->toArray()
        );
    }

    public function test_it_can_find_members_by_user_id()
    {
        // 準備
        $projects = Project::factory()->count(3)->create();
        $user = User::factory()->create();
        
        foreach ($projects as $project) {
            ProjectMember::factory()->create([
                'project_id' => $project->id,
                'user_id' => $user->id,
            ]);
        }
        
        // 実行
        $members = $this->repository->findByUserId($user->id);
        
        // 検証
        $this->assertCount(3, $members);
        $this->assertEquals(
            $projects->pluck('id')->sort()->values()->toArray(),
            $members->pluck('project_id')->sort()->values()->toArray()
        );
    }

    public function test_it_can_add_member_to_project()
    {
        // 準備
        $project = Project::factory()->create();
        $user = User::factory()->create();

        // 実行
        $result = $this->repository->add($project->id, $user->id, new DateTimeImmutable(now()));

        // 検証
        $this->assertTrue($result);
        $this->assertDatabaseHas('project_members', [
            'project_id' => $project->id->getValue(),
            'user_id' => $user->id->getValue(),
        ]);
    }

    // public function test_it_cannot_add_member_twice()
    // {
    //     // 準備
    //     $project = Project::factory()->create();
    //     $user = User::factory()->create();
        
    //     // 最初の追加
    //     $this->repository->add($project->id, $user->id);
        
    //     // 2回目の追加（失敗するはず）
    //     $result = $this->repository->add($project->id, $user->id);
        
    //     // 検証
    //     $this->assertFalse($result);
    //     $this->assertDatabaseCount('project_members', 1);
    // }

    // public function test_it_can_update_member()
    // {
    //     // 準備
    //     $project = Project::factory()->create();
    //     $user = User::factory()->create();
    //     $this->repository->add($project->id, $user->id);
        
    //     $attributes = [
    //         'joined_at' => '2023-01-01 12:00:00',
    //     ];
        
    //     // 実行
    //     $result = $this->repository->update($project->id, $user->id, $attributes);
        
    //     // 検証
    //     $this->assertTrue($result);
    //     $this->assertDatabaseHas('project_members', [
    //         'project_id' => $project->id->getValue(),
    //         'user_id' => $user->id->getValue(),
    //         'joined_at' => '2023-01-01 12:00:00',
    //     ]);
    // }

    // public function test_it_returns_false_when_updating_non_existent_member()
    // {
    //     // 準備
    //     $project = Project::factory()->create();
    //     $user = User::factory()->create();
        
    //     $attributes = [
    //         'joined_at' => '2023-01-01 12:00:00',
    //     ];
        
    //     // 実行
    //     $result = $this->repository->update($project->id, $user->id, $attributes);
        
    //     // 検証
    //     $this->assertFalse($result);
    // }

    // public function test_it_can_remove_member()
    // {
    //     // 準備
    //     $project = Project::factory()->create();
    //     $user = User::factory()->create();
    //     $this->repository->add($project->id, $user->id);
        
    //     // 実行
    //     $result = $this->repository->remove($project->id, $user->id);
        
    //     // 検証
    //     $this->assertTrue($result);
    //     $this->assertDatabaseMissing('project_members', [
    //         'project_id' => $project->id->getValue(),
    //         'user_id' => $user->id->getValue(),
    //     ]);
    // }

    // public function test_it_returns_false_when_removing_non_existent_member()
    // {
    //     // 準備
    //     $project = Project::factory()->create();
    //     $user = User::factory()->create();
        
    //     // 実行
    //     $result = $this->repository->remove($project->id, $user->id);
        
    //     // 検証
    //     $this->assertFalse($result);
    // }

    // public function test_it_can_assign_roles_to_member()
    // {
    //     // 準備
    //     $project = Project::factory()->create();
    //     $user = User::factory()->create();
    //     $this->repository->add($project->id, $user->id);
        
    //     $roles = ProjectRole::factory()->count(2)->create([
    //         'project_id' => $project->id,
    //     ]);
        
    //     $roleIds = $roles->pluck('id')->toArray();
        
    //     // 実行
    //     $result = $this->repository->assignRoles($project->id, $user->id, $roleIds);
        
    //     // 検証
    //     $this->assertTrue($result);
        
    //     foreach ($roleIds as $roleId) {
    //         $this->assertDatabaseHas('project_role_assignments', [
    //             'project_id' => $project->id->getValue(),
    //             'user_id' => $user->id->getValue(),
    //             'project_role_id' => $roleId,
    //         ]);
    //     }
    // }

    // public function test_it_returns_false_when_assigning_roles_to_non_existent_member()
    // {
    //     // 準備
    //     $project = Project::factory()->create();
    //     $user = User::factory()->create();
        
    //     $roles = ProjectRole::factory()->count(2)->create([
    //         'project_id' => $project->id,
    //     ]);
        
    //     $roleIds = $roles->pluck('id')->toArray();
        
    //     // 実行
    //     $result = $this->repository->assignRoles($project->id, $user->id, $roleIds);
        
    //     // 検証
    //     $this->assertFalse($result);
    // }

    // public function test_it_can_remove_roles_from_member()
    // {
    //     // 準備
    //     $project = Project::factory()->create();
    //     $user = User::factory()->create();
    //     $this->repository->add($project->id, $user->id);
        
    //     $roles = ProjectRole::factory()->count(2)->create([
    //         'project_id' => $project->id,
    //     ]);
        
    //     $roleIds = $roles->pluck('id')->toArray();
        
    //     // ロールを割り当て
    //     $this->repository->assignRoles($project->id, $user->id, $roleIds);
        
    //     // 実行
    //     $result = $this->repository->removeRoles($project->id, $user->id, $roleIds);
        
    //     // 検証
    //     $this->assertTrue($result);
        
    //     foreach ($roleIds as $roleId) {
    //         $this->assertDatabaseMissing('project_role_assignments', [
    //             'project_id' => $project->id->getValue(),
    //             'user_id' => $user->id->getValue(),
    //             'project_role_id' => $roleId,
    //         ]);
    //     }
    // }

    // public function test_it_returns_false_when_removing_roles_from_non_existent_member()
    // {
    //     // 準備
    //     $project = Project::factory()->create();
    //     $user = User::factory()->create();
        
    //     $roles = ProjectRole::factory()->count(2)->create([
    //         'project_id' => $project->id,
    //     ]);
        
    //     $roleIds = $roles->pluck('id')->toArray();
        
    //     // 実行
    //     $result = $this->repository->removeRoles($project->id, $user->id, $roleIds);
        
    //     // 検証
    //     $this->assertFalse($result);
    // }

    // public function test_it_can_check_if_member_has_permission()
    // {
    //     // 準備
    //     $project = Project::factory()->create();
    //     $user = User::factory()->create();
    //     $this->repository->add($project->id, $user->id);
        
    //     // モックを使用して、hasPermissionメソッドが呼ばれることを確認
    //     $memberMock = $this->createMock(ProjectMember::class);
    //     $memberMock->expects($this->once())
    //         ->method('hasPermission')
    //         ->with('edit_project')
    //         ->willReturn(true);
        
    //     $repositoryMock = $this->createPartialMock(EloquentProjectMemberRepository::class, ['findByProjectIdAndUserId']);
    //     $repositoryMock->method('findByProjectIdAndUserId')->willReturn($memberMock);
        
    //     // 実行
    //     $result = $repositoryMock->hasPermission($project->id, $user->id, 'edit_project');
        
    //     // 検証
    //     $this->assertTrue($result);
    // }

    // public function test_it_returns_false_when_checking_permission_for_non_existent_member()
    // {
    //     // 準備
    //     $project = Project::factory()->create();
    //     $user = User::factory()->create();
        
    //     // 実行
    //     $result = $this->repository->hasPermission($project->id, $user->id, 'edit_project');
        
    //     // 検証
    //     $this->assertFalse($result);
    // }

    // public function test_it_can_check_if_member_has_role()
    // {
    //     // 準備
    //     $project = Project::factory()->create();
    //     $user = User::factory()->create();
    //     $this->repository->add($project->id, $user->id);
        
    //     // モックを使用して、hasRoleメソッドが呼ばれることを確認
    //     $memberMock = $this->createMock(ProjectMember::class);
    //     $memberMock->expects($this->once())
    //         ->method('hasRole')
    //         ->with('admin')
    //         ->willReturn(true);
        
    //     $repositoryMock = $this->createPartialMock(EloquentProjectMemberRepository::class, ['findByProjectIdAndUserId']);
    //     $repositoryMock->method('findByProjectIdAndUserId')->willReturn($memberMock);
        
    //     // 実行
    //     $result = $repositoryMock->hasRole($project->id, $user->id, 'admin');
        
    //     // 検証
    //     $this->assertTrue($result);
    // }

    // public function test_it_returns_false_when_checking_role_for_non_existent_member()
    // {
    //     // 準備
    //     $project = Project::factory()->create();
    //     $user = User::factory()->create();
        
    //     // 実行
    //     $result = $this->repository->hasRole($project->id, $user->id, 'admin');
        
    //     // 検証
    //     $this->assertFalse($result);
    // }

    // public function test_it_can_get_permissions_for_member()
    // {
    //     // 準備
    //     $project = Project::factory()->create();
    //     $user = User::factory()->create();
    //     $this->repository->add($project->id, $user->id);
        
    //     // モックを使用して、getPermissionsメソッドが呼ばれることを確認
    //     $memberMock = $this->createMock(ProjectMember::class);
    //     $memberMock->expects($this->once())
    //         ->method('getPermissions')
    //         ->willReturn(['view_project', 'edit_project']);
        
    //     $repositoryMock = $this->createPartialMock(EloquentProjectMemberRepository::class, ['findByProjectIdAndUserId']);
    //     $repositoryMock->method('findByProjectIdAndUserId')->willReturn($memberMock);
        
    //     // 実行
    //     $permissions = $repositoryMock->getPermissions($project->id, $user->id);
        
    //     // 検証
    //     $this->assertEquals(['view_project', 'edit_project'], $permissions);
    // }

    // public function test_it_returns_empty_array_when_getting_permissions_for_non_existent_member()
    // {
    //     // 準備
    //     $project = Project::factory()->create();
    //     $user = User::factory()->create();
        
    //     // 実行
    //     $permissions = $this->repository->getPermissions($project->id, $user->id);
        
    //     // 検証
    //     $this->assertEquals([], $permissions);
    // }
}