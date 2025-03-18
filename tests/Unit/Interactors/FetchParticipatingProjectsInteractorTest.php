<?php

namespace Tests\Unit\Interactors;

use App\Interactors\FetchParticipatingProjectsInteractor;
use App\Models\Project;
use App\Models\ProjectMember;
use App\Models\User;
use App\Repositories\EloquentProjectRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Group;

#[Group('interactor')]
#[Group('fetch_participating_projects')]
class FetchParticipatingProjectsInteractorTest extends TestCase
{
    use RefreshDatabase;

    private FetchParticipatingProjectsInteractor $interactor;

    protected function setUp(): void
    {
        parent::setUp();
        $this->interactor = new FetchParticipatingProjectsInteractor(
            new EloquentProjectRepository()
        );
    }

    public function test_execute_finds_projects_where_user_is_member(): void
    {
        // 準備
        $user = User::factory()->create();

        // ユーザーがメンバーとして参加しているプロジェクト
        foreach (range(1, 10) as $i) {
            ProjectMember::factory()->create([
                'user_id' => $user->id,
            ]);
        }

        // 実行
        $projects = $this->interactor->execute($user->id);  // 直接UserIdオブジェクトを渡す

        // 検証
        $this->assertCount(10, $projects);
        foreach ($projects as $project) {
            $this->assertDatabaseHas('project_members', [
                'project_id' => $project->id,
                'user_id' => $user->id,
            ]);
        }
    }

    public function test_execute_returns_empty_collection_when_no_projects(): void
    {
        // 準備
        $user = User::factory()->create();

        // 他のユーザーのプロジェクトを作成
        Project::factory()->create();

        // 実行
        $projects = $this->interactor->execute($user->id);

        // 検証
        $this->assertCount(0, $projects);
    }
} 