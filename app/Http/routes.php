<?php

Route::pattern('id', '[0-9]+');

Route::get('/', function () {
    return redirect('app/');
});

Route::post('auth/login', 'AuthController@login');
Route::get('auth/logout', 'AuthController@logout');

Route::get('auth/ldap', 'AuthController@ldapTest');

Route::group(['prefix' => 'api'], function () {

    Route::get('test', 'DocumentosController@findFilter');

    /**
     * User
     */
//    Route::get('user', 'UserController@create');

    /**
     * Documentos
     */
    Route::resource('documento', 'DocumentoController');
//    // ver code.edu -> laravel c/ angular -> Relacionando Models -> Criando API ProjectNote
//    Route::get('documentos/{id}/imagens', 'DocumentosController@findAll');
//    Route::get('documentos', 'DocumentosController@findAll');
//    Route::post('documentos', 'DocumentosController@add');
//    Route::put('documentos/{id}', 'DocumentosController@update');
//    Route::delete('documentos/{id}', 'DocumentosController@destroy');

    /**
     * Desenho Tecnico
     */
    Route::resource('desenhotecnico', '');

    /**
     * Auxiliar Tables
     */
//    Route::get('/documentos/auxtable/{modelName}', 'DocumentosController@fetchAuxiliarTable');
//    Route::get('/classificacao/{modelName}', 'DocumentosController@fetchAuxiliarTable');

    Route::resource('acervo', 'AcervoController');
    Route::resource('fundo', 'FundoController');
    Route::resource('subfundo', 'SubfundoController');
    Route::resource('grupo', 'GrupoController');
    Route::resource('subgrupo', 'SubgrupoController');
    Route::resource('serie', 'SerieController');
    Route::resource('subserie', 'SubserieController');
    Route::resource('dossie', 'DossieController');
    Route::resource('especiedocumental', 'EspeciedocumentalController');
    Route::resource('conservacao', 'ConservacaoController');
    Route::resource('lcacondicionamento', 'LcCompartimentoController');
    Route::resource('lccompartimento', 'LcCompartimentoController');
    Route::resource('lcmovel', 'LcMovelController');
    Route::resource('lcsala', 'LcSalaController');
    Route::resource('dtuso', 'DtUsoController');

    /**
     * Statistics
     */
    Route::get('/estatisticas', 'DocumentosController@statistic');

});

