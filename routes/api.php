<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('user')->group(function () {
    Route::post('register', 'UsersController@register');
    Route::post('login', 'UsersController@login');
});


//API authenticated routes
Route::middleware('auth:api')->group(function () {
    Route::prefix('user')->group(function () {
        Route::get('/{id}', 'UsersController@find')->where('id', '[0-9]+');
    });
});
