<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');

    
    


     
    Route::middleware('auth:api')->group(function () {
        Route::get('user', 'AuthController@details');
        Route::get('logout', 'AuthController@logout');
        Route::put('editProfile', 'AuthController@editProfile');
        //writing routes
        Route::get('writing', 'WritingController@index');
        Route::get('writing/{id}', 'WritingController@show');
        Route::post('writing', 'WritingController@store');
        Route::delete('writing/{id}', 'WritingController@destroy');
        Route::put('writing/{id}', 'WritingController@update');
    });
