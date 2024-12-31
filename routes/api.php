<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryTodoController;
use App\Http\Controllers\TodoRelationshipController;
use App\Http\Controllers\ProjectStatusController;


// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Projects statuses CRUD
    Route::apiResource('project-statuses', ProjectStatusController::class);

    // Projects CRUD
    Route::apiResource('projects', ProjectController::class);
    Route::post('/projects/{project}/add-member', [ProjectController::class, 'addMember']);
    Route::post('/projects/{project}/remove-member', [ProjectController::class, 'removeMember']);

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // Route::resource('users', UserController::class);
});
