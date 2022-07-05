<?php

use App\Http\Controllers\Shop\CatalogController;

Route::group(['as' => 'catalog.', 'prefix' => CATALOG_PATH, 'controller' => CatalogController::class] ,function (){
    Route::get('', 'index')
        ->name('index');

    Route::get('/{category}/{sublevels?}/detail-product/{product}', 'detail')
        ->where('sublevels', '.*')
        ->name('detail');

    Route::get('/{category}/{sublevels?}', 'list')
        ->where('sublevels', '.*')
        ->name('list');
});
