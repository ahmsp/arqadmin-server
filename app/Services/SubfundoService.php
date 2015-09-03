<?php

namespace ArqAdmin\Services;


use ArqAdmin\Repositories\SubfundoRepository;
use ArqAdmin\Validators\SubfundoValidator;

class SubfundoService extends BaseService
{
    /**
     * Specify Repository class name
     *
     * @return string
     */
    public function repository()
    {
        return SubfundoRepository::class;
    }

    /**
     * Specify Validator class name
     *
     * @return string
     */
    public function validator()
    {
        return SubfundoValidator::class;
    }

}