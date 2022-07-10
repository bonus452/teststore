<?php

use App\Http\Controllers\Admin\Catalog\CategoryController;
use App\Http\Controllers\Admin\IndexController;

Route::group([
    'middleware' => 'permission:admin-panel',
    'prefix' => 'admin',
    'as' => 'admin.'],
    function () {


        Route::get('/', [IndexController::class, 'index'])->name('index');


        Route::group([
            'prefix' => 'catalog',
            'as' => 'catalog.'],
            function () {
                Route::get('', array(CategoryController::class, 'index'))->name('index');


                Route::get('category-create', array(CategoryController::class, 'createForm'))
                    ->where('sublevels', '.*')
                    ->name('create_form');
                Route::post('category-create', array(CategoryController::class, 'create'))
                    ->where('sublevels', '.*')
                    ->name('create');


                Route::get('category-edit/{category}', array(CategoryController::class, 'editForm'))
                    ->where('sublevels', '.*')
                    ->name('edit_form');

                Route::get('{sublevels?}', array(CategoryController::class, 'list'))
                    ->where('sublevels', '.*')
                    ->name('list');


            });


    });

