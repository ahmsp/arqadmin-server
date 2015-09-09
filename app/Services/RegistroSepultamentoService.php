<?php

namespace ArqAdmin\Services;


use ArqAdmin\Repositories\RegistroSepultamentoRepository;
use ArqAdmin\Validators\RegistroSepultamentoValidator;

class RegistroSepultamentoService extends BaseService
{
    /**
     * Specify Repository class name
     *
     * @return string
     */
    public function repository()
    {
        return RegistroSepultamentoRepository::class;
    }

    /**
     * Specify Validator class name
     *
     * @return string
     */
    public function validator()
    {
        return RegistroSepultamentoValidator::class;
    }


    public function findAll($params = []) {

        $result = $this->repository->findAllWhere($params);

        return $result;

    }

}