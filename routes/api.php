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

Route::group(['middleware' => 'auth:api'], function () {
    // Route::get('/activity', 'ActivityController@')
    Route::get('activity', 'ActivityController@index');
    Route::get('activity/{id}', 'ActivityController@show')
        ->where('id', '[0-9]+');
    Route::put('activity/{id}', 'ActivityController@update')
        ->where('id', '[0-9]+');
});