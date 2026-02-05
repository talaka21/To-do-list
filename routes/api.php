<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FlightsController;
use App\Http\Controllers\GoalsController;
use App\Http\Controllers\TasksController;
use Illuminate\Support\Facades\Route;
Route::middleware('auth:sanctum')->group(function () {

    // مسارات الأهداف (كاملة)
    Route::apiResource('goals', GoalsController::class);

    // مسارات المهام التابعة لهدف
    Route::post('goals/{goal}/tasks', [TasksController::class, 'store']); // إضافة مهمة لهدف
    Route::put('tasks/{task}', [TasksController::class, 'update']);       // تعديل مهمة
    Route::delete('tasks/{task}', [TasksController::class, 'destroy']);    // حذف مهمة
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// مسارات محمية (تحتاج توكن)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});
