<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\ProjectTypeController;
use App\Http\Controllers\ProjectController;

// Route::resource('users', UserController::class);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('project-types', ProjectTypeController::class);
    Route::apiResource('projects', ProjectController::class);
    Route::apiResource('todos', TodoController::class);
    Route::post('/logout', [AuthController::class, 'logout']);
});
