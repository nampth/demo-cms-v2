<?php

use App\Http\Controllers\Admin\PermissionController;
use Inertia\Inertia;

Route::group(['namespace' => 'Permission', 'prefix' => 'permission', 'as' => 'permission.', 'middleware' => 'permission:' . ADMIN_DASHBOARD], function () {
    Route::get('/', [PermissionController::class, 'index'])->name('index');
    Route::post('/create', [PermissionController::class, 'create'])->name('create');
    Route::post('/update', [PermissionController::class, 'update'])->name('update');
    Route::post('/listing', [PermissionController::class, 'listing'])->name('listing');
    Route::post('/{id}/delete', [PermissionController::class, 'deteleById'])->name('delete');
});
