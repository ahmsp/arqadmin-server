<?php

namespace ArqAdmin\Http\Controllers;

use Illuminate\Http\Request;

use ArqAdmin\Http\Requests;
use ArqAdmin\Http\Controllers\Controller;

class DocumentoController extends Controller
{
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
