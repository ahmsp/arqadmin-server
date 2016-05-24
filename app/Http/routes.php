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
    Route::get('imagem/fotografico/{id}/{maxSize?}', 'FotografiaController@showPublicImage');
//    Route::get('imagem/sfm/{id}/{template}', 'RegistroSepultamentoController@showPublicImage');

    /**
     * Download an image requested by routes:
     * "api/imagem/documental/{id}/{size}" or
     * "api/imagem/fotografico/{id}/{size}" or
     * "api/imagem/sfm/{id}/{size}"
     */
    Route::get('imagem/download/documental/{id}/{size}/{token}', 'DesenhoTecnicoController@downloadImage')
        ->where('size', 'medium|standard|large|original');
    Route::get('imagem/download/fotografico/{id}/{size}/{token}', 'FotografiaController@downloadImage')
        ->where('size', 'medium|standard|large|original');

    /**
     * Group 'api'
     */
    Route::group(['prefix' => 'api', 'middleware' => ['oauth']], function () {

        /**
         * User
         */
        Route::match(['get', 'post'], 'user/profile', 'UserController@getResourceOwnerUser');

        /**
         * Documento
         */
        Route::resource('documento', 'DocumentoController');

        /**
         * DocumentoImagem
         */
        Route::resource('desenhotecnico', 'DesenhoTecnicoController');
//        Route::get('desenhotecnico/{id}/imagem/{template}', 'DesenhoTecnicoController@showImage');

        /**
         * Registro de Sepultamento
         */
        Route::resource('registrosepultamento', 'RegistroSepultamentoController');

        /**
         * Fotografia
         */
        Route::resource('fotografia', 'FotografiaController');

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

        Route::resource('ftfundo', 'FtFundoController');
        Route::resource('ftgrupo', 'FtGrupoController');
        Route::resource('ftserie', 'FtSerieController');
        Route::resource('fttipologia', 'FtTipologiaController');
        Route::resource('ftcromia', 'FtCromiaController');
        Route::resource('ftcategoria', 'FtCategoriaController');
        Route::resource('ftcampo', 'FtCampoController');
        Route::resource('ftambiente', 'FtAmbienteController');

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
        Route::get('imagem/fotografico/{id}/{size}', 'FotografiaController@getDownloadUrl')
            ->where('size', 'medium|standard|large|original');
//        Route::get('imagem/sfm/{id}/{size}', 'RegistroSepultamentoController@showPublicImage')
//            ->where('size', 'medium|standard|large|original');

        /**
         * Upload image
         */
        Route::post('imagem/upload/documental/{id}', 'DesenhoTecnicoController@uploadImage');
        Route::post('imagem/upload/fotografico/{id}', 'FotografiaController@uploadImage');
//        Route::post('imagem/upload/sfm/{id}', 'RegistroSepultamentoController@uploadImage');


        /**
         * Revision
         */
        Route::get('documento/{id}/revisao', 'DocumentoController@getRevisionHistory');
        Route::get('desenhotecnico/{id}/revisao', 'DesenhoTecnicoController@getRevisionHistory');
        Route::get('fotografia/{id}/revisao', 'FotografiaController@getRevisionHistory');
        Route::get('registrosepultamento/{id}/revisao', 'RegistroSepultamentoController@getRevisionHistory');

    });

});

