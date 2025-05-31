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
use App\ValueObjects\PaginatorPageCount;
use App\ValueObjects\ProjectMemberOrderParamList;
use App\ValueObjects\ProjectMemberOrderParam;
use App\ValueObjects\ProjectMemberNextToken;
use App\ValueObjects\ProjectMemberId;

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
     * プロジェクトIDでメンバーを検索できること
     */
    public function test_it_can_search_members_by_project_id_only_with_page_count()
    {
        // 準備
        $project = Project::factory()->create();
        $users = User::factory()->count(2)->create();

        foreach ($users as $user) {
            ProjectMember::factory()->create([
                'project_id' => $project->id,
                'user_id' => $user->id,
            ]);
        }

        // ページに含まれるレコード数を1に設定
        $pageCount = PaginatorPageCount::from(1);

        // ソート条件を設定
        $orderParamList = ProjectMemberOrderParamList::from([
            ProjectMemberOrderParam::createJoinedAtDesc()
        ]);

        // 実行
        $members = $this->repository->searchByProjectId(
            $project->id,
            $pageCount,
            $orderParamList
        );

        // 検証
        $this->assertCount(1, $members);
    }

    /**
     * プロジェクトIDでメンバーを検索できること（参加日時降順）
     */
    public function test_it_can_search_members_by_project_id_sorted_by_joined_at_desc()
    {
        // 準備
        $project = Project::factory()->create();
        $users = User::factory()->count(2)->create();

        $joinedAtList = [
            '2023-01-01 10:00:00',
            '2023-01-01 11:00:00',  // より明確な時間差
        ];

        for ($i = 0; $i < count($users); $i++) {
            ProjectMember::factory()->create([
                'project_id' => $project->id,
                'user_id' => $users[$i]->id,
                'joined_at' => $joinedAtList[$i],
            ]);
        }

        // ページに含まれるレコード数を設定
        $pageCount = PaginatorPageCount::from(count($users));

        // ソート条件を指定（参加日時の降順）
        $orderParamList = ProjectMemberOrderParamList::from([
            ProjectMemberOrderParam::createJoinedAtDesc()
        ]);

        // 実行
        $members = $this->repository->searchByProjectId(
            $project->id,
            $pageCount,
            $orderParamList
        );

        // 検証
        $this->assertCount(count($users), $members);
        
        // 降順なので、新しい時刻（11:00:00）が最初に来る
        $expectedOrder = [
            '2023-01-01 11:00:00',
            '2023-01-01 10:00:00',
        ];
        
        $actualOrder = $members->pluck('joined_at')->map(function ($date) {
            return $date->format('Y-m-d H:i:s');
        })->toArray();
        
        $this->assertEquals($expectedOrder, $actualOrder);
    }

    /**
     * プロジェクトIDでメンバーを検索できること（参加日時昇順）
     */
    public function test_it_can_search_members_by_project_id_sorted_by_joined_at_asc()
    {
        // 準備
        $project = Project::factory()->create();
        $users = User::factory()->count(2)->create();

        $joinedAtList = [
            '2023-01-01 10:00:00',
            '2023-01-01 11:00:00',
        ];

        for ($i = 0; $i < count($users); $i++) {
            ProjectMember::factory()->create([
                'project_id' => $project->id,
                'user_id' => $users[$i]->id,
                'joined_at' => $joinedAtList[$i],
            ]);
        }

        // ページに含まれるレコード数を設定
        $pageCount = PaginatorPageCount::from(count($users));

        // ソート条件を指定（参加日時の昇順）
        $orderParamList = ProjectMemberOrderParamList::from([
            ProjectMemberOrderParam::createJoinedAtAsc()
        ]);

        // 実行
        $members = $this->repository->searchByProjectId(
            $project->id,
            $pageCount,
            $orderParamList
        );

        // 検証
        $this->assertCount(count($users), $members);
        
        // 昇順なので、古い時刻（10:00:00）が最初に来る
        $expectedOrder = [
            '2023-01-01 10:00:00',
            '2023-01-01 11:00:00',
        ];
        
        $actualOrder = $members->pluck('joined_at')->map(function ($date) {
            return $date->format('Y-m-d H:i:s');
        })->toArray();
        
        $this->assertEquals($expectedOrder, $actualOrder);
    }

    /**
     * NextTokenでプロジェクトメンバーを検索できること
     */
    public function test_it_can_search_members_by_project_id_with_next_token()
    {
        // 準備
        $project = Project::factory()->create();
        $users = User::factory()->count(3)->create();

        $members = [];
        $baseTime = now();
        for ($i = 0; $i < count($users); $i++) {
            $members[] = ProjectMember::factory()->create([
                'project_id' => $project->id,
                'user_id' => $users[$i]->id,
                'joined_at' => $baseTime,
            ]);
        }

        // ページに含まれるレコード数を設定
        $pageCount = PaginatorPageCount::from(2);

        // ソート条件を指定(参加日時昇順)
        $orderParamList = ProjectMemberOrderParamList::from([
            ProjectMemberOrderParam::createJoinedAtAsc()
        ]);

        // 最初のページを取得
        $resultFirstPage = $this->repository->searchByProjectId($project->id, $pageCount, $orderParamList);

        // 最初のページの最後のメンバーのidをカーソルとして使用
        $lastMemberOfFirstPage = $resultFirstPage->last();
        $nextToken = ProjectMemberNextToken::from(
            $project->id,
            $pageCount,
            $orderParamList,
            ProjectMemberId::from($lastMemberOfFirstPage->id)
        );

        // 2ページ目を取得
        $resultSecondPage = $this->repository->searchByProjectIdWithNextToken($nextToken);

        // 検証
        $this->assertCount(2, $resultFirstPage);
        $this->assertCount(1, $resultSecondPage);

        // すべての参加日時が同じであることを確認
        foreach ($resultFirstPage as $member) {
            $this->assertEquals($baseTime->format('Y-m-d H:i:s'), $member->joined_at->format('Y-m-d H:i:s'));
        }
        
        // 2ページ目のメンバーが最初のページの最後のメンバーより後のIDを持つことを確認
        foreach ($resultSecondPage as $member) {
            $this->assertGreaterThan(
                $lastMemberOfFirstPage->id,
                $member->id
            );
        }

        // IDが昇順になっていることを確認
        for ($i = 0; $i < count($members); $i++) {
            $this->assertEquals(
                $members[$i]->id,
                $resultSecondPage[$i]->id
            );
        }

        // 参加日時昇順かつID昇順になっていることを確認
        foreach ($resultSecondPage as $member) {
            $this->assertEquals(
                $members[$i]->joined_at,
                $member->id
            );
        }
    }

    /**
     * メンバーをプロジェクトに追加できること
     */
    public function test_it_can_add_member_to_project()
    {
        // 準備
        $project = Project::factory()->create();
        $user = User::factory()->create();
        $role = ProjectRole::factory()->create();

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
        $role = ProjectRole::factory()->create();
        
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
        $role = ProjectRole::factory()->create();
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
        $role = ProjectRole::factory()->create();

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
        $role = ProjectRole::factory()->create();
        $this->repository->add($project->id, $user->id, $role->id, new DateTimeImmutable(now()));

        // 実行
        $result = $this->repository->hasRole($project->id, $user->id, $role->id);
        
        // 検証
        $this->assertTrue($result);
    }
}