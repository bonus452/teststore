<?php

use App\Http\Controllers\Admin\Catalog\CategoryController;
use App\Http\Controllers\Admin\IndexController;

Route::group([
    'middleware' => 'permission:admin-panel',
    'prefix' => 'admin',
    'as' => 'admin.'],
    function () {


        Route::get('/', [IndexController::class, 'index'])->name('index');
        Route::get('catalog', array(CategoryController::class, 'list'))->name('catalog.list');


    });

