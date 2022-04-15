<?php

use App\Http\Controllers\Admin\RoleController;

Route::group(['namespace' => 'Role', 'prefix' => 'role', 'as' => 'role.', 'middleware'=>'permission:' . ADMIN_ROLE_MANAGEMENT], function () {
    Route::get('/', [RoleController::class, 'index'])->name('index');
    Route::post('/listing', [RoleController::class, 'listing'])->name('listing');
    Route::post('/listing-all', [RoleController::class, 'listingAll'])->name('listing-all');
    Route::post('/add', [RoleController::class, 'add'])->name('add');
    Route::post('/{id}/delete', [RoleController::class, 'deleteById'])->name('delete');
    Route::post('/update', [RoleController::class, 'update'])->name('update');
});
