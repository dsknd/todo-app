<?php

namespace Tests\Unit\Interactors;

use App\Interactors\CreateProjectInteractor;
use App\Models\Project;
use App\Models\User;
use App\ValueObjects\UserId;
use DateTimeImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\ProjectStatus;
use App\Enums\LocaleEnum;
use App\Models\ProjectPermission;
use App\Models\Permission;

class CreateProjectInteractorTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @var \App\Models\User&\Illuminate\Contracts\Auth\Authenticatable
     */
    private User $user;
    private CreateProjectInteractor $interactor;
    private ProjectStatus $projectStatus;
    private array $permissions;
    private array $projectPermissions;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->interactor = app(CreateProjectInteractor::class);
        $this->projectStatus = ProjectStatus::factory()->create();
        $this->permissions = Permission::factory()->createAll();
        $this->projectPermissions = ProjectPermission::factory()->createAll();
    }

    public function test_execute_creates_project_successfully(): void
    {
        // 準備
        $name = 'テストプロジェクト';
        $description = 'これはテスト用のプロジェクトです';
        $userId = new UserId($this->user->id);
        $isPrivate = false;
        $plannedStartDate = new DateTimeImmutable('2023-01-01');
        $plannedEndDate = new DateTimeImmutable('2023-12-31');
        $locale = LocaleEnum::JAPANESE;
        
        // 実行
        $project = $this->interactor->execute(
            $name,
            $description,
            $userId,
            $isPrivate,
            $plannedStartDate,
            $plannedEndDate,
            $locale
        );
        
        // 検証
        $this->assertInstanceOf(Project::class, $project);
        $this->assertEquals($name, $project->name);
        $this->assertEquals($description, $project->description);
        $this->assertEquals($userId->getId(), $project->user_id);
        $this->assertEquals($isPrivate, $project->is_private);
        $this->assertEquals($plannedStartDate, $project->planned_start_date);
        $this->assertEquals($plannedEndDate, $project->planned_end_date);
        $this->assertEquals($this->projectStatus->id, $project->project_status_id);

        // データベースに保存されていることを確認
        $this->assertDatabaseHas('projects', [
            'name' => $name,
            'description' => $description,
            'user_id' => $userId->getId(),
            'is_private' => $isPrivate,
            'project_status_id' => $this->projectStatus->id,
            'planned_start_date' => $plannedStartDate,
            'planned_end_date' => $plannedEndDate,
        ]);
    }

    // TODO: projectsテーブルのレコード挿入に失敗
    // TODO: project_membersテーブルのレコード挿入に失敗
    // TODO: project_rolesテーブルのレコード挿入に失敗
    // TODO: project_permission_assignmentsテーブルのレコード挿入に失敗
} 