<?php

namespace ArqAdmin\Services;


use ArqAdmin\Repositories\DtConservacaoRepository;
use ArqAdmin\Validators\DtConservacaoValidator;

class DtConservacaoService extends BaseService
{
    /**
     * Specify Repository class name
     *
     * @return string
     */
    public function repository()
    {
        return DtConservacaoRepository::class;
    }

    /**
     * Specify Validator class name
     *
     * @return string
     */
    public function validator()
    {
        return DtConservacaoValidator::class;
    }

}