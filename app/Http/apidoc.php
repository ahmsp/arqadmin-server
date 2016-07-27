<?php

/**
 * @api {get} /documento/:id Request Documento information
 * @apiVersion 0.1.0
 * @apiName GetDocumento
 * @apiGroup Textual_e_Cartografico
 * @apiPermission user
 *
 * @apiParam {Number} id Documento unique ID.
 *
 * @apiSuccess {Number} id  Id do documento.
 * @apiSuccess {Number} fundo_id  ID do Fundo.
 * @apiSuccess {Number} subfundo_id  ID do Subfundo relacionado.
 * @apiSuccess {Number} grupo_id  ID do Grupo.
 * @apiSuccess {Number} subgrupo_id ID do Subgrupo.
 * @apiSuccess {Number} serie_id  ID da Série.
 * @apiSuccess {Number} subserie_id  ID Sub-série.
 * @apiSuccess {Number} dossie_id  ID do Dossie.
 * @apiSuccess {Number} especiedocumental_id  Especie documental.
 * @apiSuccess {String} notacao_preexistente Notacao Pré-existente.
 * @apiSuccess {String} notacao Notação.
 * @apiSuccess {String} ano Ano.
 * @apiSuccess {String} data_doc Data do documento.
 * @apiSuccess {String} processo_num Número do Processo.
 * @apiSuccess {Number} quantidade_doc Quantidade de Documentos.
 * @apiSuccess {Number} conservacao_id ID do estado de conservacao.
 * @apiSuccess {String} interessado Interessado.
 * @apiSuccess {String} assunto Assunto.
 * @apiSuccess {Text} notas Notas.
 *
 *
 *
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *       "id": 127147,
 *       "fundo_id": 3,
 *       "subfundo_id": 9,
 *       "grupo_id": 68,
 *       "subgrupo_id": 8,
 *       "serie_id": 192,
 *       "subserie_id": null,
 *       "dossie_id": null,
 *       "especiedocumental_id": 1,
 *       "notacao_preexistente": "",
 *       "notacao": "",
 *       "ano": "1935",
 *       "data_doc": "02 de janeiro de 1935",
 *       "processo_num": "41373",
 *       "quantidade_doc": 0,
 *       "conservacao_id": null,
 *       "interessado": "Luiz Falgetano",
 *       "assunto": "Pedido de licença para funcionamento de cinema.",
 *       "notas": "",
 *       ...
 *     }
 *
 * @apiError DocumentoNotFound The id of the Document was not found.
 *
 * @apiErrorExample Error-Response:
 *     HTTP/1.1 404 Not Found
 *     {
 *       "error": "DocNotFound"
 *     }
 */
Route::resource('documento', 'DocumentoController', ['except' => ['create', 'edit']]);



/**
 * @api {get} /documento Filter Documents
 * @apiVersion 0.1.0
 * @apiName GetDocumentos
 * @apiGroup Textual_e_Cartografico
 * @apiPermission user
 *
 * @apiParam {Number} id Documento unique ID.
 *
 * @apiSuccess {Number} id  Id do documento.

 *
 *
 *
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *       "id": 127147,
 *       "fundo_id": 3,
 *       "subfundo_id": 9,
 *       "grupo_id": 68,
 *       "subgrupo_id": 8,
 *       "serie_id": 192,
 *       "subserie_id": null,
 *       "dossie_id": null,
 *       "especiedocumental_id": 1,
 *       "notacao_preexistente": "",
 *       "notacao": "",
 *       "ano": "1935",
 *       "data_doc": "02 de janeiro de 1935",
 *       "processo_num": "41373",
 *       "quantidade_doc": 0,
 *       "conservacao_id": null,
 *       "interessado": "Luiz Falgetano",
 *       "assunto": "Pedido de licença para funcionamento de cinema.",
 *       "notas": "",
 *       ...
 *     }
 *
 * @apiError DocumentoNotFound The id of the Document was not found.
 *
 * @apiErrorExample Error-Response:
 *     HTTP/1.1 404 Not Found
 *     {
 *       "error": "DocNotFound"
 *     }
 */
Route::resource('documento', 'DocumentoController', ['except' => ['create', 'edit']]);


/**
 *
 * @api {get} /fotografia/:id Request Fotografia information
 * @apiVersion 0.1.0
 * @apiName GetFotografia
 * @apiGroup Fotografico
 * @apiPermission user
 *
 * @apiParam {Number} id Fotografia unique ID.
 *
 * @apiParam (parameters) {String} projectId Project's ID
 * @apiParam (parameters) {String} repository[uuid] Repository's Id
 * @apiParam (parameters) {String} repository[owner] Repository's Owner
 * @apiParam (parameters) {String} repository[slug] Repository's Slug
 *
 * @apiError (406) InvalidParameters Invalid parameters
 * @apiError (404) ProjectNotFound Project not found
 * @apiError (406) RepositoryAlreadyUsed Repository already used
 *
 * @apiSuccess (201) {String} status Status
 * @apiSuccess (201) {String} data  Ok
 * @apiSuccess (201) {Number} statusCode  Status Code
 */

/**
 *
 * @api {get} /sepultamento/:id Request Termo de Sepultamento information
 * @apiVersion 0.1.0
 * @apiName GetSepultamento
 * @apiGroup Sepultamento
 * @apiPermission user
 *
 * @apiParam {Number} id Sepultamento unique ID.
 *
 * @apiParam (parameters) {String} projectId Project's ID
 * @apiParam (parameters) {String} repository[uuid] Repository's Id
 * @apiParam (parameters) {String} repository[owner] Repository's Owner
 * @apiParam (parameters) {String} repository[slug] Repository's Slug
 *
 * @apiError (406) InvalidParameters Invalid parameters
 * @apiError (404) ProjectNotFound Project not found
 * @apiError (406) RepositoryAlreadyUsed Repository already used
 *
 * @apiSuccess (201) {String} status Status
 * @apiSuccess (201) {String} data  Ok
 * @apiSuccess (201) {Number} statusCode  Status Code
 */

