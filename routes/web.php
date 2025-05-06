<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Project\DeleteController as DeleteProjectController;
use App\Http\Controllers\Project\IndexController as IndexProjectController;
use App\Http\Controllers\Project\StoreController as CreateProjectController;
use App\Http\Controllers\Project\UpdateController as UpdateProjectController;
use App\Http\Controllers\Task\CreateController as CreateTaskController;
use App\Http\Controllers\Task\DeleteController as DeleteTaskController;
use App\Http\Controllers\Task\IndexController as TaskIndexController;
use App\Http\Controllers\Task\ReorderController;
use App\Http\Controllers\Task\UpdateController as UpdateTaskController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    Route::get('/dashboard', DashboardController::class)
        ->middleware(['auth', 'verified'])
        ->name('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/projects', IndexProjectController::class)->name('projects.index');
    Route::post('/projects', CreateProjectController::class)->name('projects.store');
    Route::put('/projects/{id}', UpdateProjectController::class)->name('projects.update');
    Route::delete('/projects/{id}', DeleteProjectController::class)->name('projects.delete');
});

Route::middleware(['auth'])->prefix('tasks')->name('tasks.')->group(function () {
    Route::get('/', TaskIndexController::class)->name('index');
    Route::post('/', CreateTaskController::class)->name('store');
    Route::put('/{task}', UpdateTaskController::class)->name('update');
    Route::delete('/{task}', DeleteTaskController::class)->name('delete');
    Route::post('/reorder', ReorderController::class)->name('reorder');
});
