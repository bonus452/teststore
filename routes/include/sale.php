<?php

use App\Http\Controllers\Sale\CartController;
use App\Http\Controllers\Sale\OrderController;

Route::group(['as' => 'sale.', 'prefix' => 'sale/'], function () {

    Route::group(['as' => 'cart.', 'prefix' => 'cart/'], function () {

        Route::get('', [CartController::class, 'list'])
            ->name('list');
        Route::post('put', [CartController::class, 'put'])
            ->name('put');
        Route::patch('update', [CartController::class, 'update'])
            ->name('update');
        Route::delete('delete', [CartController::class, 'delete'])
            ->name('delete');

    });

    Route::group(['as' => 'order.', 'prefix' => 'order/'], function () {

        Route::get('', [OrderController::class, 'show'])->name('show');

    });

});
