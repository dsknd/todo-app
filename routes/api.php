<?php

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

    //　タスクカテゴリ
    Route::apiResource('task-categories', TaskCategoryController::class);

    // Projects CRUD
//    Route::apiResource('projects', ProjectController::class);
//    Route::post('/projects/{project}/add-member', [ProjectController::class, 'addMember']);
//    Route::post('/projects/{project}/remove-member', [ProjectController::class, 'removeMember']);
//
//    // Logout
//    Route::post('/logout', [AuthController::class, 'logout']);

    // Route::resource('users', UserController::class);
});
