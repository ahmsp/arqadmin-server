<?php

namespace ArqAdmin\Services;


use ArqAdmin\Repositories\DossieRepository;
use ArqAdmin\Validators\DossieValidator;

class DossieService extends BaseService
{
    /**
     * Specify Repository class name
     *
     * @return string
     */
    public function repository()
    {
        return DossieRepository::class;
    }

    /**
     * Specify Validator class name
     *
     * @return string
     */
    public function validator()
    {
        return DossieValidator::class;
    }

}