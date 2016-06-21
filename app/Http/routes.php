<?php

Route::pattern('id', '[0-9]+');

//Route::get('/app', function () {
//    return redirect('app/');
//});

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
        Route::match(['get', 'post'], 'user/owner-profile', 'UserController@getResourceOwnerUser');
        Route::get('user/{id}/revision', 'UserController@getRevisionHistory');
        Route::get('users/revision', 'UserController@getAllRevisionHistory');
        Route::get('guest/{id}/refresh-access-code', 'UserController@refreshGuestAccessCode');
        Route::resource('users', 'UserController', ['except' => ['create', 'edit']]);

        /**
         * Documento
         */
        Route::get('documento/{id}/like', 'DocumentoController@like');
        Route::get('documento/unlike-all', 'DocumentoController@removeUserLikes');
        Route::resource('documento', 'DocumentoController', ['except' => ['create', 'edit']]);

        /**
         * DocumentoImagem
         */
        Route::resource('desenhotecnico', 'DesenhoTecnicoController', ['except' => ['create', 'edit']]);

        /**
         * Registro de Sepultamento
         */
        Route::get('registrosepultamento/{id}/like', 'RegistroSepultamentoController@like');
        Route::get('registrosepultamento/unlike-all', 'RegistroSepultamentoController@removeUserLikes');
        Route::resource('registrosepultamento', 'RegistroSepultamentoController', ['except' => ['create', 'edit']]);

        /**
         * Fotografia
         */
        Route::get('fotografia/{id}/like', 'FotografiaController@like');
        Route::get('fotografia/unlike-all', 'FotografiaController@removeUserLikes');
        Route::resource('fotografia', 'FotografiaController', ['except' => ['create', 'edit']]);

        /**
         * Static data (Auxiliar tables)
         */
        Route::resource('acervo', 'AcervoController', ['except' => ['create', 'edit']]);
        Route::resource('fundo', 'FundoController', ['except' => ['create', 'edit']]);
        Route::resource('subfundo', 'SubfundoController', ['except' => ['create', 'edit']]);
        Route::resource('grupo', 'GrupoController', ['except' => ['create', 'edit']]);
        Route::resource('subgrupo', 'SubgrupoController', ['except' => ['create', 'edit']]);
        Route::resource('serie', 'SerieController', ['except' => ['create', 'edit']]);
        Route::resource('subserie', 'SubserieController', ['except' => ['create', 'edit']]);
        Route::resource('dossie', 'DossieController', ['except' => ['create', 'edit']]);
        Route::resource('especiedocumental', 'EspeciedocumentalController', ['except' => ['create', 'edit']]);

        Route::resource('conservacao', 'ConservacaoController', ['except' => ['create', 'edit']]);

        Route::resource('lcacondicionamento', 'LcAcondicionamentoController', ['except' => ['create', 'edit']]);
        Route::resource('lccompartimento', 'LcCompartimentoController', ['except' => ['create', 'edit']]);
        Route::resource('lcmovel', 'LcMovelController', ['except' => ['create', 'edit']]);
        Route::resource('lcsala', 'LcSalaController', ['except' => ['create', 'edit']]);
        Route::resource('dtuso', 'DtUsoController', ['except' => ['create', 'edit']]);

        Route::resource('dtconservacao', 'DtConservacaoController', ['except' => ['create', 'edit']]);
        Route::resource('dtescala', 'DtEscalaController', ['except' => ['create', 'edit']]);
        Route::resource('dtsuporte', 'DtSuporteController', ['except' => ['create', 'edit']]);
        Route::resource('dttecnica', 'DtTecnicaController', ['except' => ['create', 'edit']]);
        Route::resource('dttipo', 'DtTipoController', ['except' => ['create', 'edit']]);

        Route::resource('sfmcartorio', 'SfmCartorioController', ['except' => ['create', 'edit']]);
        Route::resource('sfmcausamortis', 'SfmCausamortisController', ['except' => ['create', 'edit']]);
        Route::resource('sfmcemiterio', 'SfmCemiterioController', ['except' => ['create', 'edit']]);
        Route::resource('sfmestadocivil', 'SfmEstadocivilController', ['except' => ['create', 'edit']]);
        Route::resource('sfmnacionalidade', 'SfmNacionalidadeController', ['except' => ['create', 'edit']]);
        Route::resource('sfmnaturalidade', 'SfmNaturalidadeController', ['except' => ['create', 'edit']]);

        Route::resource('ftfundo', 'FtFundoController', ['except' => ['create', 'edit']]);
        Route::resource('ftgrupo', 'FtGrupoController', ['except' => ['create', 'edit']]);
        Route::resource('ftserie', 'FtSerieController', ['except' => ['create', 'edit']]);
        Route::resource('fttipologia', 'FtTipologiaController', ['except' => ['create', 'edit']]);
        Route::resource('ftcromia', 'FtCromiaController', ['except' => ['create', 'edit']]);
        Route::resource('ftcategoria', 'FtCategoriaController', ['except' => ['create', 'edit']]);
        Route::resource('ftcampo', 'FtCampoController', ['except' => ['create', 'edit']]);
        Route::resource('ftambiente', 'FtAmbienteController', ['except' => ['create', 'edit']]);

        /**
         * Statistics
         */
        Route::get('/estatisticas', 'DocumentoController@statistic');
        Route::get('/estatisticas/totais', 'Statistics@getTotalItems');


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
        Route::get('documento/{id}/revision', 'DocumentoController@getRevisionHistory');
        Route::get('desenhotecnico/{id}/revision', 'DesenhoTecnicoController@getRevisionHistory');
        Route::get('fotografia/{id}/revision', 'FotografiaController@getRevisionHistory');
        Route::get('registrosepultamento/{id}/revision', 'RegistroSepultamentoController@getRevisionHistory');



    });

});

