<?php

namespace ArqAdmin\Models\Repositories;


use ArqAdmin\Models\Documento;

class DocumentoRepository implements DocumentoRepositoryInterface
{
    public function findAll()
    {
        $documentos = Documento::all();
    }
}