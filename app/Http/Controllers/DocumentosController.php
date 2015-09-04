<?php

namespace ArqAdmin\Http\Controllers;

use Illuminate\Http\Request;
use ArqAdmin\Http\Requests;
use ArqAdmin\Http\Controllers\Controller;
use ArqAdmin\Services\DocumentosService;

class DocumentosController extends Controller
{
    protected $documentosService;

    public function __construct(DocumentosService $documentosService)
    {
        $this->documentosService = $documentosService;
//        $this->middleware('auth');
    }

    public function findAll(Request $request)
    {
        $params = $request->all();
        $data = $this->documentosService->findAll($params);

        return $data;
    }

    public function findFilter(Request $request)
    {
        $params = $request->all();
        $data = $this->documentosService->findFilter($params);

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
        $result = $this->documentosService->fetchAuxiliarTable($modelName, $params);
        return $result;
    }

    public function statistic()
    {
        return \ArqAdmin\Models\Documento::statistic();
    }
}
