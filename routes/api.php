<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TodoListController;
use Illuminate\Support\Facades\Route;

Route::post('user/register', [AuthController::class, 'register'])->name('user.register');
Route::post('user/login', [AuthController::class, 'login'])->name('user.login');
Route::get('products/search', [ProductController::class, 'search']);
Route::middleware('auth:api')->group(function () {
    Route::apiResource('todo-list', TodoListController::class);
    Route::apiResource('todo-list.task', TaskController::class)
        ->except('show')
        ->shallow();
});

// Route::post('task/status/update/{id}', [TaskController::class, 'statusUpdate'])->name('task.status.update');
