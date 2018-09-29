<?php

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

Route::group(['prefix' => 'entregas'], function() {
    Route::get('/', 'EntregaController@index');
    Route::post('/', 'EntregaController@store');
    Route::get('/{id}', 'EntregaController@show');
});
