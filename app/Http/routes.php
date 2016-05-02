<?php

Route::pattern('id', '[0-9]+');

Route::get('/app', function () {
//    return redirect('app/');
});

//Route::get('{angular?}', function() {
//    return File::get(public_path().'/angular.html');
//    return View::make('angular');
//})->where('angular', '.*');

Route::group(['middleware' => 'cors'], function () {

    Route::post('authenticate', 'OAuthController@accessToken');

    /**
     * Get public images (restrict size). Template: p|m|g
     */
    Route::get('imagem/documental/{id}/{maxSize?}', 'DesenhoTecnicoController@showPublicImage');
//    Route::get('imagem/documento/{id}/{maxSize?}', 'DocumentoImagemController@showPublicImage');
//    Route::get('imagem/sfm/{id}/{template}', 'RegistroSepultamentoController@showPublicImage');
//    Route::get('imagem/fotografico/{id}/{template}', 'FotograficoController@showPublicImage');

    /**
     * Group 'api'
     */
    Route::group(['prefix' => 'api', 'middleware' => ['oauth']], function () {

        /**
         * User
         */
        Route::get('user', 'UserController@getResourceOwnerUser');

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
//        Route::get('desenhotecnico/{id}/imagem/{template}', 'DesenhoTecnicoController@showImage');

        /**
         * Registro de Sepultamento
         */
        Route::resource('registrosepultamento', 'RegistroSepultamentoController');

        /**
         * Static data (Auxiliar tables)
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


        /**
         * Get download image url (unlimited size). Size template: medium|standard|large|original
         * Return new url to download
         */
        Route::get('imagem/documental/{id}/{size}', 'DesenhoTecnicoController@getDownloadUrl')
            ->where('size', 'medium|standard|large|original');
//    Route::get('imagem/textual/{id}/{maxSize?}', 'DocumentoImagemController@showPublicImage');
//    Route::get('imagem/sfm/{id}/{template}', 'RegistroSepultamentoController@showPublicImage');
//    Route::get('imagem/fotografico/{id}/{template}', 'FotograficoController@showPublicImage');

        /**
         * Upload image
         */
        Route::post('upload/imagem/documental/{id}', 'DesenhoTecnicoController@uploadImage');
//        Route::post('upload/imagem/sepultamento/{id}', 'SepultamentoController@uploadImage');
    });

    /**
     * Download an image requested by route "api/imagem/documental/{id}/{size}"
     */
    Route::get('download/imagem/documental/{id}/{size}/{token}', 'DesenhoTecnicoController@downloadImage')
        ->where('size', 'medium|standard|large|original');


});

