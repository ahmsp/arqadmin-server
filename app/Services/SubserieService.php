<?php

namespace ArqAdmin\Services;


use ArqAdmin\Repositories\SubserieRepository;
use ArqAdmin\Validators\SubserieValidator;

class SubserieService extends BaseService
{
    /**
     * Specify Repository class name
     *
     * @return string
     */
    public function repository()
    {
        return SubserieRepository::class;
    }

    /**
     * Specify Validator class name
     *
     * @return string
     */
    public function validator()
    {
        return SubserieValidator::class;
    }

}