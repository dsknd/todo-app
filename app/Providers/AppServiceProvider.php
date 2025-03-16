<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\UseCases\CheckProjectRolePermissionUseCase;
use App\UseCases\Implementations\CheckProjectRolePermission;
use App\Interactors\CreateProjectInteractor;
use App\UseCases\CreateProjectUseCase;
use App\Interactors\CreateTaskInteractor;
use App\UseCases\CreateTaskUseCase;
use App\Repositories\Interfaces\ProjectRepository;
use App\Repositories\EloquentProjectRepository;
use App\Repositories\Interfaces\ProjectMemberRepository;
use App\Repositories\EloquentProjectMemberRepository;
use App\Repositories\Interfaces\ProjectRoleRepository;
use App\Repositories\EloquentProjectRoleRepository;
use App\Repositories\Interfaces\DefaultProjectRoleRepository;
use App\Repositories\EloquentDefaultProjectRoleRepository;
use App\Repositories\Interfaces\CustomProjectRoleRepository;
use App\Repositories\EloquentCustomProjectRoleRepository;
use App\Repositories\Interfaces\ProjectRolePermissionRepository;
use App\Repositories\EloquentProjectRolePermissionRepository;
use App\Repositories\Interfaces\PermissionRepository;
use App\Repositories\EloquentPermissionRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CheckProjectRolePermissionUseCase::class, CheckProjectRolePermission::class);

        // ユースケース
        $this->app->bind(CreateProjectUseCase::class, CreateProjectInteractor::class);
        $this->app->bind(CreateTaskUseCase::class, CreateTaskInteractor::class);

        // リポジトリ
        $this->app->bind(ProjectRepository::class, EloquentProjectRepository::class);
        $this->app->bind(ProjectMemberRepository::class, EloquentProjectMemberRepository::class);
        $this->app->bind(ProjectRoleRepository::class, EloquentProjectRoleRepository::class);
        $this->app->bind(DefaultProjectRoleRepository::class, EloquentDefaultProjectRoleRepository::class);
        $this->app->bind(CustomProjectRoleRepository::class, EloquentCustomProjectRoleRepository::class);
        $this->app->bind(ProjectRolePermissionRepository::class, EloquentProjectRolePermissionRepository::class);
        $this->app->bind(PermissionRepository::class, EloquentPermissionRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        // DB::listen(function ($query) {
        //     // クエリ内容、バインディング、実行時間をログに出力
        //     Log::info('SQL: ' . $query->sql);
        //     Log::info('Bindings: ', $query->bindings);
        //     Log::info('Time: ' . $query->time . 'ms');
        // });
    }
}
