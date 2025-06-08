<?php

namespace Tests\Feature\Interactors;

use App\Interactors\GetProjectRoleTypeInteractor;
use App\ValueObjects\LocaleCode;
use App\ValueObjects\ProjectRoleTypeId;
use App\ReadModels\ProjectRoleTypeReadModel;
use App\Enums\ProjectRoleTypeEnum;
use App\Enums\ProjectRoleTypeTranslationEnum;
use App\Enums\LocaleEnum;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Group;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\LocaleSeeder;
use Database\Seeders\ProjectRoleTypeSeeder;
use Database\Seeders\ProjectRoleTypeTranslationSeeder;

#[Group('integration')]
#[Group('get_project_role_type')]
class GetProjectRoleTypeInteractorIntegrationTest extends TestCase
{
    use RefreshDatabase;
    
    private GetProjectRoleTypeInteractor $interactor;

    protected function setUp(): void
    {
        parent::setUp();
        
        // 実際のインタラクターを使用（DIコンテナから取得）
        $this->interactor = app(GetProjectRoleTypeInteractor::class);
    }

    public function test_execute_returns_all_project_role_types_with_english_translations(): void
    {
        // 準備：データベースに実際のデータを投入
        $this->seed([
            LocaleSeeder::class,
            ProjectRoleTypeSeeder::class,
            ProjectRoleTypeTranslationSeeder::class,
        ]);
        
        // 実行
        $localeCode = new LocaleCode('en');
        $result = $this->interactor->execute($localeCode);
        
        // 検証：結果の型と件数
        $this->assertNotEmpty($result);
        $this->assertContainsOnlyInstancesOf(ProjectRoleTypeReadModel::class, $result);
        $this->assertCount(count(ProjectRoleTypeEnum::cases()), $result);
        
        // 検証：各ロールタイプが正しく取得されているか
        foreach (ProjectRoleTypeEnum::cases() as $expectedRoleType) {
            $foundRole = $result->first(function ($role) use ($expectedRoleType) {
                return $role->getProjectRoleTypeId()->getValue() === $expectedRoleType->value;
            });
            
            $this->assertNotNull($foundRole, "Role type {$expectedRoleType->name} should exist");
            
            // 英語の翻訳が正しいか確認
            $expectedName = ProjectRoleTypeTranslationEnum::getName(
                $expectedRoleType,
                LocaleEnum::ENGLISH
            );
            $this->assertEquals($expectedName, $foundRole->getName());
            
            // 説明が存在することを確認
            $this->assertNotEmpty($foundRole->getDescription());
        }
    }

    public function test_execute_returns_all_project_role_types_with_japanese_translations(): void
    {
        // 準備：データベースに実際のデータを投入
        $this->seed([
            LocaleSeeder::class,
            ProjectRoleTypeSeeder::class,
            ProjectRoleTypeTranslationSeeder::class,
        ]);
        
        // 実行
        $localeCode = new LocaleCode('ja');
        $result = $this->interactor->execute($localeCode);
        
        // 検証：結果の型と件数
        $this->assertNotEmpty($result);
        $this->assertContainsOnlyInstancesOf(ProjectRoleTypeReadModel::class, $result);
        $this->assertCount(count(ProjectRoleTypeEnum::cases()), $result);
        
        // 検証：日本語の翻訳が正しいか
        foreach (ProjectRoleTypeEnum::cases() as $expectedRoleType) {
            $foundRole = $result->first(function ($role) use ($expectedRoleType) {
                return $role->getProjectRoleTypeId()->getValue() === $expectedRoleType->value;
            });
            
            $this->assertNotNull($foundRole);
            
            // 日本語の翻訳が正しいか確認
            $expectedName = ProjectRoleTypeTranslationEnum::getName(
                $expectedRoleType,
                LocaleEnum::JAPANESE
            );
            $this->assertEquals($expectedName, $foundRole->getName());
        }
    }

    public function test_execute_returns_empty_collection_when_no_translations_exist(): void
    {
        // 準備：ロールタイプのみで翻訳データなし
        $this->seed([
            LocaleSeeder::class,
            ProjectRoleTypeSeeder::class,
            // ProjectRoleTypeTranslationSeederを実行しない
        ]);
        
        // 実行
        $localeCode = new LocaleCode('en');
        $result = $this->interactor->execute($localeCode);
        
        // 検証：翻訳がないため空のコレクションが返される
        $this->assertEmpty($result);
    }

    public function test_execute_returns_consistent_results_between_calls(): void
    {
        // 準備
        $this->seed([
            LocaleSeeder::class,
            ProjectRoleTypeSeeder::class,
            ProjectRoleTypeTranslationSeeder::class,
        ]);
        
        $localeCode = new LocaleCode('en');
        
        // 実行：同じロケールで2回実行
        $result1 = $this->interactor->execute($localeCode);
        $result2 = $this->interactor->execute($localeCode);
        
        // 検証：結果が同じであること
        $this->assertEquals($result1->count(), $result2->count());
        
        // 各要素が同じであることを確認
        foreach ($result1 as $index => $role1) {
            $role2 = $result2[$index];
            $this->assertEquals(
                $role1->getProjectRoleTypeId()->getValue(),
                $role2->getProjectRoleTypeId()->getValue()
            );
            $this->assertEquals($role1->getName(), $role2->getName());
            $this->assertEquals($role1->getDescription(), $role2->getDescription());
        }
    }

    public function test_execute_with_different_locales_returns_different_translations(): void
    {
        // 準備
        $this->seed([
            LocaleSeeder::class,
            ProjectRoleTypeSeeder::class,
            ProjectRoleTypeTranslationSeeder::class,
        ]);
        
        // 実行：英語と日本語でそれぞれ取得
        $englishResult = $this->interactor->execute(new LocaleCode('en'));
        $japaneseResult = $this->interactor->execute(new LocaleCode('ja'));
        
        // 検証：同じ数のロールタイプが返される
        $this->assertEquals($englishResult->count(), $japaneseResult->count());
        
        // 検証：各ロールタイプのIDは同じだが、名前は異なる
        foreach ($englishResult as $index => $englishRole) {
            $japaneseRole = $japaneseResult[$index];
            
            // IDは同じ
            $this->assertEquals(
                $englishRole->getProjectRoleTypeId()->getValue(),
                $japaneseRole->getProjectRoleTypeId()->getValue()
            );
            
            // 名前は異なる（翻訳されている）
            $this->assertNotEquals(
                $englishRole->getName(),
                $japaneseRole->getName()
            );
        }
    }

    public function test_execute_performance_with_multiple_calls(): void
    {
        // 準備
        $this->seed([
            LocaleSeeder::class,
            ProjectRoleTypeSeeder::class,
            ProjectRoleTypeTranslationSeeder::class,
        ]);
        
        $localeCode = new LocaleCode('en');
        
        // 実行：パフォーマンステスト（10回実行）
        $startTime = microtime(true);
        
        for ($i = 0; $i < 10; $i++) {
            $result = $this->interactor->execute($localeCode);
            $this->assertNotEmpty($result);
        }
        
        $endTime = microtime(true);
        $executionTime = $endTime - $startTime;
        
        // 検証：10回の実行が1秒以内に完了すること
        $this->assertLessThan(1.0, $executionTime, 'Multiple executions should complete within 1 second');
    }
}