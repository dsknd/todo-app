<?php

namespace Tests\Unit\Repositories;

use App\Repositories\EloquentProjectRoleTypeRepository;
use App\ValueObjects\LocaleCode;
use App\ValueObjects\ProjectRoleTypeId;
use App\ReadModels\ProjectRoleTypeReadModel;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Group;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\ProjectRoleTypeSeeder;
use Database\Seeders\ProjectRoleTypeTranslationSeeder;
use App\Enums\ProjectRoleTypeEnum;
use Database\Seeders\LocaleSeeder;
use App\Enums\ProjectRoleTypeTranslationEnum;
use App\Enums\LocaleEnum;
use Illuminate\Database\Eloquent\ModelNotFoundException;

#[Group('repository')]
#[Group('project_role_type')]
class ProjectRoleTypeQueryRepositoryTest extends TestCase
{
    use RefreshDatabase;
    
    private EloquentProjectRoleTypeRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new EloquentProjectRoleTypeRepository();
    }

    public function test_get_returns_project_role_types_for_locale(): void
    {
        $this->seed([
            LocaleSeeder::class,
            ProjectRoleTypeSeeder::class,
            ProjectRoleTypeTranslationSeeder::class,
        ]);
        
        // 英語のロケールで取得
        $localeCode = new LocaleCode('en');
        $result = $this->repository->get($localeCode);
        
        // 結果が空でないことを確認
        $this->assertNotEmpty($result);

        // 結果がProjectRoleTypeReadModelのインスタンスであることを確認
        $this->assertContainsOnlyInstancesOf(ProjectRoleTypeReadModel::class, $result);
        
        // 取得したロールタイプのIDリストを作成
        $actualRoleTypeIds = [];
        foreach ($result as $roleTypeReadModel) {
            $actualRoleTypeIds[] = $roleTypeReadModel->getProjectRoleTypeId();
        }
        
        // 全てのロールタイプが取得できていることを確認
        $expectedRoleTypeIds = array_column(ProjectRoleTypeEnum::cases(), 'value');
        $this->assertEquals(sort($expectedRoleTypeIds), sort($actualRoleTypeIds));

        // 取得したプロジェクトロールタイプの名前が英語であることを確認
        foreach ($result as $roleTypeReadModel) {
            $this->assertEquals(
                $roleTypeReadModel->getName(),
                ProjectRoleTypeTranslationEnum::getName(
                    ProjectRoleTypeEnum::from($roleTypeReadModel->getProjectRoleTypeId()->getValue()),
                    LocaleEnum::ENGLISH,
                )
            );
        }
    }

    public function test_get_returns_empty_collection_when_no_role_types_exist(): void
    {
        // 準備（シーダーを実行しない）
        $this->seed([
            ProjectRoleTypeSeeder::class,
        ]);

        // 実行
        $localeCode = new LocaleCode('en');
        $result = $this->repository->get($localeCode);

        // 検証
        $this->assertEmpty($result);
    }

    public function test_find_returns_specific_project_role_type(): void
    {
        // 準備
        $this->seed([
            LocaleSeeder::class,
            ProjectRoleTypeSeeder::class,
            ProjectRoleTypeTranslationSeeder::class,
        ]);

        // 実行（管理者ロールを取得）
        $localeCode = new LocaleCode('en');
        $projectRoleTypeId = ProjectRoleTypeId::from(ProjectRoleTypeEnum::DEFAULT->value);
        $result = $this->repository->find($projectRoleTypeId, $localeCode);

        // 検証
        $this->assertInstanceOf(ProjectRoleTypeReadModel::class, $result);
        $this->assertEquals(
            ProjectRoleTypeEnum::DEFAULT->value,
            $result->getProjectRoleTypeId()->getValue()
        );
        $this->assertEquals(
            ProjectRoleTypeTranslationEnum::getName(
                ProjectRoleTypeEnum::DEFAULT,
                LocaleEnum::ENGLISH
            ),
            $result->getName()
        );
        $this->assertNotEmpty($result->getDescription());
    }

    public function test_find_throws_exception_when_role_type_not_found(): void
    {
        // 期待される例外
        $this->expectException(ModelNotFoundException::class);

        // 実行（存在しないIDで検索）
        $projectRoleTypeId = new ProjectRoleTypeId(999);
        $localeCode = new LocaleCode('en');
        $this->repository->find($projectRoleTypeId, $localeCode);
    }
}