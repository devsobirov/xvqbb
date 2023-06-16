<?php

use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\TelegramController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\Head\ProcessController;
use App\Http\Controllers\Head\TaskController;
use App\Http\Controllers\Head\StatsController;

Route::controller(TelegramController::class)->prefix('telegram')->as('telegram.')->group(function () {
    Route::get('set-webhook', 'setWebhook')->name('setWebhook')->middleware('role:'. Role::ADMIN);
    Route::get('start', 'start')->name('start')->middleware('role');
    Route::post('get-updates', 'getUpdates')->name('getUpdates');
    Route::post('unsubscribe', 'unsubscribe')->name('unsubscribe');
});

Route::middleware(['auth', 'role'])->group(function () {

    Route::get('/', App\Http\Controllers\HomeController::class)->name('home');
    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::get('/file/open/{file?}', [FileController::class, 'open'])->name('file.open');
    Route::get('/file/download/{file?}', [FileController::class, 'download'])->name('file.download');
    Route::post('/file/upload', [FileController::class, 'upload'])->name('file.upload');
    Route::delete('/file/delete/{file?}', [FileController::class, 'delete'])->name('file.delete');
    Route::delete('notifications/{id}', [\App\Http\Controllers\NotificationController::class, 'delete'])
        ->name('notifications.delete');

    Route::middleware('role:' . Role::ADMIN)->group(function () {
        Route::resource('users', UserController::class)->except([ 'show'])->names('users');
        Route::resource('branches', BranchController::class)->only('index')->names('branches');
        Route::resource('departments', DepartmentController::class)->except('show', 'destroy')
            ->names('departments');
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
            Route::delete('/destroy/{task}', 'destroy')->name('destroy');
        });

        Route::controller(ProcessController::class)->prefix('processes')->name('process.')->group(function () {
            Route::get('/task/{task}', 'task')->name('task');
            Route::get('/process/{process}', 'process')->name('process');
            Route::post('/process/approve/{process}', 'approve')->name('approve');
            Route::post('/process/reject/{process}', 'reject')->name('reject');
        });

        Route::controller(StatsController::class)->prefix('stats')->as('stats.')->group(function () {
            Route::get('/', 'index')->name('index');
        });

        //Route::post('/processes/handle/{task}', ProcessController::class)->name('task-processes');
    });

    Route::middleware('role:' . Role::REGIONAL_MANAGER)->prefix('branch')->as('branch.')->group(function () {
        Route::get('/', App\Http\Controllers\Branch\DashboardController::class)->name('home');

        Route::controller(\App\Http\Controllers\Branch\ProcessController::class)->prefix('tasks')->as('tasks.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/task/{process}', 'show')->name('show');
            Route::post('/task/complete/{process}', 'complete')->name('complete');
            Route::get('/get-files/{process}', 'getFiles')->name('getFiles');
            Route::delete('/delete-file/{process}/{file?}', 'deleteFile')->name('deleteFile');
        });
    });
});

Auth::routes([
    'register' => false,
    'reset' => false
]);
