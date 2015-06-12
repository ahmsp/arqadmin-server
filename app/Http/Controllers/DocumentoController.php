<?php

namespace ArqAdmin\Http\Controllers;

use ArqAdmin\Models\Repositories\DocumentoRepositoryInterface;
use Illuminate\Http\Request;
use ArqAdmin\Http\Requests;
use ArqAdmin\Http\Controllers\Controller;

class DocumentoController extends Controller
{
    protected $documentoRepository;

    public function __construct(DocumentoRepositoryInterface $documentoRepository)
    {
        $this->documentoRepository = $documentoRepository;
        $this->middleware('auth.ldap');
    }

    public function findAll(Request $request)
    {
        $params = $request->all();

        // send to service

        return $params;
    }

    public function find($id)
    {
        //
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
}
