<?php

use App\Http\Controllers\Backend\DashboardController;
use Tabuna\Breadcrumbs\Trail;

// All route names are prefixed with 'admin.'.
Route::redirect('/', '/admin/dashboard', 301);
Route::get('dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->breadcrumbs(function (Trail $trail) {
        $trail->push(__('Home'), route('admin.dashboard'));
    });

Route::group([
    'prefix' => 'user',
    'as' => 'user.',
], function () {
    Route::get('/', [\App\Http\Controllers\UserController::class, 'index'])->name('index')
        ->breadcrumbs(function (Trail $trail) {
            $trail->push(__('Home'), route('admin.dashboard'));
        });
    Route::get('create', [\App\Http\Controllers\UserController::class, 'create'])->name('create');
    Route::post('store', [\App\Http\Controllers\UserController::class, 'store'])->name('store');
    Route::get('edit/{id}', [\App\Http\Controllers\UserController::class, 'edit'])->name('edit');
    Route::post('update/{id}', [\App\Http\Controllers\UserController::class, 'update'])->name('update');
    Route::post('delete/{id}', [\App\Http\Controllers\UserController::class, 'delete'])->name('delete');
    Route::get('change-password/{id}', [\App\Http\Controllers\UserController::class, 'change_password'])->name('change_password');
    Route::patch('update-password/{id}', [\App\Http\Controllers\UserController::class, 'update_password'])->name('update_password');
});
