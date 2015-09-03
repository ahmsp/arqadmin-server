<?php

namespace ArqAdmin\Services;


use ArqAdmin\Repositories\SubgrupoRepository;
use ArqAdmin\Validators\SubgrupoValidator;

class SubgrupoService extends BaseService
{
    /**
     * Specify Repository class name
     *
     * @return string
     */
    public function repository()
    {
        return SubgrupoRepository::class;
    }

    /**
     * Specify Validator class name
     *
     * @return string
     */
    public function validator()
    {
        return SubgrupoValidator::class;
    }

}