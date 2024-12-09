<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::namespace('App\Http\Controllers')->middleware('auth:sanctum')->group(function () {
    Route::get('/get', 'GetController');
    Route::prefix('posts')->namespace('Post')->group(function () {
        Route::post('/', 'StoreController');
        Route::get('/', 'IndexController');
        Route::get('/{post}', 'ShowController');
        Route::patch('/{post}', 'UpdateController');
        
        Route::prefix('images')->namespace('Image')->group(function () {
            Route::post('/{post}', 'StoreController');
            Route::post('/', 'StoreController');

        });
    });

});