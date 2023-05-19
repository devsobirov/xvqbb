<?php

use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\DepartmentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;

Route::middleware(['auth', 'role'])->group(function () {

    Route::get('/', App\Http\Controllers\HomeController::class)->name('home');
    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

    Route::middleware('role:' . Role::ADMIN)->group(function () {
        Route::resource('users', UserController::class)->except(['destroy', 'show'])->names('users');
        Route::resource('branches', BranchController::class)->only('index')->names('branches');
        Route::resource('departments', DepartmentController::class)->only('index')->names('departments');
    });

    Route::middleware('role:' . Role::HEAD_MANAGER)->prefix('head')->as('head.')->group(function () {
        Route::get('/', App\Http\Controllers\Head\DashboardController::class)->name('home');
    });

    Route::middleware('role:' . Role::REGIONAL_MANAGER)->prefix('branch')->as('branch.')->group(function () {
        Route::get('/', App\Http\Controllers\Branch\DashboardController::class)->name('home');
    });
});

Auth::routes([
    'register' => false,
    'reset' => false
]);
