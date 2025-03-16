<?php

namespace Tests\Unit\Interactors;

use App\Interactors\CreateProjectInteractor;
use App\Models\Project;
use App\Models\User;
use App\Models\ProjectMember;
use Illuminate\Contracts\Auth\Authenticatable;
use App\ValueObjects\UserId;
use DateTimeImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\ProjectStatus;
use App\Models\ProjectPermission;
use App\Models\Permission;
use App\Enums\ProjectStatusEnum;
use App\Enums\DefaultProjectRoleEnum;
use App\ValueObjects\ProjectRoleId;
use Illuminate\Support\Facades\DB;
use Exception;
use PHPUnit\Framework\Attributes\Group;
use App\Models\ProjectRole;
#[Group('interactor')]
#[Group('create_project')]
class CreateProjectInteractorTest extends TestCase
{
    use RefreshDatabase;

    private CreateProjectInteractor $interactor;

    protected function setUp(): void
    {
        parent::setUp();
        $this->interactor = app(CreateProjectInteractor::class);
    }

    public function test_execute_creates_project_successfully(): void
    {

        // 準備
        $user = User::factory()->create();
        ProjectStatus::factory()->create(['id' => ProjectStatusEnum::PLANNING->value]);
        ProjectRole::factory()->create(['id' => DefaultProjectRoleEnum::OWNER->value]);

        $name = 'Test Project';
        $description = 'Test Description';
        $userId = $user->id;
        $isPrivate = true;
        $plannedStartDate = new DateTimeImmutable('2024-01-01');
        $plannedEndDate = new DateTimeImmutable('2024-12-31');

        // 実行
        $project = $this->interactor->execute(
            $name,
            $description,
            $userId,
            $isPrivate,
            $plannedStartDate,
            $plannedEndDate
        );

        // プロジェクトの検証
        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'name' => $name,
            'description' => $description,
            'user_id' => $userId->getValue(),
            'project_status_id' => ProjectStatusEnum::PLANNING->value,
            'is_private' => $isPrivate,
            'planned_start_date' => $plannedStartDate->format('Y-m-d'),
            'planned_end_date' => $plannedEndDate->format('Y-m-d'),
        ]);

        // プロジェクトメンバー（オーナー）の検証
        $this->assertDatabaseHas('project_members', [
            'project_id' => $project->id,
            'user_id' => $userId->getValue(),
            'role_id' => ProjectRoleId::fromEnum(DefaultProjectRoleEnum::OWNER)->getValue(),
        ]);
    }

    // public function test_execute_creates_project_with_minimal_parameters(): void
    // {
    //     // 準備
    //     $name = 'Test Project';
    //     $userId = new UserId((int) $this->user->id);

    //     // 実行
    //     $project = $this->interactor->execute(
    //         $name,
    //         null,  // description
    //         $userId,
    //         false, // isPrivate
    //         null,  // plannedStartDate
    //         null   // plannedEndDate
    //     );

    //     // 検証
    //     $this->assertDatabaseHas('projects', [
    //         'id' => $project->id,
    //         'name' => $name,
    //         'description' => null,
    //         'user_id' => $userId->getValue(),
    //         'project_status_id' => ProjectStatusEnum::PLANNING->value,
    //         'is_private' => false,
    //         'planned_start_date' => null,
    //         'planned_end_date' => null,
    //     ]);
    // }

    // public function test_execute_rolls_back_transaction_on_failure(): void
    // {
    //     // 準備
    //     $name = 'Test Project';
    //     $userId = new UserId((int) $this->user->id);

    //     // プロジェクトメンバー作成時にエラーを発生させる
    //     $mockProjectMemberRepository = $this->mock('App\Repositories\Interfaces\ProjectMemberRepository');
    //     $mockProjectMemberRepository->shouldReceive('add')
    //         ->once()
    //         ->andThrow(new Exception('Failed to create project member'));

    //     // 実行と検証
    //     $this->expectException(Exception::class);
    //     $this->expectExceptionMessage('Failed to create project member');

    //     try {
    //         $this->interactor->execute(
    //             $name,
    //             null,
    //             $userId,
    //             false,
    //             null,
    //             null
    //         );
    //     } catch (Exception $e) {
    //         // プロジェクトが作成されていないことを確認
    //         $this->assertDatabaseCount('projects', 0);
    //         // プロジェクトメンバーが作成されていないことを確認
    //         $this->assertDatabaseCount('project_members', 0);
            
    //         throw $e;
    //     }
    // }

    // public function test_execute_sets_correct_project_status(): void
    // {
    //     // 準備
    //     $name = 'Test Project';
    //     $userId = new UserId((int) $this->user->id);

    //     // 実行
    //     $project = $this->interactor->execute(
    //         $name,
    //         null,
    //         $userId,
    //         false,
    //         null,
    //         null
    //     );

    //     // 検証
    //     $this->assertEquals(
    //         ProjectStatusEnum::PLANNING->value,
    //         $project->project_status_id
    //     );
    // }

    // TODO: projectsテーブルのレコード挿入に失敗
    // TODO: project_membersテーブルのレコード挿入に失敗
    // TODO: project_rolesテーブルのレコード挿入に失敗
    // TODO: project_permission_assignmentsテーブルのレコード挿入に失敗
} 