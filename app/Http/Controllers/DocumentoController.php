<?php

namespace ArqAdmin\Http\Controllers;

use Illuminate\Http\Request;
use ArqAdmin\Http\Requests;
use ArqAdmin\Http\Controllers\Controller;
use ArqAdmin\Services\DocumentoService;

class DocumentoController extends Controller
{
    protected $documentoService;

    public function __construct(DocumentoService $documentoService)
    {
        $this->documentoService = $documentoService;
//        $this->middleware('auth');
    }

    public function findAll(Request $request)
    {
        $params = $request->all();
        $data = $this->documentoService->findAll($params);

        return $data;
    }

    public function findFilter(Request $request)
    {
        $params = $request->all();
        $data = $this->documentoService->findFilter($params);

        return $data;
    }

    public function add()
    {
        //
    }

    public function update($id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function fetchAuxiliarTable(Request $request, $modelName)
    {
        $params = $request->all();
        $result = $this->documentoService->fetchAuxiliarTable($modelName, $params);
        return $result;
    }

    public function statistic()
    {
        return \ArqAdmin\Models\Documento::statistic();
    }
}
