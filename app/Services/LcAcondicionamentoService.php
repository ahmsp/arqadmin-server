<?php

namespace ArqAdmin\Services;


use ArqAdmin\Repositories\LcAcondicionamentoRepository;
use ArqAdmin\Validators\LcAcondicionamentoValidator;

class LcAcondicionamentoService extends BaseService
{
    /**
     * Specify Repository class name
     *
     * @return string
     */
    public function repository()
    {
        return LcAcondicionamentoRepository::class;
    }

    /**
     * Specify Validator class name
     *
     * @return string
     */
    public function validator()
    {
        return LcAcondicionamentoValidator::class;
    }

}