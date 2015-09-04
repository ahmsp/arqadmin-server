<?php

namespace ArqAdmin\Repositories\Contracts;


interface DocumentosRepositoryInterface
{
    public function find($id);
    public function findAll(array $params);
}