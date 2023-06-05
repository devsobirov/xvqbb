<?php

use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\DepartmentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\Head\ProcessController;
use App\Http\Controllers\Head\TaskController;

Route::middleware(['auth', 'role'])->group(function () {

    Route::get('/', App\Http\Controllers\HomeController::class)->name('home');
    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::post('/file/upload', [FileController::class, 'upload'])->name('file.upload');
    Route::delete('/file/delete/{file?}', [FileController::class, 'delete'])->name('file.delete');
    Route::delete('notifications/{id}', [\App\Http\Controllers\NotificationController::class, 'delete'])
        ->name('notifications.delete');

    Route::middleware('role:' . Role::ADMIN)->group(function () {
        Route::resource('users', UserController::class)->except(['destroy', 'show'])->names('users');
        Route::resource('branches', BranchController::class)->only('index')->names('branches');
        Route::resource('departments', DepartmentController::class)->only('index')->names('departments');
    });

    Route::middleware('role:' . Role::HEAD_MANAGER)->prefix('head')->as('head.')->group(function () {
        Route::get('/', App\Http\Controllers\Head\DashboardController::class)->name('home');

        Route::controller(TaskController::class)->prefix('tasks')->as('tasks.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/edit/{task}', 'edit')->name('edit');
            Route::get('/get-files/{task}', 'getFiles')->name('getFiles');
            Route::post('/save/{task?}', 'save')->name('save');
            Route::post('/processes/{task}', 'processes')->name('processes');
            Route::post('/publish/{task}', 'publish')->name('publish');
            Route::delete('/delete-file/{task}/{file?}', 'deleteFile')->name('deleteFile');
        });

        Route::controller(ProcessController::class)->prefix('processes')->name('process.')->group(function () {
            Route::get('/task/{task}', 'task')->name('task');
        });
        //Route::post('/processes/handle/{task}', ProcessController::class)->name('task-processes');
    });

    Route::middleware('role:' . Role::REGIONAL_MANAGER)->prefix('branch')->as('branch.')->group(function () {
        Route::get('/', App\Http\Controllers\Branch\DashboardController::class)->name('home');

        Route::controller(\App\Http\Controllers\Branch\ProcessController::class)->prefix('tasks')->as('tasks.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/task/{process}', 'show')->name('show');
            Route::get('/get-files/{process}', 'getFiles')->name('getFiles');
            Route::delete('/delete-file/{process}/{file?}', 'deleteFile')->name('deleteFile');
        });
    });
});

Auth::routes([
    'register' => false,
    'reset' => false
]);
