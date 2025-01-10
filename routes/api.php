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

    // プロジェクトアクション
    // ====================================================================================
    Route::post('/projects/{project}/invite', [ProjectController::class, 'invite']);
    Route::patch('projects/{project}', [ProjectController::class, 'update']);
    Route::delete('projects/{project}', [ProjectController::class, 'destroy']);

    Route::apiResource('projects', ProjectController::class)
        ->only(['index', 'show', 'store', 'update', 'destroy']);
    Route::post('projects/{projects}/invite', [ProjectTaskCategoryController::class, 'invite']);


    // ユーザーアクション
    // ====================================================================================
    Route::prefix('users/me')->group(function () {
        // タグ
        Route::get('tags', [PersonalTagController::class, 'index']);
        Route::post('tags', [PersonalTagController::class, 'store']);
        Route::get('tags/{tag}', [PersonalTagController::class, 'show']);
        Route::patch('tags/{tag}', [PersonalTagController::class, 'update']);
        Route::delete('tags/{tag}', [PersonalTagController::class, 'destroy']);

        // プロジェクト
        Route::get('projects', [ProjectController::class, 'index']);
        Route::get('projects/{project}', [ProjectController::class, 'show']);
        Route::post('projects', [ProjectController::class, 'store']);
        Route::patch('projects/{project}', [ProjectController::class, 'update']);
        Route::delete('projects/{project}', [ProjectController::class, 'destroy']);
        Route::post('/projects/{project}/join', [ProjectController::class, 'join']);
        Route::post('/projects/{project}/leave', [ProjectController::class, 'leave']);
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
