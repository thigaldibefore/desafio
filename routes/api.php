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

Route::middleware(['api'])->group(function () {
    Route::get('/buscaceps', 'CepController@index');
    Route::get('/estados', 'CepController@estados');
    Route::get('/cidades/{estado}', 'CepController@cidades');

    Route::get('/users', 'UserController@index');
    Route::post('/users/store', 'UserController@store');
    Route::get('/users/show/{id}', 'UserController@show');
    Route::delete('/users/remove/{id}', 'UserController@destroy');
    Route::put('/users/{id}', 'UserController@update');

    Route::get('/clientes', 'ClientesController@index');
    Route::post('/clientes/store', 'ClientesController@store');
    Route::get('/clientes/show/{id}', 'ClientesController@show');
    Route::put('/clientes/{id}', 'ClientesController@update');
    Route::delete('/clientes/remove/{id}', 'ClientesController@destroy');
});