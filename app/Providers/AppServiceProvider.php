<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
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
use App\UseCases\FindProjectUseCase;
use App\Interactors\FindProjectInteractor;
use App\UseCases\FetchOwnedProjectsUseCase;
use App\Interactors\FetchOwnedProjectsInteractor;
use App\UseCases\FetchParticipatingProjectsUseCase;
use App\Interactors\FetchParticipatingProjectsInteractor;
use App\UseCases\UpdateProjectUseCase;
use App\Interactors\UpdateProjectInteractor;
use App\UseCases\DeleteProjectUseCase;
use App\Interactors\DeleteProjectInteractor;
use App\Interactors\AuthorizeProjectPermissionInteractor;
use App\UseCases\AuthorizeProjectPermissionUseCase;
use App\Repositories\EloquentProjectMemberPermissionQueryRepository;
use App\Repositories\Interfaces\ProjectMemberPermissionQueryRepository;
use App\Repositories\Interfaces\ProjectMemberQueryRepository;
use App\Repositories\EloquentProjectMemberQueryRepository;
use App\UseCases\GetProjectMemberUseCase;
use App\Interactors\GetProjectMemberInteractor;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        /**-------------------------------
         * UseCase
         --------------------------------*/
        // project
        $this->app->bind(CreateProjectUseCase::class, CreateProjectInteractor::class);
        $this->app->bind(FindProjectUseCase::class, FindProjectInteractor::class);
        $this->app->bind(FetchOwnedProjectsUseCase::class, FetchOwnedProjectsInteractor::class);
        $this->app->bind(FetchParticipatingProjectsUseCase::class, FetchParticipatingProjectsInteractor::class);
        $this->app->bind(UpdateProjectUseCase::class, UpdateProjectInteractor::class);
        $this->app->bind(DeleteProjectUseCase::class, DeleteProjectInteractor::class);

        // projectMember
        $this->app->bind(GetProjectMemberUseCase::class, GetProjectMemberInteractor::class);

        // projectPermission
        $this->app->bind(AuthorizeProjectPermissionUseCase::class, AuthorizeProjectPermissionInteractor::class);

        // task
        $this->app->bind(CreateTaskUseCase::class, CreateTaskInteractor::class);
        
        /**-------------------------------
         * Repository
         --------------------------------*/
        // Project
        $this->app->bind(ProjectRepository::class, EloquentProjectRepository::class);
        
        // ProjectMember
        $this->app->bind(ProjectMemberRepository::class, EloquentProjectMemberRepository::class);
        $this->app->bind(ProjectMemberQueryRepository::class, EloquentProjectMemberQueryRepository::class);
        $this->app->bind(ProjectMemberPermissionQueryRepository::class, EloquentProjectMemberPermissionQueryRepository::class);

        // ProjectRole
        $this->app->bind(ProjectRoleRepository::class, EloquentProjectRoleRepository::class);

        // DefaultProjectRole
        $this->app->bind(DefaultProjectRoleRepository::class, EloquentDefaultProjectRoleRepository::class);

        // CustomProjectRole
        $this->app->bind(CustomProjectRoleRepository::class, EloquentCustomProjectRoleRepository::class);

        // ProjectRolePermission
        $this->app->bind(ProjectRolePermissionRepository::class, EloquentProjectRolePermissionRepository::class);

        // Permission
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
