<?php

use App\Http\Controllers\Admin\Catalog\CategoryController;
use App\Http\Controllers\Admin\Catalog\ProductController;
use App\Http\Controllers\Admin\Catalog\PropertyController;
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
                    'as' => 'category.',
                    'controller' => CategoryController::class
                ], function () {
                    Route::get('category-create','createForm')
                        ->name('create_form');
                    Route::post('category-create','create')
                        ->name('create');

                    Route::get('category-edit/{category}','editForm')
                        ->name('edit_form');
                    Route::patch('category-edit/{category}','update')
                        ->name('update');

                    Route::delete('category-delete/{category}','delete')
                        ->name('delete');
                });

                Route::group([
                    'as' => 'product.',
                    'controller' => ProductController::class
                ], function () {
                    Route::get('product-create', 'showFormCreate')
                        ->name('create_form');
                    Route::post('product-create','create')
                        ->name('create');

                    Route::get('product-edit/{product}','showFormUpdate')
                        ->name('edit_form');
                    Route::patch('product-update/{product}','update')
                        ->name('update');

                    Route::delete('product-delete/{product}','delete')
                        ->name('delete');

                });

                Route::group([
                    'as' => 'property.',
                    'controller' => PropertyController::class
                ], function () {
                    Route::get('get-properties','getPropertyPopup')->name('get_properties');
                    Route::post('set-property','setProperty');
                });


                Route::get('{sublevels?}', array(CategoryController::class, 'list'))
                    ->where('sublevels', '.*')
                    ->name('list');


            });


    });

