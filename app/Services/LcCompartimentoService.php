<?php

namespace ArqAdmin\Services;


use ArqAdmin\Repositories\LcCompartimentoRepository;
use ArqAdmin\Validators\LcCompartimentoValidator;

class LcCompartimentoService extends BaseService
{
    /**
     * Specify Repository class name
     *
     * @return string
     */
    public function repository()
    {
        return LcCompartimentoRepository::class;
    }

    /**
     * Specify Validator class name
     *
     * @return string
     */
    public function validator()
    {
        return LcCompartimentoValidator::class;
    }

}