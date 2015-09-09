<?php

namespace ArqAdmin\Services;


use ArqAdmin\Repositories\SfmNacionalidadeRepository;
use ArqAdmin\Validators\SfmNacionalidadeValidator;

class SfmNacionalidadeService extends BaseService
{
    /**
     * Specify Repository class name
     *
     * @return string
     */
    public function repository()
    {
        return SfmNacionalidadeRepository::class;
    }

    /**
     * Specify Validator class name
     *
     * @return string
     */
    public function validator()
    {
        return SfmNacionalidadeValidator::class;
    }

}