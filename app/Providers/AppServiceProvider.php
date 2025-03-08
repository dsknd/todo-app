<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\UseCases\CheckProjectRolePermissionUseCase;
use App\UseCases\Implementations\CheckProjectRolePermission;
use App\Interactors\CreateProjectInteractor;
use App\UseCases\CreateProjectUseCase;
use App\Interactors\CreateTaskInteractor;
use App\UseCases\CreateTaskUseCase;
use App\Repositories\Interfaces\ProjectRepository;
use App\Repositories\EloquentProjectRepository;

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
