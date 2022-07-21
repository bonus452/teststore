<?php

use App\Http\Controllers\Admin\Catalog\CategoryController;
use App\Http\Controllers\Admin\Catalog\ProductController;
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

                Route::group([
                    'as' => 'category.'
                ], function () {
                    Route::get('category-create', array(CategoryController::class, 'createForm'))
                        ->name('create_form');
                    Route::post('category-create', array(CategoryController::class, 'create'))
                        ->name('create');

                    Route::get('category-edit/{category}', array(CategoryController::class, 'editForm'))
                        ->name('edit_form');
                    Route::patch('category-edit/{category}', array(CategoryController::class, 'update'))
                        ->name('update');
                });

                Route::group([
                    'as' => 'product.'
                ], function () {
                    Route::get('product-create', array(ProductController::class, 'showFormCreate'))
                        ->name('create_form');
                    Route::patch('product-create', array(ProductController::class, 'create'))
                        ->name('create');

                    Route::get('product-update/{product}', array(ProductController::class, 'showFormUpdate'))
                        ->name('edit_form');
                    Route::patch('product-update/{product}', array(ProductController::class, 'update'))
                        ->name('update');
                });


                Route::get('{sublevels?}', array(CategoryController::class, 'list'))
                    ->where('sublevels', '.*')
                    ->name('list');


            });


    });

