<?php

use Illuminate\Http\Request;

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

    Route::prefix('truck')->group(function (){
       Route::put('/truck','TrucksControllers@updateTruck');
    Route::prefix('freight')->group(function() {
        Route::get('/user', 'FreightsController@findAllbyUser');
        Route::get('/driver', 'FreightsController@findAllbyDriver');
        Route::post('/new', 'FreightsController@register');
        Route::post('/accept', 'FreightsController@accept')->where('freightid', '[0-9]+');
    });
});
