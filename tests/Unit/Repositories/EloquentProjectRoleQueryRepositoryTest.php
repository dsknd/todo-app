<?php

namespace Tests\Unit\Repositories;

use App\Repositories\EloquentProjectRoleQueryRepository;
use App\ValueObjects\LocaleCode;
use App\ValueObjects\ProjectRoleId;
use App\ValueObjects\ProjectId;
use App\ReadModels\ProjectRoleReadModel;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Group;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\LocaleSeeder;
use Database\Seeders\ProjectRoleTypeSeeder;
use Database\Seeders\ProjectRoleTypeTranslationSeeder;
use Database\Seeders\DefaultProjectRoleSeeder;
use Database\Seeders\DefaultProjectRoleTranslationSeeder;
use App\Models\ProjectRole;
use App\Models\CustomProjectRole;
use App\Models\Project;
use App\Models\User;
use App\Enums\ProjectRoleTypeEnum;
use Illuminate\Database\Eloquent\ModelNotFoundException;

#[Group('repository')]
#[Group('project_role_query')]
class EloquentProjectRoleQueryRepositoryTest extends TestCase
{
    use RefreshDatabase;
    
    private EloquentProjectRoleQueryRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new EloquentProjectRoleQueryRepository();
        
        // 基本的なシーダーを実行
        $this->seed([
            LocaleSeeder::class,
            ProjectRoleTypeSeeder::class,
            ProjectRoleTypeTranslationSeeder::class,
            DefaultProjectRoleSeeder::class,
            DefaultProjectRoleTranslationSeeder::class,
        ]);
    }

    public function test_find_returns_default_project_role(): void
    {
        // 準備 - OWNERロール（ID: 1）を使用
        $projectRoleId = new ProjectRoleId(\App\Enums\DefaultProjectRoleEnum::OWNER->value);
        $localeCode = new LocaleCode('en');

        // 実行
        $result = $this->repository->find($projectRoleId, $localeCode);

        // 検証
        $this->assertInstanceOf(ProjectRoleReadModel::class, $result);
        $this->assertEquals(\App\Enums\DefaultProjectRoleEnum::OWNER->value, $result->projectRoleId->getValue());
        $this->assertEquals(ProjectRoleTypeEnum::DEFAULT->value, $result->projectRoleType->id->getValue());
        // OWNERロールは assignableLimit が 1
        $this->assertEquals(1, $result->assignableLimit);
        $this->assertEquals(0, $result->assignedCount);
        // name と description はデフォルトロールの翻訳データから取得される
        $this->assertNotEmpty($result->name);
        $this->assertNotEmpty($result->description);
    }

    // public function test_find_returns_custom_project_role(): void
    // {
    //     // 準備
    //     $user = User::factory()->create();
    //     $project = Project::factory()->create(['owner_id' => $user->id]);
        
    //     $projectRole = ProjectRole::factory()->create([
    //         'project_role_type_id' => ProjectRoleTypeEnum::CUSTOM->value,
    //         'assignable_limit' => 3,
    //         'assigned_count' => 1,
    //     ]);
        
    //     $customProjectRole = CustomProjectRole::factory()->create([
    //         'project_role_id' => $projectRole->id,
    //         'project_id' => $project->id,
    //         'name' => 'カスタムロール',
    //         'description' => 'カスタムロールの説明',
    //     ]);
        
    //     $localeCode = new LocaleCode('en');
    //     $projectRoleId = new ProjectRoleId($projectRole->id);

    //     // 実行
    //     $result = $this->repository->find($projectRoleId, $localeCode);

    //     // 検証
    //     $this->assertInstanceOf(ProjectRoleReadModel::class, $result);
    //     $this->assertEquals($projectRole->id, $result->projectRoleId->getValue());
    //     $this->assertEquals(ProjectRoleTypeEnum::CUSTOM->value, $result->projectRoleType->getProjectRoleTypeId());
    //     $this->assertEquals('カスタムロール', $result->name);
    //     $this->assertEquals('カスタムロールの説明', $result->description);
    //     $this->assertEquals(3, $result->assignableLimit);
    //     $this->assertEquals(1, $result->assignedCount);
    // }

    // public function test_find_throws_exception_when_role_not_found(): void
    // {
    //     // 期待される例外
    //     $this->expectException(ModelNotFoundException::class);

    //     // 実行（存在しないIDで検索）
    //     $projectRoleId = new ProjectRoleId(999);
    //     $localeCode = new LocaleCode('en');
    //     $this->repository->find($projectRoleId, $localeCode);
    // }

    // public function test_getByProjectId_returns_custom_project_roles(): void
    // {
    //     // 準備
    //     $user = User::factory()->create();
    //     $project = Project::factory()->create(['owner_id' => $user->id]);
    //     $anotherProject = Project::factory()->create(['owner_id' => $user->id]);
        
    //     // 対象プロジェクトのカスタムロール
    //     $projectRole1 = ProjectRole::factory()->create([
    //         'project_role_type_id' => ProjectRoleTypeEnum::CUSTOM->value,
    //         'assignable_limit' => 2,
    //         'assigned_count' => 0,
    //     ]);
        
    //     $customProjectRole1 = CustomProjectRole::factory()->create([
    //         'project_role_id' => $projectRole1->id,
    //         'project_id' => $project->id,
    //         'name' => 'ロール1',
    //         'description' => 'ロール1の説明',
    //     ]);
        
    //     $projectRole2 = ProjectRole::factory()->create([
    //         'project_role_type_id' => ProjectRoleTypeEnum::CUSTOM->value,
    //         'assignable_limit' => 4,
    //         'assigned_count' => 1,
    //     ]);
        
    //     $customProjectRole2 = CustomProjectRole::factory()->create([
    //         'project_role_id' => $projectRole2->id,
    //         'project_id' => $project->id,
    //         'name' => 'ロール2',
    //         'description' => 'ロール2の説明',
    //     ]);
        
    //     // 別プロジェクトのカスタムロール（取得されないはず）
    //     $projectRole3 = ProjectRole::factory()->create([
    //         'project_role_type_id' => ProjectRoleTypeEnum::CUSTOM->value,
    //         'assignable_limit' => 1,
    //         'assigned_count' => 0,
    //     ]);
        
    //     $customProjectRole3 = CustomProjectRole::factory()->create([
    //         'project_role_id' => $projectRole3->id,
    //         'project_id' => $anotherProject->id,
    //         'name' => 'ロール3',
    //         'description' => 'ロール3の説明',
    //     ]);
        
    //     $localeCode = new LocaleCode('en');
    //     $projectId = new ProjectId($project->id);

    //     // 実行
    //     $result = $this->repository->getByProjectId($projectId, $localeCode);

    //     // 検証
    //     $this->assertCount(2, $result);
    //     $this->assertContainsOnlyInstancesOf(ProjectRoleReadModel::class, $result);
        
    //     // 取得されたロールのIDを確認
    //     $retrievedRoleIds = $result->map(fn($role) => $role->projectRoleId->getValue())->toArray();
    //     $this->assertContains($projectRole1->id, $retrievedRoleIds);
    //     $this->assertContains($projectRole2->id, $retrievedRoleIds);
    //     $this->assertNotContains($projectRole3->id, $retrievedRoleIds);
        
    //     // 各ロールの詳細を確認
    //     foreach ($result as $role) {
    //         $this->assertEquals(ProjectRoleTypeEnum::CUSTOM->value, $role->projectRoleType->getProjectRoleTypeId());
    //         $this->assertNotEmpty($role->name);
    //         $this->assertNotEmpty($role->description);
    //     }
    // }

    // public function test_getByProjectId_returns_empty_collection_when_no_roles_exist(): void
    // {
    //     // 準備
    //     $user = User::factory()->create();
    //     $project = Project::factory()->create(['owner_id' => $user->id]);
        
    //     $localeCode = new LocaleCode('en');
    //     $projectId = new ProjectId($project->id);

    //     // 実行
    //     $result = $this->repository->getByProjectId($projectId, $localeCode);

    //     // 検証
    //     $this->assertEmpty($result);
    // }

    // public function test_find_works_with_japanese_locale(): void
    // {
    //     // 準備
    //     $projectRole = ProjectRole::factory()->create([
    //         'project_role_type_id' => ProjectRoleTypeEnum::DEFAULT->value,
    //         'assignable_limit' => 5,
    //         'assigned_count' => 2,
    //     ]);
        
    //     $localeCode = new LocaleCode('ja');
    //     $projectRoleId = new ProjectRoleId($projectRole->id);

    //     // 実行
    //     $result = $this->repository->find($projectRoleId, $localeCode);

    //     // 検証
    //     $this->assertInstanceOf(ProjectRoleReadModel::class, $result);
    //     $this->assertEquals($projectRole->id, $result->projectRoleId->getValue());
    //     $this->assertNotEmpty($result->name);
    //     $this->assertNotEmpty($result->description);
    // }
}