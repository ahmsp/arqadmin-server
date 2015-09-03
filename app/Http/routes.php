<?php

Route::pattern('id', '[0-9]+');

Route::get('/', function () {
    return redirect('app/');
});

Route::post('auth/login', 'AuthController@login');
Route::get('auth/logout', 'AuthController@logout');

Route::get('auth/ldap', 'AuthController@ldapTest');

Route::group(['prefix' => 'api'], function () {

    Route::get('test', 'DocumentoController@findFilter');

    /**
     * User
     */
//    Route::get('user', 'UserController@create');

    /**
     * Documentos
     */
//    // ver code.edu -> laravel c/ angular -> Relacionando Models -> Criando API ProjectNote
//    Route::get('documento/{id}/imagens', 'DocumentoController@findAll');
    Route::get('documento', 'DocumentoController@findAll');
    Route::post('documento', 'DocumentoController@add');
    Route::put('documento/{id}', 'DocumentoController@update');
    Route::delete('documento/{id}', 'DocumentoController@destroy');

    /**
     * RelatedTables
     */
    Route::get('/documento/auxtable/{modelName}', 'DocumentoController@fetchAuxiliarTable');
    Route::get('/classificacao/{modelName}', 'DocumentoController@fetchAuxiliarTable');

    /**
     * Statistics
     */
    Route::get('/documento/estatisticas', 'DocumentoController@statistic');


    /**
     * Auxiliar Tables
     */
    Route::resource('acervo', 'AcervoController');

    Route::resource('fundo', 'FundoController');
    Route::resource('subfundo', 'SubfundoController');
    Route::resource('grupo', 'GrupoController');
    Route::resource('subgrupo', 'SubgrupoController');
    Route::resource('serie', 'SerieController');
    Route::resource('subserie', 'SubserieController');
    Route::resource('dossie', 'DossieController');

    Route::resource('conservacao', 'ConservacaoController');

    Route::resource('lcacondicionamento', 'LcCompartimentoController');
    Route::resource('lcacompartimento', 'LcCompartimentoController');

    Route::resource('especiedocumental', 'EspeciedocumentalController');

});

