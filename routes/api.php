<?php

use App\Http\Controllers\PersonalTagController;
use App\Http\Controllers\ProjectTaskCategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectStatusController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskCategoryController;


// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // プロジェクトステータス
    Route::apiResource('project-statuses', ProjectStatusController::class)->only(['index', 'show']);

    // プロジェクト
    Route::apiResource('projects', ProjectController::class);

    // ユーザー自身のタグ
    Route::prefix('users/me')->group(function () {
        Route::get('tags', [PersonalTagController::class, 'index']);
        Route::post('tags', [PersonalTagController::class, 'store']);
        Route::get('tags/{tag}', [PersonalTagController::class, 'show']);
        Route::patch('tags/{tag}', [PersonalTagController::class, 'update']);
        Route::delete('tags/{tag}', [PersonalTagController::class, 'destroy']);
    });

    // Projects CRUD
//    Route::apiResource('projects', ProjectController::class);
//    Route::post('/projects/{project}/add-member', [ProjectController::class, 'addMember']);
//    Route::post('/projects/{project}/remove-member', [ProjectController::class, 'removeMember']);
//
//    // Logout
//    Route::post('/logout', [AuthController::class, 'logout']);

    // Route::resource('users', UserController::class);
});
