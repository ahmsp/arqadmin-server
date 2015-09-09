<?php

namespace ArqAdmin\Services;


use ArqAdmin\Repositories\SfmNaturalidadeRepository;
use ArqAdmin\Validators\SfmNaturalidadeValidator;

class SfmNaturalidadeService extends BaseService
{
    /**
     * Specify Repository class name
     *
     * @return string
     */
    public function repository()
    {
        return SfmNaturalidadeRepository::class;
    }

    /**
     * Specify Validator class name
     *
     * @return string
     */
    public function validator()
    {
        return SfmNaturalidadeValidator::class;
    }

}