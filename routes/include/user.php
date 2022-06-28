<?php

use App\Http\Controllers\Personal\SettingsController;

Auth::routes();

Route::group(['middleware' => 'auth'], function (){
    Route::get('personal', [SettingsController::class, 'showForm']);
});



