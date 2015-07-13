<?php

namespace ArqAdmin\Repositories\Contracts;


interface DocumentoRepositoryInterface
{
    public function find($id);
    public function findAll(array $params);
}