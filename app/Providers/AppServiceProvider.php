<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\UseCases\CheckProjectRolePermissionUseCase;
use App\UseCases\Implementations\CheckProjectRolePermission;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CheckProjectRolePermissionUseCase::class, CheckProjectRolePermission::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        DB::listen(function ($query) {
            // クエリ内容、バインディング、実行時間をログに出力
            Log::info('SQL: ' . $query->sql);
            Log::info('Bindings: ', $query->bindings);
            Log::info('Time: ' . $query->time . 'ms');
        });
    }
}
