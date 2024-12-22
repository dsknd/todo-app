<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\ProjectTypeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryTodoController;
use App\Http\Controllers\TodoRelationshipController;


// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Project Types CRUD
    Route::apiResource('project-types', ProjectTypeController::class);

    // Projects CRUD
    Route::apiResource('projects', ProjectController::class);

    // Categories CRUD
    Route::apiResource('categories', CategoryController::class);

    // todos CRUD
    Route::apiResource('todos', TodoController::class);

    // Attach and detach todos to todos
    Route::post('/todos/{todoId}/attach-parent', [TodoRelationshipController::class, 'attach']);
    Route::delete('/todos/{todoId}/detach-parent', [TodoRelationshipController::class, 'detach']);

    // Attach and detach categories to todos
    Route::post('/category-todo/{todoId}/attach', [CategoryTodoController::class, 'attach']);
    Route::post('/category-todo/{todoId}/detach', [CategoryTodoController::class, 'detach']);

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // Route::resource('users', UserController::class);
});
