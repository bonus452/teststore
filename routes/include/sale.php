<?php

use App\Http\Controllers\Shop\CartController;

Route::group(['as' => 'sale.', 'prefix' => 'sale/'], function () {

    Route::group(['as' => 'cart.', 'prefix' => 'cart/'], function () {
        Route::post('put', [CartController::class, 'put'])
            ->name('put');
    });

});
