<?php

namespace ArqAdmin\Services;


use ArqAdmin\Repositories\DtEscalaRepository;
use ArqAdmin\Validators\DtEscalaValidator;

class DtEscalaService extends BaseService
{
    /**
     * Specify Repository class name
     *
     * @return string
     */
    public function repository()
    {
        return DtEscalaRepository::class;
    }

    /**
     * Specify Validator class name
     *
     * @return string
     */
    public function validator()
    {
        return DtEscalaValidator::class;
    }

}