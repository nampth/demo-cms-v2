<?php

use Illuminate\Support\Facades\Route;
use App\Utils\UIUtils;

Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'as' => 'admin.'], function () {
    UIUtils::include_route_files(__DIR__ . '/admin/');
});
