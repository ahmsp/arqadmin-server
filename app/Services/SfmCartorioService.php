<?php

namespace ArqAdmin\Services;


use ArqAdmin\Repositories\SfmCartorioRepository;
use ArqAdmin\Validators\SfmCartorioValidator;

class SfmCartorioService extends BaseService
{
    /**
     * Specify Repository class name
     *
     * @return string
     */
    public function repository()
    {
        return SfmCartorioRepository::class;
    }

    /**
     * Specify Validator class name
     *
     * @return string
     */
    public function validator()
    {
        return SfmCartorioValidator::class;
    }

}