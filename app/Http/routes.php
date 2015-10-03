<?php

Route::pattern('id', '[0-9]+');

Route::get('/app', function () {
    return redirect('app/');
});

//Route::get('{angular?}', function() {
//    return File::get(public_path().'/angular.html');
//})->where('angular', '.*');

//App::missing(function($exception) {
//    return File::get(public_path() . '/app/index.html');
//});

//Route::get('/', function() {
//    return View::make('angular');
//});

Route::post('oauth/access_token', function(){
    return Response::json(Authorizer::issueAccessToken());
});

//Route::post('auth/login', 'AuthController@login');
//Route::get('auth/logout', 'AuthController@logout');

//Route::get('auth/ldap', 'AuthController@ldapTest');

Route::group(['prefix' => 'api', 'middleware' => ['cors', 'oauth']], function () {

    Route::get('test', 'DocumentosController@findFilter');

    /**
     * User
     */
//    Route::get('user', 'UserController@create');

    /**
     * Documentos
     */
    // ver code.edu -> laravel c/ angular -> Relacionando Models -> Criando API ProjectNote
    // Route::get('documentos/{id}/imagens', 'DocumentosController@findAll');
    Route::resource('documento', 'DocumentoController');

    /**
     * Desenho Tecnico
     */
    Route::resource('desenhotecnico', 'DesenhoTecnicoController');

    /**
     * Registro de Sepultamento
     */
    Route::resource('registrosepultamento', 'RegistroSepultamentoController');

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
    Route::resource('especiedocumental', 'EspeciedocumentalController');

    Route::resource('conservacao', 'ConservacaoController');

    Route::resource('lcacondicionamento', 'LcAcondicionamentoController');
    Route::resource('lccompartimento', 'LcCompartimentoController');
    Route::resource('lcmovel', 'LcMovelController');
    Route::resource('lcsala', 'LcSalaController');
    Route::resource('dtuso', 'DtUsoController');

    Route::resource('dtconservacao', 'DtConservacaoController');
    Route::resource('dtescala', 'DtEscalaController');
    Route::resource('dtsuporte', 'DtSuporteController');
    Route::resource('dttecnica', 'DtTecnicaController');
    Route::resource('dttipo', 'DtTipoController');

    Route::resource('sfmcartorio', 'SfmCartorioController');
    Route::resource('sfmcausamortis', 'SfmCausamortisController');
    Route::resource('sfmcemiterio', 'SfmCemiterioController');
    Route::resource('sfmestadocivil', 'SfmEstadocivilController');
    Route::resource('sfmnacionalidade', 'SfmNacionalidadeController');
    Route::resource('sfmnaturalidade', 'SfmNaturalidadeController');

    /**
     * Statistics
     */
    Route::get('/estatisticas', 'DocumentoController@statistic');

});

