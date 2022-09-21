<?php

use App\Http\Controllers\Shop\CatalogController;
use App\Http\Controllers\Shop\OfferController;
use App\Http\Controllers\Shop\ProductController;

Route::group(['as' => 'catalog.', 'prefix' => CATALOG_PATH] ,function (){
    Route::get('', [CatalogController::class, 'index'])
        ->name('index');

    Route::get('offers/{product}', [OfferController::class, 'getOffersBlock'])->name('offers');

    Route::get('/{sublevels?}/detail-product/{product}', [ProductController::class, 'detail'])
        ->where('sublevels', '.*')
        ->name('detail');

    Route::get('/{sublevels?}', [CatalogController::class, 'list'])
        ->where('sublevels', '.*')
        ->name('list');
});
