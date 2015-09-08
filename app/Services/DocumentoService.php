<?php

namespace ArqAdmin\Services;


use ArqAdmin\Repositories\DocumentoRepository;
use ArqAdmin\Validators\DocumentoValidator;

class DocumentoService extends BaseService
{
    /**
     * Specify Repository class name
     *
     * @return string
     */
    public function repository()
    {
        return DocumentoRepository::class;
    }

    /**
     * Specify Validator class name
     *
     * @return string
     */
    public function validator()
    {
        return DocumentoValidator::class;
    }


    public function findAll($params = []) {

        $result = $this->repository->findAllWhere($params);

        return $result;

    }

}