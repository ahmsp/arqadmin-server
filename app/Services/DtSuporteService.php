<?php

namespace ArqAdmin\Services;


use ArqAdmin\Repositories\DtSuporteRepository;
use ArqAdmin\Validators\DtSuporteValidator;

class DtSuporteService extends BaseService
{
    /**
     * Specify Repository class name
     *
     * @return string
     */
    public function repository()
    {
        return DtSuporteRepository::class;
    }

    /**
     * Specify Validator class name
     *
     * @return string
     */
    public function validator()
    {
        return DtSuporteValidator::class;
    }

}