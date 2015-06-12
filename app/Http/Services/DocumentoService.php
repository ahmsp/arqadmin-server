<?php

namespace ArqAdmin\Http\Services;


use ArqAdmin\Models\Repositories\DocumentoRepositoryInterface;

class DocumentoService
{
    private $repo;

    public function __construct(DocumentoRepositoryInterface $documentoRepository)
    {
        $this->repo = $documentoRepository;
    }

    public function findAll(array $params)
    {
        //
    }
}