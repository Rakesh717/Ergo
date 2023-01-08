<?php

use App\Http\Controllers\BoardController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UpdateTaskAssigneeController;
use App\Http\Controllers\UpdateTaskDueDateController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');

    Route::get('boards/{board}', [BoardController::class, 'show'])->name('boards.show');

    Route::put('tasks/{task}/update-assignee', UpdateTaskAssigneeController::class)->name('tasks.assignee.update');

    Route::put('tasks/{task}/update-due', UpdateTaskDueDateController::class)->name('tasks.due.update');
});
