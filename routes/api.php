<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoalsController;
use App\Http\Controllers\TasksController;
use Illuminate\Support\Facades\Route;

/*
Public Routes (المسارات العامة)
*/
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


/*
 Protected Routes (المسارات المحمية)
*/
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('goals', GoalsController::class);


    Route::prefix('goals/{goal}')->group(function () {
        Route::post('/tasks', [TasksController::class, 'store']);
    });


    Route::apiResource('tasks', TasksController::class)->only([
        'update', 'destroy'
    ]);
});
