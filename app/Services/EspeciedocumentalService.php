<?php

namespace ArqAdmin\Services;


use ArqAdmin\Repositories\EspeciedocumentalRepository;
use ArqAdmin\Validators\EspeciedocumentalValidator;

class EspeciedocumentalService extends BaseService
{
    /**
     * Specify Repository class name
     *
     * @return string
     */
    public function repository()
    {
        return EspeciedocumentalRepository::class;
    }

    /**
     * Specify Validator class name
     *
     * @return string
     */
    public function validator()
    {
        return EspeciedocumentalValidator::class;
    }

}