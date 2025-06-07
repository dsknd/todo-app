<?php

namespace Tests\Unit\Interactors;

use App\Interactors\GetProjectMemberInteractor;
use App\ValueObjects\ProjectId;
use App\ValueObjects\PaginationPageSize;
use App\ValueObjects\ProjectMemberSortOrder;
use App\ValueObjects\ProjectMemberSortOrders;
use App\ReadModels\ProjectMemberSearchResultReadModel;
use App\Models\Project;
use App\Models\User;
use App\Models\ProjectMember;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Group;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\CursorPaginator;

#[Group('interactor')]
#[Group('get_project_member')]
class GetProjectMemberInteractorTest extends TestCase
{
    use RefreshDatabase;
    
    private GetProjectMemberInteractor $interactor;

    protected function setUp(): void
    {
        parent::setUp();
        $this->interactor = app(GetProjectMemberInteractor::class);
    }

    public function test_execute_returns_project_members_with_default_parameters(): void
    {
        // 準備
        $project = Project::factory()->create();
        $users = User::factory()->count(3)->create();
        
        // プロジェクトメンバーを作成（参加日時を異なる時間に設定）
        $members = [];
        foreach ($users as $index => $user) {
            $members[] = ProjectMember::factory()->create([
                'project_id' => $project->id,
                'user_id' => $user->id,
                'joined_at' => now()->subHours($index), // 異なる参加時間
            ]);
        }

        // 実行
        $result = $this->interactor->execute(ProjectId::from($project->id->getValue()));

        // 検証
        $this->assertInstanceOf(CursorPaginator::class, $result);
        $this->assertCount(3, $result->items());
        $this->assertFalse($result->hasMorePages()); // 3件なのでページネーションなし
        $this->assertNull($result->nextCursor());

        $this->assertEquals($members[0]->id->getValue(), $result->items()[0]->projectMemberId->getValue());
        $this->assertEquals($members[1]->id->getValue(), $result->items()[1]->projectMemberId->getValue());
        $this->assertEquals($members[2]->id->getValue(), $result->items()[2]->projectMemberId->getValue());
    }

    // public function test_execute_uses_custom_page_size(): void
    // {
    //     // 準備
    //     $project = Project::factory()->create();
    //     $users = User::factory()->count(5)->create();
        
    //     // 5人のプロジェクトメンバーを作成
    //     foreach ($users as $user) {
    //         ProjectMember::factory()->create([
    //             'project_id' => $project->id,
    //             'user_id' => $user->id,
    //         ]);
    //     }

    //     // 実行（ページサイズ3で取得）
    //     $pageSize = PaginationPageSize::from(3);
    //     $result = $this->interactor->execute(
    //         ProjectId::from($project->id->getValue()),
    //         $pageSize
    //     );

    //     // 検証
    //     $this->assertInstanceOf(ProjectMemberSearchResultReadModel::class, $result);
    //     $this->assertCount(3, $result->members); // ページサイズ通り
    //     $this->assertTrue($result->hasNextPage()); // 残り2件があるので次ページあり
    //     $this->assertNotNull($result->nextToken);
    // }

    // public function test_execute_uses_custom_sort_orders(): void
    // {
    //     // 準備
    //     $project = Project::factory()->create();
    //     $users = User::factory()->count(3)->create();
        
    //     // 参加日時を明確に分けてメンバー作成
    //     $member1 = ProjectMember::factory()->create([
    //         'project_id' => $project->id,
    //         'user_id' => $users[0]->id,
    //         'joined_at' => '2024-01-01 10:00:00',
    //     ]);
    //     $member2 = ProjectMember::factory()->create([
    //         'project_id' => $project->id,
    //         'user_id' => $users[1]->id,
    //         'joined_at' => '2024-01-01 11:00:00',
    //     ]);
    //     $member3 = ProjectMember::factory()->create([
    //         'project_id' => $project->id,
    //         'user_id' => $users[2]->id,
    //         'joined_at' => '2024-01-01 12:00:00',
    //     ]);

    //     // 実行（昇順ソート）
    //     $sortOrders = ProjectMemberSortOrders::from([
    //         ProjectMemberSortOrder::from('joined_at', 'asc')
    //     ]);
    //     $result = $this->interactor->execute(
    //         ProjectId::from($project->id->getValue()),
    //         null,
    //         $sortOrders
    //     );

    //     // 検証
    //     $this->assertInstanceOf(ProjectMemberSearchResultReadModel::class, $result);
    //     $this->assertCount(3, $result->members);
        
    //     // ソート順の検証（昇順なので最初が最も古い参加日時）
    //     $resultMembers = $result->members->toArray();
    //     $this->assertEquals($member1->id->getValue(), $resultMembers[0]->projectMemberId->getValue());
    //     $this->assertEquals($member2->id->getValue(), $resultMembers[1]->projectMemberId->getValue());
    //     $this->assertEquals($member3->id->getValue(), $resultMembers[2]->projectMemberId->getValue());
    // }

    // public function test_execute_returns_empty_result_when_no_members(): void
    // {
    //     // 準備（メンバーのいないプロジェクト）
    //     $project = Project::factory()->create();

    //     // 実行
    //     $result = $this->interactor->execute(ProjectId::from($project->id->getValue()));

    //     // 検証
    //     $this->assertInstanceOf(ProjectMemberSearchResultReadModel::class, $result);
    //     $this->assertTrue($result->isEmpty());
    //     $this->assertCount(0, $result->members);
    //     $this->assertFalse($result->hasNextPage());
    //     $this->assertNull($result->nextToken);
    // }

    // public function test_execute_filters_by_project_id(): void
    // {
    //     // 準備
    //     $project1 = Project::factory()->create();
    //     $project2 = Project::factory()->create();
    //     $users = User::factory()->count(4)->create();
        
    //     // プロジェクト1に2人、プロジェクト2に2人のメンバー
    //     ProjectMember::factory()->create([
    //         'project_id' => $project1->id,
    //         'user_id' => $users[0]->id,
    //     ]);
    //     ProjectMember::factory()->create([
    //         'project_id' => $project1->id,
    //         'user_id' => $users[1]->id,
    //     ]);
    //     ProjectMember::factory()->create([
    //         'project_id' => $project2->id,
    //         'user_id' => $users[2]->id,
    //     ]);
    //     ProjectMember::factory()->create([
    //         'project_id' => $project2->id,
    //         'user_id' => $users[3]->id,
    //     ]);

    //     // 実行（プロジェクト1のメンバーのみ取得）
    //     $result = $this->interactor->execute(ProjectId::from($project1->id->getValue()));

    //     // 検証
    //     $this->assertInstanceOf(ProjectMemberSearchResultReadModel::class, $result);
    //     $this->assertCount(2, $result->members);
        
    //     // 取得されたメンバーが全てプロジェクト1のものであることを確認
    //     foreach ($result->members as $member) {
    //         $this->assertEquals($project1->id->getValue(), $member->projectId->getValue());
    //     }
    // }

    // public function test_execute_with_large_dataset_pagination(): void
    // {
    //     // 準備
    //     $project = Project::factory()->create();
    //     $users = User::factory()->count(25)->create();
        
    //     // 25人のプロジェクトメンバーを作成
    //     foreach ($users as $user) {
    //         ProjectMember::factory()->create([
    //             'project_id' => $project->id,
    //             'user_id' => $user->id,
    //         ]);
    //     }

    //     // 実行（ページサイズ10で取得）
    //     $pageSize = PaginationPageSize::from(10);
    //     $result = $this->interactor->execute(
    //         ProjectId::from($project->id->getValue()),
    //         $pageSize
    //     );

    //     // 検証
    //     $this->assertInstanceOf(ProjectMemberSearchResultReadModel::class, $result);
    //     $this->assertCount(10, $result->members); // ページサイズ通り
    //     $this->assertTrue($result->hasNextPage()); // 残り15件があるので次ページあり
    //     $this->assertNotNull($result->nextToken);
    // }
} 