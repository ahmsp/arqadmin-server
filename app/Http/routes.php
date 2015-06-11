<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('auth/login', 'AuthController@login');
Route::get('auth/logout', 'AuthController@logout');

Route::group(['prefix' => 'api'], function () {

    /**
     * User
     */
    Route::get('user', 'UserController@create');

    /**
     * Documentos
     */
    Route::match(['get', 'post'], 'documentos', 'DocumentoController@findAll');
    Route::post('documento', 'DocumentoController@add');
    Route::put('documento/{id}', 'DocumentoController@update');
    Route::delete('documento/{id}', 'DocumentoController@destroy');
    Route::get('documentos/auxiliartable/{tableName}', 'DocumentoController@fetchAuxiliarTable');

});
