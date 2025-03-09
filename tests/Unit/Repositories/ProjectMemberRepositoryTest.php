<?php

namespace Tests\Unit\Repositories;

use App\Models\Project;
use App\Models\ProjectMember;
use App\Models\ProjectRole;
use App\Models\User;
use App\Repositories\EloquentProjectMemberRepository;
use App\Repositories\Interfaces\ProjectMemberRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Group;
use DateTimeImmutable;
use App\ValueObjects\ProjectId;
use App\ValueObjects\UserId;
use App\ValueObjects\ProjectRoleId;

/**
 * プロジェクトメンバーリポジトリのテスト
 */
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

    /**
     * プロジェクトIDとユーザーIDでメンバーを検索できること
     */
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

    /**
     * メンバーが見つからない場合はnullを返すこと
     */
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

    /**
     * プロジェクトIDでメンバーを検索できること
     */
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

    /**
     * ユーザーIDでメンバーを検索できること
     */
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

    /**
     * メンバーをプロジェクトに追加できること
     */
    public function test_it_can_add_member_to_project()
    {
        // 準備
        $project = Project::factory()->create();
        $user = User::factory()->create();
        $role = ProjectRole::factory()->create([
            'project_id' => $project->id,
        ]);

        // 実行
        $result = $this->repository->add($project->id, $user->id, $role->id, new DateTimeImmutable(now()));

        // 検証
        $this->assertTrue($result);
        $this->assertDatabaseHas('project_members', [
            'project_id' => $project->id,
            'role_id' => $role->id,
            'user_id' => $user->id,
        ]);
    }

    /**
     * メンバーを2回追加できないこと
     */
    public function test_it_cannot_add_member_twice()
    {
        // 準備
        $project = Project::factory()->create();
        $user = User::factory()->create();
        $role = ProjectRole::factory()->create([
            'project_id' => $project->id,
        ]);
        
        // 最初の追加
        $this->repository->add(
            $project->id,
            $user->id,
            $role->id,
            new DateTimeImmutable(now())
        );
        
        // 2回目の追加（失敗するはず）
        $result = $this->repository->add(
            $project->id,
            $user->id,
            $role->id,
            new DateTimeImmutable(now())
        );
        
        // 検証
        $this->assertFalse($result);
        $this->assertDatabaseCount('project_members', 1);
    }

    /**
     * メンバーを更新できること
     */
    public function test_it_can_update_member()
    {
        // 準備
        $project = Project::factory()->create();
        $user = User::factory()->create();
        $role = ProjectRole::factory()->create([
            'project_id' => $project->id,
        ]);
        $this->repository->add($project->id, $user->id, $role->id, new DateTimeImmutable(now()));
        
        $attributes = [
            'joined_at' => '2023-01-01 12:00:00',
        ];
        
        // 実行
        $result = $this->repository->update($project->id, $user->id, $role->id, $attributes);
        
        // 検証
        $this->assertTrue($result);
        $this->assertDatabaseHas('project_members', [
            'project_id' => $project->id,
            'user_id' => $user->id,
            'joined_at' => '2023-01-01 12:00:00',
        ]);
    }

    /**
     * 存在しないメンバーを更新した場合はfalseを返すこと
     */
    public function test_it_returns_false_when_updating_non_existent_member()
    {
        // 準備
        $projectId = new ProjectId(999);
        $userId = new UserId(999);
        $projectRoleId = new ProjectRoleId(999);
        $attributes = [
            'joined_at' => '2023-01-01 12:00:00',
        ];
        
        // 実行
        $result = $this->repository->update($projectId, $userId, $projectRoleId, $attributes);
        
        // 検証
        $this->assertFalse($result);
    }

    /**
     * メンバーを削除できること
     */
    public function test_it_can_remove_member()
    {
        // 準備
        $project = Project::factory()->create();
        $user = User::factory()->create();
        $role = ProjectRole::factory()->create([
            'project_id' => $project->id,
        ]);

        $this->repository->add(
            $project->id,
            $user->id,
            $role->id,
            new DateTimeImmutable(now())
        );
        
        // 実行
        $result = $this->repository->remove($project->id, $user->id);
        
        // 検証
        $this->assertTrue($result);
        $this->assertDatabaseMissing('project_members', [
            'project_id' => $project->id,
            'user_id' => $user->id,
        ]);
    }

    /**
     * 存在しないメンバーを削除した場合はfalseを返すこと
     */
    public function test_it_returns_false_when_removing_non_existent_member()
    {
        // 準備
        $project = Project::factory()->create();
        $user = User::factory()->create();
        
        // 実行
        $result = $this->repository->remove($project->id, $user->id);
        
        // 検証
        $this->assertFalse($result);
    }

    /**
     * メンバーが特定のロールを持っているか確認できること
     */
    public function test_it_can_check_if_member_has_role()
    {
        // 準備
        $project = Project::factory()->create();
        $user = User::factory()->create();
        $role = ProjectRole::factory()->create([
            'project_id' => $project->id,
        ]);
        $this->repository->add($project->id, $user->id, $role->id, new DateTimeImmutable(now()));

        // 実行
        $result = $this->repository->hasRole($project->id, $user->id, $role->id);
        
        // 検証
        $this->assertTrue($result);
    }
}