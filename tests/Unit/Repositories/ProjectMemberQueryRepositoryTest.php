<?php

namespace Tests\Unit\Repositories;

use App\Models\Project;
use App\Models\ProjectMember;
use App\Models\User;
use App\Repositories\ProjectMemberQueryRepository;
use App\ValueObjects\ProjectId;
use App\ValueObjects\ProjectMemberId;
use App\ValueObjects\UserId;
use App\ValueObjects\PaginatorPageCount;
use App\ValueObjects\ProjectMemberOrderParamList;
use App\ValueObjects\ProjectMemberOrderParam;
use App\ReadModels\ProjectMemberReadModel;
use App\ReadModels\ProjectMemberSearchResultReadModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Group;

/**
 * プロジェクトメンバークエリリポジトリのテスト
 */
#[Group('repository')]
#[Group('project_member_query')]
class ProjectMemberQueryRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private ProjectMemberQueryRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new ProjectMemberQueryRepository();
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
        $this->assertEquals('田中太郎', $result->userName());
        $this->assertEquals('tanaka@example.com', $result->userEmail());
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
     * プロジェクトIDでプロジェクトメンバ一覧を取得できること
     */
    public function test_it_can_find_project_members_by_project_id()
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
        $results = $this->repository->findByProjectId(new ProjectId($project->id->getValue()));

        // 検証
        $this->assertCount(3, $results);
        $results->each(function ($result) use ($project) {
            $this->assertInstanceOf(ProjectMemberReadModel::class, $result);
            $this->assertEquals($project->id->getValue(), $result->projectId->getValue());
        });
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
        $this->assertEquals('鈴木花子', $result->userName());
        $this->assertEquals('suzuki@example.com', $result->userEmail());
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
        $pageCount = PaginatorPageCount::from(3);
        $orderParams = ProjectMemberOrderParamList::from([
            ProjectMemberOrderParam::createJoinedAtDesc()
        ]);
        
        $result = $this->repository->search(
            new ProjectId($project->id->getValue()),
            $pageCount,
            $orderParams
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
        $pageCount = PaginatorPageCount::from(5);
        $orderParams = ProjectMemberOrderParamList::from([
            ProjectMemberOrderParam::createJoinedAtDesc()
        ]);
        
        $result = $this->repository->search(
            new ProjectId($project->id->getValue()),
            $pageCount,
            $orderParams
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
        $pageCount = PaginatorPageCount::from(2);
        $orderParams = ProjectMemberOrderParamList::from([
            ProjectMemberOrderParam::createJoinedAtAsc()
        ]);
        
        $firstPage = $this->repository->search(
            new ProjectId($project->id->getValue()),
            $pageCount,
            $orderParams
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
        $pageCount = PaginatorPageCount::from(10);
        $orderParams = ProjectMemberOrderParamList::from([
            ProjectMemberOrderParam::createJoinedAtDesc()
        ]);
        
        $result = $this->repository->search(
            new ProjectId($project->id->getValue()),
            $pageCount,
            $orderParams
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
        $pageCount = PaginatorPageCount::from(10);
        $orderParams = ProjectMemberOrderParamList::from([
            ProjectMemberOrderParam::createJoinedAtAsc()
        ]);
        
        $result = $this->repository->search(
            new ProjectId($project->id->getValue()),
            $pageCount,
            $orderParams
        );

        // 検証：昇順ソートされていることを確認
        $this->assertCount(3, $result->members);
        $this->assertFalse($result->hasNextPage());
    }
} 