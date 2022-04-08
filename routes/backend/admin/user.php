<?php

use App\Http\Controllers\Admin\UserController;

Route::group(['namespace' => 'User', 'prefix' => 'user', 'as' => 'user.', 'middleware'=>'permission:' . ADMIN_USER_MANAGEMENT], function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::post('/listing', [UserController::class, 'listing'])->name('listing');
    Route::post('/listing-all', [UserController::class, 'listingAll'])->name('listing-all');
    Route::post('/add', [UserController::class, 'add'])->name('add');
    Route::post('/{userId}/delete', [UserController::class, 'delete'])->name('delete');
    // Route::post('/login-as/{userId}', [UserController::class, 'loginAsUser'])->name('login-as');
    Route::post('/update', [UserController::class, 'update'])->name('update');
    // Route::post('/user-permission', [UserController::class, 'userPermission'])->name('user-permission');
});
