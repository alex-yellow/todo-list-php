<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Маршруты для аутентификации
Route::get('/', [AuthController::class, 'index'])->name('auth.index');
Route::get('/register', [AuthController::class, 'registerForm'])->name('auth.registerForm');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');

Route::get('/login', [AuthController::class, 'loginForm'])->name('auth.loginForm');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');

//Маршруты для задач

Route::get('/tasks', [TaskController::class, 'index'])->name('task.index');
Route::get('/tasks/create', [TaskController::class, 'create'])->name('task.create');
Route::post('/tasks', [TaskController::class, 'store'])->name('task.store');
Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('task.edit');
Route::patch('/tasks/{task}', [TaskController::class, 'update'])->name('task.update');
Route::delete('/tasks/{task}', [TaskController::class, 'delete'])->name('task.delete');
Route::get('/tasks/{task}/complete', [TaskController::class, 'complete'])->name('task.complete');

