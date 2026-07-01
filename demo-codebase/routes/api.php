<?php

use App\Http\Controllers\Api\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/tasks', [TaskController::class, 'index']);
Route::get('/tasks/{id}', [TaskController::class, 'show'])->whereNumber('id');
Route::post('/tasks', [TaskController::class, 'store']);
Route::patch('/tasks/{id}', [TaskController::class, 'update'])->whereNumber('id');
