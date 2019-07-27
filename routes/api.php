<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', 'UsersController@login');

Route::prefix('user')->group(function () {
    Route::post('register', 'UsersController@register');
});

Route::prefix('driver')->group(function () {
    Route::post('register', 'DriversController@register');
});


//API authenticated routes
Route::middleware('auth:api')->group(function () {
    Route::prefix('user')->group(function () {
        Route::get('/{id}', 'UsersController@find')->where('id', '[0-9]+');
    });

    Route::prefix('driver')->group(function () {
        Route::get('/{id}', 'DriversController@find')->where('id', '[0-9]+');
    });
});
