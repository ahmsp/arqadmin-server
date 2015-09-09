<?php

namespace ArqAdmin\Services;


use ArqAdmin\Repositories\DtTipoRepository;
use ArqAdmin\Validators\DtTipoValidator;

class DtTipoService extends BaseService
{
    /**
     * Specify Repository class name
     *
     * @return string
     */
    public function repository()
    {
        return DtTipoRepository::class;
    }

    /**
     * Specify Validator class name
     *
     * @return string
     */
    public function validator()
    {
        return DtTipoValidator::class;
    }

}