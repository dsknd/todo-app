<?php

namespace Tests\Unit\Interactors;

use App\Interactors\FetchOwnedProjectsInteractor;
use App\Models\Project;
use App\Models\User;
use App\Repositories\EloquentProjectRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Group;
use App\Exceptions\InternalServerErrorException;
use App\Repositories\Interfaces\ProjectRepository;
use Illuminate\Database\QueryException;
use PDOException;
#[Group('interactor')]
#[Group('fetch_owned_projects')]
class FetchOwnedProjectsInteractorTest extends TestCase
{
    use RefreshDatabase;

    private FetchOwnedProjectsInteractor $interactor;

    protected function setUp(): void
    {
        parent::setUp();
        $this->interactor = new FetchOwnedProjectsInteractor(
            new EloquentProjectRepository()
        );
    }

    public function test_execute_finds_projects_created_by_user(): void
    {
        // 準備
        $user = User::factory()->create();
        
        // ユーザーが作成したプロジェクト
        $ownedProjects = Project::factory()->count(5)->create([
            'user_id' => $user->id,
        ]);

        // 他のユーザーのプロジェクト
        Project::factory()->count(3)->create();

        // 実行
        $result = $this->interactor->execute($user->id);

        // 検証
        $this->assertEquals(5, $result->total());
        foreach ($result as $project) {
            $this->assertEquals($user->id->getValue(), $project->user_id->getValue());
        }
    }

    public function test_execute_returns_empty_paginator_when_no_projects(): void
    {
        // 準備
        $user = User::factory()->create();

        // 他のユーザーのプロジェクトのみ作成
        Project::factory()->count(3)->create();

        // 実行
        $result = $this->interactor->execute($user->id);

        // 検証
        $this->assertEquals(0, $result->total());
    }

    public function test_execute_respects_per_page_parameter(): void
    {
        // 準備
        $user = User::factory()->create();
        Project::factory()->count(10)->create([
            'user_id' => $user->id,
        ]);

        // 実行
        $result = $this->interactor->execute($user->id, 5);

        // 検証
        $this->assertEquals(10, $result->total());
        $this->assertEquals(5, $result->perPage());
        $this->assertEquals(2, $result->lastPage());
    }

    public function test_execute_throws_internal_server_error_exception_when_failed_to_fetch_projects(): void
    {
        // 準備
        $user = User::factory()->create();
        
        // ProjectRepositoryのモックを作成
        $mockProjectRepository = $this->mock(ProjectRepository::class);
        $previous = new PDOException("DB接続エラー");
        $queryException = new QueryException('test', '', [], $previous);
        $mockProjectRepository->shouldReceive('findByUserId')
            ->once()
            ->andThrow($queryException);
        
        // インターフェースにモックをバインド
        $this->app->instance(
            ProjectRepository::class,
            $mockProjectRepository
        );

        // インタラクターを再生成（新しいモックを使用するため）
        $this->interactor = app(FetchOwnedProjectsInteractor::class);

        // 実行
        $this->expectException(InternalServerErrorException::class);
        $this->interactor->execute($user->id);
    }
} 