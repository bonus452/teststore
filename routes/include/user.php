<?php

use App\Http\Controllers\Personal\SettingsController;

Auth::routes();

Route::group(['middleware' => 'auth', 'as' => 'personal.'], function (){
    Route::get('personal', [SettingsController::class, 'showForm'])->name('index');
});



