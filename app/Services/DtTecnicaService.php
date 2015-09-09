<?php

namespace ArqAdmin\Services;


use ArqAdmin\Repositories\DtTecnicaRepository;
use ArqAdmin\Validators\DtTecnicaValidator;

class DtTecnicaService extends BaseService
{
    /**
     * Specify Repository class name
     *
     * @return string
     */
    public function repository()
    {
        return DtTecnicaRepository::class;
    }

    /**
     * Specify Validator class name
     *
     * @return string
     */
    public function validator()
    {
        return DtTecnicaValidator::class;
    }

}