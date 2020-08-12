<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::get('/login', 'web\HomeController@index')->name('login_view');
Route::post('/login', 'web\UsuariosController@login')->name('login');
Route::get('/logout', 'web\UsuariosController@logout')->name('logout');

Route::get('/', 'web\HomeController@index');
Route::get('/phpinfo', 'web\HomeController@phpinfo');
//'scheme' => 'https'
//RewriteRule ^(.*)$ https://sistema.ativix.com.br/$1 [R,L]


Route::group(['middleware' => ['web', 'auth']], function () {
    Route::get('download/{documento}', 'web\DownloadsController@download')->name('web.download');
    Route::get('download/template/{documento}', 'web\DownloadsController@downloadTempalate')->name('web.downloadTempalate');

    Route::group(['prefix' => 'home'], function () {
        Route::get('/', 'web\DashboardController@index')->name('dashboard');
    });

    Route::group(['prefix' => 'usuarios'], function () {
        Route::get('/', 'web\UsuariosController@index');
        Route::get('/create', 'web\UsuariosController@create');
        Route::get('/show/{id}', 'web\UsuariosController@show');
        Route::post('/uploadLogo', 'web\UsuariosController@uploadLogo');
        Route::post('/removeLogo', 'web\UsuariosController@removeLogo');
        Route::post('/uploadAvatar', 'web\UsuariosController@uploadAvatar');
        Route::post('/removeAvatar', 'web\UsuariosController@removeAvatar');
    });

    Route::group(['prefix' => 'clientes'], function () {
        Route::get('/', 'web\ClientesController@index');
        Route::get('/create', 'web\ClientesController@create');
        Route::get('/show/{id}', 'web\ClientesController@show');
    });

});