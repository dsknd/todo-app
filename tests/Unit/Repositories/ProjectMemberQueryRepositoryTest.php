<?php

namespace Tests\Unit\Repositories;

use App\Models\Project;
use App\Models\ProjectMember;
use App\Models\User;
use App\Repositories\EloquentProjectMemberQueryRepository;
use App\ValueObjects\ProjectId;
use App\ValueObjects\ProjectMemberId;
use App\ValueObjects\UserId;
use App\ValueObjects\PaginationPageSize;
use App\ReadModels\ProjectMemberReadModel;
use App\ReadModels\ProjectMemberSearchResultReadModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Group;
use App\ValueObjects\ProjectMemberSortOrders;
use App\ValueObjects\ProjectMemberSortOrder;
use Illuminate\Pagination\CursorPaginator;

/**
 * プロジェクトメンバークエリリポジトリのテスト
 */
#[Group('repository')]
#[Group('project_member_query')]
class ProjectMemberQueryRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private EloquentProjectMemberQueryRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new EloquentProjectMemberQueryRepository();
    }

    /**
     * IDでプロジェクトメンバを取得できること
     */
    public function test_it_can_find_project_member_by_id()
    {
        // 準備
        $project = Project::factory()->create();
        $user = User::factory()->create([
            'name' => '田中太郎',
            'email' => 'tanaka@example.com'
        ]);
        $projectMember = ProjectMember::factory()->create([
            'project_id' => $project->id,
            'user_id' => $user->id,
        ]);

        // 実行
        $result = $this->repository->find(ProjectMemberId::from($projectMember->id));

        // 検証
        $this->assertInstanceOf(ProjectMemberReadModel::class, $result);
        $this->assertEquals($projectMember->id, $result->projectMemberId);
        $this->assertEquals($project->id, $result->projectId);
        $this->assertEquals('田中太郎', $result->getUserName());
        $this->assertEquals('tanaka@example.com', $result->getUserEmail());
    }

    /**
     * 存在しないIDでプロジェクトメンバーを取得した場合nullが返ること
     */
    public function test_it_returns_null_when_project_member_not_found()
    {
        // 実行
        $result = $this->repository->find(ProjectMemberId::from(999));

        // 検証
        $this->assertNull($result);
    }

    /**
     * プロジェクトIDとユーザIDでプロジェクトメンバを取得できること
     */
    public function test_it_can_find_project_member_by_project_id_and_user_id()
    {
        // 準備
        $project = Project::factory()->create();
        $user = User::factory()->create([
            'name' => '鈴木花子',
            'email' => 'suzuki@example.com'
        ]);
        $projectMember = ProjectMember::factory()->create([
            'project_id' => $project->id,
            'user_id' => $user->id,
        ]);

        // 実行
        $result = $this->repository->findByProjectIdAndUserId(
            new ProjectId($project->id->getValue()),
            new UserId($user->id->getValue())
        );

        // 検証
        $this->assertInstanceOf(ProjectMemberReadModel::class, $result);
        $this->assertEquals($projectMember->id->getValue(), $result->projectMemberId->getValue());
        $this->assertEquals('鈴木花子', $result->getUserName());
        $this->assertEquals('suzuki@example.com', $result->getUserEmail());
    }

    /**
     * 存在しない組み合わせでプロジェクトメンバーを取得した場合nullが返ること
     */
    public function test_it_returns_null_when_project_member_not_found_by_project_and_user()
    {
        // 準備
        $project = Project::factory()->create();
        $user = User::factory()->create();

        // 実行
        $result = $this->repository->findByProjectIdAndUserId(
            new ProjectId($project->id->getValue()),
            new UserId($user->id->getValue())
        );

        // 検証
        $this->assertNull($result);
    }

    /**
     * プロジェクトメンバーを検索できること（ソート条件付き）
     */
    public function test_it_can_search_project_members_with_sorting()
    {
        // 準備
        $project = Project::factory()->create();
        $users = User::factory()->count(5)->create();
        
        $joinedAtList = [
            '2023-01-01 10:00:00',
            '2023-01-01 11:00:00',
            '2023-01-01 12:00:00',
            '2023-01-01 13:00:00',
            '2023-01-01 14:00:00',
        ];

        foreach ($users as $index => $user) {
            ProjectMember::factory()->create([
                'project_id' => $project->id,
                'user_id' => $user->id,
                'joined_at' => $joinedAtList[$index],
            ]);
        }

        // 実行（降順ソート、ページサイズ3）
        $pageSize = PaginationPageSize::from(3);
        $sortOrders = ProjectMemberSortOrders::from([
            ProjectMemberSortOrder::from('joined_at', 'desc')
        ]);
        
        $result = $this->repository->search(
            new ProjectId($project->id->getValue()),
            $pageSize,
            $sortOrders
        );

        // 検証
        $this->assertInstanceOf(ProjectMemberSearchResultReadModel::class, $result);
        $this->assertCount(3, $result->members);
        $this->assertTrue($result->hasNextPage());
        $this->assertNotNull($result->nextToken);
        
        // ソート順確認（降順なので最新が最初に来ることを期待）
        $this->assertCount(3, $result->members);
    }

    /**
     * 検索結果で次のページがない場合のテスト
     */
    public function test_it_returns_no_next_page_when_results_fit_in_one_page()
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

        // 実行（ページサイズ5で2件のデータ）
        $pageSize = PaginationPageSize::from(5);
        $sortOrders = ProjectMemberSortOrders::from([
            ProjectMemberSortOrder::from('joined_at', 'desc')
        ]);
        
        $result = $this->repository->search(
            new ProjectId($project->id->getValue()),
            $pageSize,
            $sortOrders
        );

        // 検証
        $this->assertCount(2, $result->members);
        $this->assertFalse($result->hasNextPage());
        $this->assertNull($result->nextToken);
    }

    /**
     * NextTokenを使った検索ができること
     */
    public function test_it_can_search_with_next_token()
    {
        // 準備
        $project = Project::factory()->create();
        $users = User::factory()->count(5)->create();
        
        $joinedAtList = [
            '2023-01-01 10:00:00',
            '2023-01-01 11:00:00',
            '2023-01-01 12:00:00',
            '2023-01-01 13:00:00',
            '2023-01-01 14:00:00',
        ];
        
        $members = [];
        foreach ($users as $index => $user) {
            $members[] = ProjectMember::factory()->create([
                'project_id' => $project->id,
                'user_id' => $user->id,
                'joined_at' => $joinedAtList[$index],
            ]);
        }

        // 最初のページを取得
        $pageSize = PaginationPageSize::from(2);
        $sortOrders = ProjectMemberSortOrders::from([
            ProjectMemberSortOrder::from('joined_at', 'asc')
        ]);
        
        $firstPage = $this->repository->search(
            new ProjectId($project->id->getValue()),
            $pageSize,
            $sortOrders
        );

        // NextTokenを使って次のページを取得
        $this->assertNotNull($firstPage->nextToken);
        $secondPage = $this->repository->searchByNextToken($firstPage->nextToken);

        // 検証
        $this->assertInstanceOf(ProjectMemberSearchResultReadModel::class, $secondPage);
        $this->assertCount(2, $secondPage->members);
        $this->assertTrue($secondPage->hasNextPage());
        
        // 最初のページと次のページで異なるメンバーが取得されていることを確認
        $firstPageFirstMember = $firstPage->members->first();
        $secondPageFirstMember = $secondPage->members->first();
        $this->assertNotEquals(
            $firstPageFirstMember->projectMemberId->getValue(),
            $secondPageFirstMember->projectMemberId->getValue()
        );
    }

    /**
     * 空の検索結果のテスト
     */
    public function test_it_returns_empty_result_when_no_members()
    {
        // 準備
        $project = Project::factory()->create();

        // 実行
        $pageSize = PaginationPageSize::from(10);
        $sortOrders = ProjectMemberSortOrders::from([
            ProjectMemberSortOrder::from('joined_at', 'desc')
        ]);
        
        $result = $this->repository->search(
            new ProjectId($project->id->getValue()),
            $pageSize,
            $sortOrders
        );

        // 検証
        $this->assertTrue($result->isEmpty());
        $this->assertCount(0, $result->members);
        $this->assertFalse($result->hasNextPage());
        $this->assertNull($result->nextToken);
    }

    /**
     * 昇順ソートのテスト
     */
    public function test_it_can_sort_members_ascending()
    {
        // 準備
        $project = Project::factory()->create();
        $users = User::factory()->count(3)->create();
        
        $joinedAtList = [
            '2023-01-01 14:00:00',
            '2023-01-01 10:00:00',
            '2023-01-01 12:00:00',
        ];

        foreach ($users as $index => $user) {
            ProjectMember::factory()->create([
                'project_id' => $project->id,
                'user_id' => $user->id,
                'joined_at' => $joinedAtList[$index],
            ]);
        }

        // 実行（昇順ソート）
        $pageSize = PaginationPageSize::from(10);
        $sortOrders = ProjectMemberSortOrders::from([
            ProjectMemberSortOrder::from('joined_at', 'asc')
        ]);
        
        $result = $this->repository->search(
            new ProjectId($project->id->getValue()),
            $pageSize,
            $sortOrders
        );

        // 検証：昇順ソートされていることを確認
        $this->assertCount(3, $result->members);
        $this->assertFalse($result->hasNextPage());
    }

    /**
     * プロジェクトIDとソート条件でカーソルページネーションできること
     */
    public function test_it_can_get_project_members_with_cursor_pagination()
    {
        // 準備
        $project1 = Project::factory()->create();
        $project2 = Project::factory()->create();
        $users = User::factory()->count(10)->create();
        
        $joinedAtList = [
            '2023-01-01 10:00:00',
            '2023-01-01 11:00:00',
            '2023-01-01 12:00:00',
            '2023-01-01 13:00:00',
            '2023-01-01 14:00:00',
            '2023-01-01 15:00:00',
            '2023-01-01 16:00:00',
            '2023-01-01 17:00:00',
            '2023-01-01 18:00:00',
            '2023-01-01 19:00:00',
            '2023-01-01 20:00:00',
        ];

        // プロジェクト1のメンバーを作成
        foreach ($users as $index => $user) {
            ProjectMember::factory()->create([
                'project_id' => $project1->id,
                'user_id' => $user->id,
                'joined_at' => $joinedAtList[$index],
            ]);
        }

        // プロジェクト2のメンバーも作成（フィルタリング確認用）
        $extraUser = User::factory()->create();
        ProjectMember::factory()->create([
            'project_id' => $project2->id,
            'user_id' => $extraUser->id,
        ]);

        // 実行（降順ソート）
        $sortOrders = ProjectMemberSortOrders::from([
            ProjectMemberSortOrder::joinedAtDesc()
        ]);
        
        $result = $this->repository->getByProjectId(
            new ProjectId($project1->id->getValue()),
            PaginationPageSize::from(10),
            $sortOrders
        );

        // 検証
        $this->assertInstanceOf(CursorPaginator::class, $result);
        $this->assertCount(10, $result->items());
        
        // プロジェクト1のメンバーのみが含まれることを確認
        foreach ($result->items() as $item) {
            $this->assertTrue($item->projectId->equals(ProjectId::from($project1->id)));
        }
    }

    /**
     * getByProjectIdで昇順ソートが正しく適用されること
     */
    public function test_it_applies_ascending_sort_in_get_by_project_id()
    {
        // 準備
        $project = Project::factory()->create();
        $users = User::factory()->count(3)->create();
        
        $joinedAtList = [
            '2023-01-01 14:00:00', // 最新
            '2023-01-01 10:00:00', // 最古
            '2023-01-01 12:00:00', // 中間
        ];

        foreach ($users as $index => $user) {
            ProjectMember::factory()->create([
                'project_id' => $project->id,
                'user_id' => $user->id,
                'joined_at' => $joinedAtList[$index],
            ]);
        }

        // 実行（昇順ソート）
        $sortOrders = ProjectMemberSortOrders::from([
            ProjectMemberSortOrder::from('joined_at', 'asc')
        ]);
        
        $result = $this->repository->getByProjectId(
            new ProjectId($project->id->getValue()),
            PaginationPageSize::from(10),
            $sortOrders
        );

        // 検証
        $items = $result->items();
        $this->assertCount(3, $items);
        
        // 昇順になっていることを確認（最古→最新）
        $this->assertEquals('2023-01-01 10:00:00', $items[0]->getJoinedAt()->format('Y-m-d H:i:s'));
        $this->assertEquals('2023-01-01 12:00:00', $items[1]->getJoinedAt()->format('Y-m-d H:i:s'));
        $this->assertEquals('2023-01-01 14:00:00', $items[2]->getJoinedAt()->format('Y-m-d H:i:s'));
    }

    /**
     * getByProjectIdで降順ソートが正しく適用されること
     */
    public function test_it_applies_descending_sort_in_get_by_project_id()
    {
        // 準備
        $project = Project::factory()->create();
        $users = User::factory()->count(3)->create();
        
        $joinedAtList = [
            '2023-01-01 10:00:00', // 最古
            '2023-01-01 14:00:00', // 最新
            '2023-01-01 12:00:00', // 中間
        ];

        foreach ($users as $index => $user) {
            ProjectMember::factory()->create([
                'project_id' => $project->id,
                'user_id' => $user->id,
                'joined_at' => $joinedAtList[$index],
            ]);
        }

        // 実行（降順ソート）
        $sortOrders = ProjectMemberSortOrders::from([
            ProjectMemberSortOrder::from('joined_at', 'desc')
        ]);
        
        $result = $this->repository->getByProjectId(
            new ProjectId($project->id->getValue()),
            PaginationPageSize::from(10),
            $sortOrders
        );

        // 検証
        $items = $result->items();
        $this->assertCount(3, $items);
        
        // 降順になっていることを確認（最新→最古）
        $this->assertEquals('2023-01-01 14:00:00', $items[0]->getJoinedAt()->format('Y-m-d H:i:s'));
        $this->assertEquals('2023-01-01 12:00:00', $items[1]->getJoinedAt()->format('Y-m-d H:i:s'));
        $this->assertEquals('2023-01-01 10:00:00', $items[2]->getJoinedAt()->format('Y-m-d H:i:s'));
    }

    /**
     * getByProjectIdで空のプロジェクトの場合に空の結果が返ること
     */
    public function test_it_returns_empty_result_for_project_with_no_members()
    {
        // 準備
        $emptyProject = Project::factory()->create();

        // 実行
        $sortOrders = ProjectMemberSortOrders::from([
            ProjectMemberSortOrder::from('joined_at', 'desc')
        ]);
        
        $result = $this->repository->getByProjectId(
            new ProjectId($emptyProject->id->getValue()),
            PaginationPageSize::from(10),
            $sortOrders
        );

        // 検証
        $this->assertInstanceOf(\Illuminate\Pagination\CursorPaginator::class, $result);
        $this->assertCount(0, $result->items());
        $this->assertFalse($result->hasPages());
    }

    /**
     * getByProjectIdで他のプロジェクトのメンバーが含まれないこと
     */
    public function test_it_filters_by_project_id_correctly()
    {
        // 準備
        $targetProject = Project::factory()->create();
        $otherProject = Project::factory()->create();
        
        $targetUser = User::factory()->create(['name' => 'Target User']);
        $otherUser = User::factory()->create(['name' => 'Other User']);
        
        // 対象プロジェクトのメンバー
        ProjectMember::factory()->create([
            'project_id' => $targetProject->id,
            'user_id' => $targetUser->id,
        ]);
        
        // 他のプロジェクトのメンバー
        ProjectMember::factory()->create([
            'project_id' => $otherProject->id,
            'user_id' => $otherUser->id,
        ]);

        // 実行
        $sortOrders = ProjectMemberSortOrders::from([
            ProjectMemberSortOrder::from('joined_at', 'desc')
        ]);
        
        $result = $this->repository->getByProjectId(
            new ProjectId($targetProject->id->getValue()),
            PaginationPageSize::from(10),
            $sortOrders
        );

        // 検証
        $this->assertCount(1, $result->items());
        $this->assertTrue($result->items()[0]->projectId->equals(ProjectId::from($targetProject->id)));
        $this->assertTrue($result->items()[0]->getUserId()->equals(UserId::from($targetUser->id)));
    }
} 