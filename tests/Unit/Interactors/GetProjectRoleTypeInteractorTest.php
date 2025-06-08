<?php

namespace Tests\Unit\Interactors;

use App\Interactors\GetProjectRoleTypeInteractor;
use App\Repositories\Interfaces\ProjectRoleTypeQueryRepository;
use App\ValueObjects\LocaleCode;
use App\ValueObjects\ProjectRoleTypeId;
use App\ReadModels\ProjectRoleTypeReadModel;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Group;
use Mockery;
use Illuminate\Support\Collection;

#[Group('interactor')]
#[Group('get_project_role_type')]
class GetProjectRoleTypeInteractorTest extends TestCase
{
    private GetProjectRoleTypeInteractor $interactor;
    private $mockRepository;

    protected function setUp(): void
    {
        parent::setUp();
        
        // モックリポジトリを作成
        $this->mockRepository = Mockery::mock(ProjectRoleTypeQueryRepository::class);
        
        // インタラクターを作成
        $this->interactor = new GetProjectRoleTypeInteractor($this->mockRepository);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_execute_returns_project_role_types_for_locale(): void
    {
        // 準備
        $localeCode = new LocaleCode('en');
        
        // 期待される結果を作成
        $expectedRoleTypes = new Collection([
            new ProjectRoleTypeReadModel(
                new ProjectRoleTypeId(1),
                'Administrator',
                'Full access to all project features'
            ),
            new ProjectRoleTypeReadModel(
                new ProjectRoleTypeId(2),
                'Custom',
                'Customizable role with specific permissions'
            ),
        ]);
        
        // モックの期待値を設定
        $this->mockRepository
            ->shouldReceive('get')
            ->once()
            ->with($localeCode)
            ->andReturn($expectedRoleTypes);
        
        // 実行
        $result = $this->interactor->execute($localeCode);
        
        // 検証
        $this->assertInstanceOf(Collection::class, $result);
        $this->assertEquals($expectedRoleTypes, $result);
        $this->assertCount(2, $result);
        $this->assertContainsOnlyInstancesOf(ProjectRoleTypeReadModel::class, $result);
    }

    public function test_execute_returns_empty_collection_when_no_role_types(): void
    {
        // 準備
        $localeCode = new LocaleCode('en');
        $emptyCollection = new Collection();
        
        // モックの期待値を設定
        $this->mockRepository
            ->shouldReceive('get')
            ->once()
            ->with($localeCode)
            ->andReturn($emptyCollection);
        
        // 実行
        $result = $this->interactor->execute($localeCode);
        
        // 検証
        $this->assertInstanceOf(Collection::class, $result);
        $this->assertTrue($result->isEmpty());
    }

    public function test_execute_returns_japanese_role_types(): void
    {
        // 準備
        $localeCode = new LocaleCode('ja');
        
        // 期待される結果を作成（日本語）
        $expectedRoleTypes = new Collection([
            new ProjectRoleTypeReadModel(
                new ProjectRoleTypeId(1),
                '管理者',
                'プロジェクトのすべての機能へのフルアクセス'
            ),
            new ProjectRoleTypeReadModel(
                new ProjectRoleTypeId(2),
                'カスタム',
                '特定の権限を持つカスタマイズ可能なロール'
            ),
        ]);
        
        // モックの期待値を設定
        $this->mockRepository
            ->shouldReceive('get')
            ->once()
            ->with($localeCode)
            ->andReturn($expectedRoleTypes);
        
        // 実行
        $result = $this->interactor->execute($localeCode);
        
        // 検証
        $this->assertInstanceOf(Collection::class, $result);
        $this->assertEquals($expectedRoleTypes, $result);
        
        // 日本語の名前が返されていることを確認
        $firstRole = $result->first();
        $this->assertEquals('管理者', $firstRole->getName());
    }

    public function test_execute_handles_different_locales(): void
    {
        // 準備
        $englishLocale = new LocaleCode('en');
        $japaneseLocale = new LocaleCode('ja');
        
        $englishRoles = new Collection([
            new ProjectRoleTypeReadModel(
                new ProjectRoleTypeId(1),
                'Administrator',
                'Full access'
            ),
        ]);
        
        $japaneseRoles = new Collection([
            new ProjectRoleTypeReadModel(
                new ProjectRoleTypeId(1),
                '管理者',
                'フルアクセス'
            ),
        ]);
        
        // モックの期待値を設定
        $this->mockRepository
            ->shouldReceive('get')
            ->once()
            ->with($englishLocale)
            ->andReturn($englishRoles);
            
        $this->mockRepository
            ->shouldReceive('get')
            ->once()
            ->with($japaneseLocale)
            ->andReturn($japaneseRoles);
        
        // 実行と検証（英語）
        $englishResult = $this->interactor->execute($englishLocale);
        $this->assertEquals('Administrator', $englishResult->first()->getName());
        
        // 実行と検証（日本語）
        $japaneseResult = $this->interactor->execute($japaneseLocale);
        $this->assertEquals('管理者', $japaneseResult->first()->getName());
    }
}