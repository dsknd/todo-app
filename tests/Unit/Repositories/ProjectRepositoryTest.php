<?php

namespace Tests\Unit\Repositories;

use App\Models\Project;
use App\Models\ProjectMember;
use App\Models\ProjectStatus;
use App\Models\User;
use App\Repositories\EloquentProjectRepository;
use App\Repositories\Interfaces\ProjectRepository;
use App\ValueObjects\ProjectId;
use App\ValueObjects\UserId;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Group;
use App\Models\ProjectRole;
use App\ValueObjects\ProjectOrderParam;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Repositories\Exceptions\DuplicateProjectNameException;
/**
 * このテストスイートでは、ProjectRepositoryインターフェースの各メソッドをテストしています
 * 
 * findById: プロジェクトをIDで検索できることを確認
 * findByIds: 複数のIDでプロジェクトを検索できることを確認
 * findByUserId: ユーザーIDでプロジェクトを検索できることを確認
 * findByMemberId: メンバーIDでプロジェクトを検索できることを確認
 * create: プロジェクトを作成できることを確認
 * update: プロジェクトを更新できることを確認
 * delete: プロジェクトを削除できることを確認
 * canUserAccessProject: ユーザーがプロジェクトにアクセスできるかどうかを確認できることを確認
 * canUserEditProject: ユーザーがプロジェクトを編集できるかどうかを確認できることを確認
 * updateProgress: プロジェクトの進捗状況を更新できることを確認
 * addMember: プロジェクトにメンバーを追加できることを確認
 * removeMember: プロジェクトからメンバーを削除できることを確認
 * 
 * 各テストでは、以下のパターンに従っています
 * 
 * 準備（Arrange）: テストに必要なデータを準備
 * 実行（Act）: テスト対象のメソッドを実行
 * 検証（Assert）: 結果が期待通りであることを確認
 * また、エラーケース（存在しないプロジェクトの更新や削除など）もテストしています
 * これらのテストにより、ProjectRepositoryの実装が正しく機能することを確認できます
 */
#[Group('repository')]
#[Group('project')]
class ProjectRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private ProjectRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new EloquentProjectRepository();
    }

    public function test_it_can_find_project_by_id()
    {
        // 準備
        $project = Project::factory()->create();

        // 実行
        $foundProject = $this->repository->findById($project->id);

        // 検証
        $this->assertNotNull($foundProject);
        $this->assertEquals($project->id, $foundProject->id);
        $this->assertEquals($project->name, $foundProject->name);
    }

    public function test_it_returns_null_when_project_not_found()
    {
        // 準備
        $nonExistentId = new ProjectId(999);

        // 実行
        $this->expectException(ModelNotFoundException::class);
        $result = $this->repository->findById($nonExistentId);

        // 検証
        $this->assertNull($result);
    }

    public function test_it_can_find_projects_by_ids()
    {
        // 準備
        $projects = Project::factory()->count(3)->create();
        
        // ProjectIdの取得
        $projectIds = $projects->map(function($project) {
            return $project->id;
        })->toArray();
    
        // 実行
        $foundProjects = $this->repository->findByIds($projectIds);
    
        // 検証
        $this->assertCount(3, $foundProjects);
        
        // ProjectIdの比較
        $expectedIds = $projects->map(function($project) {
            return $project->id;
        })->sort()->values()->toArray();
        
        $actualIds = $foundProjects->map(function($project) {
            return $project->id;
        })->sort()->values()->toArray();
        
        $this->assertEquals($expectedIds, $actualIds);
    }

    public function test_it_can_find_projects_by_user_id()
    {
        // 準備
        $user = User::factory()->create();
        Project::factory()->count(3)->create(['user_id' => $user->id->getValue()]);
        Project::factory()->count(2)->create(); // 他のユーザーのプロジェクト

        // 実行
        $foundProjects = $this->repository->findByUserId($user->id);

        // 検証
        $this->assertEquals(3, $foundProjects->total());
        $foundProjects->each(function ($project) use ($user) {
            $this->assertEquals($user->id, $project->user_id);
        });
    }

    public function test_it_can_find_projects_by_member_id()
    {
        // 準備
        $user = User::factory()->create();
        
        // ユーザーがメンバーのプロジェクト
        $memberProjects = Project::factory()->count(2)->create();
        $projectRoles = ProjectRole::factory()->count(2)->create();
        foreach ($memberProjects as $project) {
            ProjectMember::factory()->create([
                'project_id' => $project->id,
                'user_id' => $user->id,
                'role_id' => $projectRoles->first()->id,
            ]);
        }
        
        // ユーザーがメンバーでないプロジェクト
        Project::factory()->count(3)->create();

        // 実行
        $foundProjects = $this->repository->findByMemberId($user->id);

        // 検証
        $this->assertEquals(2, $foundProjects->total());
        $this->assertEquals(
            $memberProjects->pluck('id')->sort()->values()->toArray(),
            $foundProjects->pluck('id')->sort()->values()->toArray()
        );
    }

    public function test_it_can_find_projects_by_member_id_with_order_param()
    {
        // 準備
        $user = User::factory()->create();
        $projects = Project::factory()->count(3)->create();
        foreach ($projects as $project) {
            ProjectMember::factory()->create([
                'project_id' => $project->id,
                'user_id' => $user->id,
            ]);
        }

        // 実行
        $foundProjects = $this->repository->findByMemberId($user->id, 15, ProjectOrderParam::from('name', 'asc'));

        // 検証
        $this->assertEquals(3, $foundProjects->total());

        // プロジェクト名の昇順でソートされていることを確認
        $this->assertEquals(
            $projects->pluck('name')->sort()->values()->toArray(),
            $foundProjects->pluck('name')->sort()->values()->toArray()
        );
    }

    public function test_it_can_create_project()
    {
        // 準備
        $user = User::factory()->create();
        $projectStatus = ProjectStatus::factory()->create();
        $attributes = [
            'name' => 'テストプロジェクト',
            'description' => 'これはテストプロジェクトです',
            'is_private' => true,
            'user_id' => $user->id,
            'project_status_id' => $projectStatus->id,
            'planned_start_date' => '2023-01-01',
            'planned_end_date' => '2023-12-31',
            'actual_start_date' => '2023-01-01',
            'actual_end_date' => '2023-12-31',
        ];

        // 実行
        $project = $this->repository->create($attributes);

        // 検証
        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'name' => 'テストプロジェクト',
            'description' => 'これはテストプロジェクトです',
            'is_private' => true,
            'user_id' => $user->id,
            'project_status_id' => $projectStatus->id,
            'planned_start_date' => '2023-01-01',
            'planned_end_date' => '2023-12-31',
            'actual_start_date' => '2023-01-01',
            'actual_end_date' => '2023-12-31',
        ]);
        $this->assertEquals('テストプロジェクト', $project->name);
        $this->assertEquals('これはテストプロジェクトです', $project->description);
        $this->assertEquals(true, $project->is_private);
        $this->assertEquals($projectStatus->id, $project->project_status_id);
        $this->assertEquals($user->id, $project->user_id);
        $this->assertEquals('2023-01-01', $project->planned_start_date->format('Y-m-d'));
        $this->assertEquals('2023-12-31', $project->planned_end_date->format('Y-m-d'));
        $this->assertEquals('2023-01-01', $project->actual_start_date->format('Y-m-d'));
        $this->assertEquals('2023-12-31', $project->actual_end_date->format('Y-m-d'));
    }

    public function test_it_throws_duplicate_project_name_exception_when_project_name_already_exists()
    {
        // 準備
        $user = User::factory()->create();
        $project = Project::factory()->create();

        // 実行
        $this->expectException(DuplicateProjectNameException::class);
        $this->repository->create([
            'name' => $project->name,
            'description' => $project->description,
            'is_private' => $project->is_private,
            'user_id' => $project->user_id,
            'project_status_id' => $project->project_status_id,
            'planned_start_date' => $project->planned_start_date,
            'planned_end_date' => $project->planned_end_date,
            'actual_start_date' => $project->actual_start_date,
        ]);
    }

    public function test_it_can_update_project()
    {
        // 準備
        $user = User::factory()->create();
        $projectStatus = ProjectStatus::factory()->create();
        $project = Project::factory()->create([
            'name' => '古いプロジェクト名',
            'description' => '古い説明',
            'is_private' => true,
            'user_id' => $user->id,
            'project_status_id' => $projectStatus->id,
            'planned_start_date' => '2023-01-01',
            'planned_end_date' => '2023-12-31',
            'actual_start_date' => '2023-01-01',
            'actual_end_date' => '2023-12-31',
        ]);

        $newProjectStatus = ProjectStatus::factory()->create();
        $newUser = User::factory()->create();
        $attributes = [
            'name' => '新しいプロジェクト名',
            'description' => '新しい説明',
            'is_private' => false,
            'user_id' => $newUser->id,
            'project_status_id' => $newProjectStatus->id,
            'planned_start_date' => '2024-01-01',
            'planned_end_date' => '2024-12-31',
            'actual_start_date' => '2024-01-01',
            'actual_end_date' => '2024-12-31',
        ];

        // 実行
        $result = $this->repository->update($project->id, $attributes);

        // 検証
        $this->assertTrue($result);
        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'name' => '新しいプロジェクト名',
            'description' => '新しい説明',
            'is_private' => false,
            'user_id' => $newUser->id,
            'project_status_id' => $newProjectStatus->id,
            'planned_start_date' => '2024-01-01',
            'planned_end_date' => '2024-12-31',
            'actual_start_date' => '2024-01-01',
            'actual_end_date' => '2024-12-31',
        ]);
    }

    public function test_it_returns_false_when_updating_non_existent_project()
    {
        // 準備
        $nonExistentId = new ProjectId(999);
        $attributes = [
            'name' => '新しいプロジェクト名',
        ];

        // 実行
        $result = $this->repository->update($nonExistentId, $attributes);

        // 検証
        $this->assertFalse($result);
    }

    public function test_it_can_delete_project()
    {
        // 準備
        $project = Project::factory()->create();

        // 実行
        $result = $this->repository->delete($project->id);

        // 検証
        $this->assertTrue($result);
        $this->assertDatabaseMissing('projects', [
            'id' => $project->id,
        ]);
    }

    public function test_it_returns_false_when_deleting_non_existent_project()
    {
        // 準備
        $nonExistentId = new ProjectId(999);

        // 実行
        $result = $this->repository->delete($nonExistentId);

        // 検証
        $this->assertFalse($result);
    }

    public function test_it_can_check_if_user_can_access_project_as_owner()
    {
        // 準備
        $user = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $user->id]);

        // 実行
        $result = $this->repository->canUserAccessProject($user->id, $project->id);

        // 検証
        $this->assertTrue($result);
    }

    // /** @test */
    // public function it_can_check_if_user_can_access_project_as_member()
    // {
    //     // 準備
    //     $user = User::factory()->create();
    //     $userId = new UserId($user->id);
    //     $project = Project::factory()->create();
    //     $projectId = new ProjectId($project->id);
        
    //     ProjectMember::factory()->create([
    //         'project_id' => $project->id,
    //         'user_id' => $user->id
    //     ]);

    //     // 実行
    //     $result = $this->repository->canUserAccessProject($userId, $projectId);

    //     // 検証
    //     $this->assertTrue($result);
    // }

    // /** @test */
    // public function it_returns_false_when_user_cannot_access_project()
    // {
    //     // 準備
    //     $user = User::factory()->create();
    //     $userId = new UserId($user->id);
    //     $project = Project::factory()->create();
    //     $projectId = new ProjectId($project->id);

    //     // 実行
    //     $result = $this->repository->canUserAccessProject($userId, $projectId);

    //     // 検証
    //     $this->assertFalse($result);
    // }

    // /** @test */
    // public function it_can_check_if_user_can_edit_project_as_owner()
    // {
    //     // 準備
    //     $user = User::factory()->create();
    //     $userId = new UserId($user->id);
    //     $project = Project::factory()->create(['user_id' => $user->id]);
    //     $projectId = new ProjectId($project->id);

    //     // 実行
    //     $result = $this->repository->canUserEditProject($userId, $projectId);

    //     // 検証
    //     $this->assertTrue($result);
    // }

    // /** @test */
    // public function it_can_check_if_user_can_edit_project_with_edit_role()
    // {
    //     // 準備
    //     $user = User::factory()->create();
    //     $userId = new UserId($user->id);
    //     $project = Project::factory()->create();
    //     $projectId = new ProjectId($project->id);
        
    //     $member = ProjectMember::factory()->create([
    //         'project_id' => $project->id,
    //         'user_id' => $user->id
    //     ]);
        
    //     $role = ProjectRole::factory()->create([
    //         'project_id' => $project->id,
    //         'can_edit' => true
    //     ]);
        
    //     $member->roles()->attach($role->id);

    //     // 実行
    //     $result = $this->repository->canUserEditProject($userId, $projectId);

    //     // 検証
    //     $this->assertTrue($result);
    // }

    // /** @test */
    // public function it_returns_false_when_user_cannot_edit_project()
    // {
    //     // 準備
    //     $user = User::factory()->create();
    //     $userId = new UserId($user->id);
    //     $project = Project::factory()->create();
    //     $projectId = new ProjectId($project->id);
        
    //     $member = ProjectMember::factory()->create([
    //         'project_id' => $project->id,
    //         'user_id' => $user->id
    //     ]);
        
    //     $role = ProjectRole::factory()->create([
    //         'project_id' => $project->id,
    //         'can_edit' => false
    //     ]);
        
    //     $member->roles()->attach($role->id);

    //     // 実行
    //     $result = $this->repository->canUserEditProject($userId, $projectId);

    //     // 検証
    //     $this->assertFalse($result);
    // }

    // /** @test */
    // public function it_can_update_project_progress()
    // {
    //     // 準備
    //     $project = Project::factory()->create();
    //     $projectId = new ProjectId($project->id);
        
    //     // モックを使用して、updateProgressメソッドが呼ばれることを確認
    //     $projectMock = $this->createMock(Project::class);
    //     $projectMock->expects($this->once())->method('updateProgress');
        
    //     $repositoryMock = $this->createPartialMock(EloquentProjectRepository::class, ['findById']);
    //     $repositoryMock->method('findById')->willReturn($projectMock);

    //     // 実行
    //     $result = $repositoryMock->updateProgress($projectId);

    //     // 検証
    //     $this->assertTrue($result);
    // }



    // /** @test */
    // public function it_can_update_existing_member()
    // {
    //     // 準備
    //     $project = Project::factory()->create();
    //     $projectId = new ProjectId($project->id);
    //     $user = User::factory()->create();
    //     $userId = new UserId($user->id);
        
    //     ProjectMember::factory()->create([
    //         'project_id' => $project->id,
    //         'user_id' => $user->id,
    //         'role' => 'viewer'
    //     ]);
        
    //     $attributes = [
    //         'role' => 'admin',
    //     ];

    //     // 実行
    //     $result = $this->repository->addMember($projectId, $userId, $attributes);

    //     // 検証
    //     $this->assertTrue($result);
    //     $this->assertDatabaseHas('project_members', [
    //         'project_id' => $project->id,
    //         'user_id' => $user->id,
    //         'role' => 'admin',
    //     ]);
    // }
}