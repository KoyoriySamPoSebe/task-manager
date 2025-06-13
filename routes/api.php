<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::resource('employees', EmployeeController::class);
Route::resource('tasks', TaskController::class);
Route::put('tasks/{task}/assign', [TaskController::class, 'assignEmployee']);
Route::put('tasks/{task}/remove', [TaskController::class, 'removeEmployee']);
