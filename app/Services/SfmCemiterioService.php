<?php

namespace ArqAdmin\Services;


use ArqAdmin\Repositories\SfmCemiterioRepository;
use ArqAdmin\Validators\SfmCemiterioValidator;

class SfmCemiterioService extends BaseService
{
    /**
     * Specify Repository class name
     *
     * @return string
     */
    public function repository()
    {
        return SfmCemiterioRepository::class;
    }

    /**
     * Specify Validator class name
     *
     * @return string
     */
    public function validator()
    {
        return SfmCemiterioValidator::class;
    }

}