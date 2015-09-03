<?php

namespace ArqAdmin\Services;


use ArqAdmin\Repositories\ConservacaoRepository;
use ArqAdmin\Validators\ConservacaoValidator;

class ConservacaoService extends BaseService
{
    /**
     * Specify Repository class name
     *
     * @return string
     */
    public function repository()
    {
        return ConservacaoRepository::class;
    }

    /**
     * Specify Validator class name
     *
     * @return string
     */
    public function validator()
    {
        return ConservacaoValidator::class;
    }

}