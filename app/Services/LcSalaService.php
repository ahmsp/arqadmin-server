<?php

namespace ArqAdmin\Services;


use ArqAdmin\Repositories\LcSalaRepository;
use ArqAdmin\Validators\LcSalaValidator;

class LcSalaService extends BaseService
{
    /**
     * Specify Repository class name
     *
     * @return string
     */
    public function repository()
    {
        return LcSalaRepository::class;
    }

    /**
     * Specify Validator class name
     *
     * @return string
     */
    public function validator()
    {
        return LcSalaValidator::class;
    }

}