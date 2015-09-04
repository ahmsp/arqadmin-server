<?php

namespace ArqAdmin\Services;


use ArqAdmin\Repositories\DtUsoRepository;
use ArqAdmin\Validators\DtUsoValidator;

class DtUsoService extends BaseService
{
    /**
     * Specify Repository class name
     *
     * @return string
     */
    public function repository()
    {
        return DtUsoRepository::class;
    }

    /**
     * Specify Validator class name
     *
     * @return string
     */
    public function validator()
    {
        return DtUsoValidator::class;
    }

}