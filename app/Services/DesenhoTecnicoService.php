<?php

namespace ArqAdmin\Services;


use ArqAdmin\Repositories\DesenhoTecnicoRepository;
use ArqAdmin\Validators\DesenhoTecnicoValidator;

class DesenhoTecnicoService extends BaseService
{
    /**
     * Specify Repository class name
     *
     * @return string
     */
    public function repository()
    {
        return DesenhoTecnicoRepository::class;
    }

    /**
     * Specify Validator class name
     *
     * @return string
     */
    public function validator()
    {
        return DesenhoTecnicoValidator::class;
    }


    public function findAll($params = []) {

        $result = $this->repository->findAllWhere($params);

        return $result;

    }

}