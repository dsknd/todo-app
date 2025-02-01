<?php

use App\Http\Controllers\ProjectTaskCategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectRoleController;

// パブリックルート
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// 保護されたルート
Route::middleware('auth:sanctum')->group(function () {

    // プロジェクト
    Route::apiResource('/projects', ProjectController::class)->only(['index', 'show', 'store', 'update', 'destroy']);

    // プロジェクトメンバ
    Route::apiResource('/projects/{project}/members', ProjectTaskCategoryController::class)->only(['index', 'create', 'show', 'store', 'update', 'destroy']);

    // プロジェクトロール
    Route::apiResource('/projects/{project}/roles', ProjectRoleController::class)->only(['index', 'create', 'show', 'store', 'update', 'destroy']);

    // プロジェクトロール権限割当
    Route::apiResource('/projects/{project}/roles/{role}/permissions', ProjectRoleController::class)->only(['index', 'store', 'destroy']);

    // プロジェクト招待
    Route::apiResource('/projects/{project}/invitations', ProjectController::class)->only(['index', 'store', 'destroy']);

    // プロジェクトタスク
    Route::apiResource('/projects/{project}/tasks', ProjectController::class)->only(['index', 'show', 'store', 'update', 'destroy']);

    // プロジェクトタスクタグ
    Route::apiResource('/projects/{project}/tags', ProjectController::class)->only(['index', 'store', 'destroy']);

    // プロジェクトタスク依存関係
    Route::apiResource('/projects/{project}/tasks/{task}/dependencies', ProjectController::class)->only(['index', 'store', 'update', 'destroy']);

    // プロジェクトタスク割当
    Route::apiResource('/projects/{project}/tasks/{task}/assignments', ProjectController::class)->only(['index', 'store', 'update', 'destroy']);

    // プロジェクトマイルストーン
    Route::apiResource('/projects/{project}/milestones', ProjectController::class)->only(['index', 'show', 'store', 'update', 'destroy']);

    // タスク
    Route::apiResource('projects/{project}/tasks', ProjectController::class)->only(['index', 'show', 'store', 'update', 'destroy']);

    // タスク依存関係
    Route::apiResource('/tasks/{task}/dependencies', ProjectController::class)->only(['index', 'store', 'update', 'destroy']);

    // タスクコメント
    Route::apiResource('/tasks/{task}/comments', ProjectController::class)->only(['index', 'store', 'update', 'destroy']);
    
    // タスクカテゴリ
    Route::apiResource('/projects/{project}/task-categories', ProjectController::class)->only(['index', 'show', 'store', 'update', 'destroy']);

    // 

    // タスクタグ
    Route::apiResource('/tasks/{task}/tags', ProjectController::class)->only(['index', 'store', 'destroy']);

    // 認証済みユーザ
    Route::prefix('users/me')->group(function () {
        Route::get('/', [AuthController::class, 'me']);
        Route::put('/', [AuthController::class, 'update']);
        Route::delete('/', [AuthController::class, 'destroy']);
    });

});
