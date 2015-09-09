<?php

namespace ArqAdmin\Services;


use ArqAdmin\Repositories\SfmEstadocivilRepository;
use ArqAdmin\Validators\SfmEstadocivilValidator;

class SfmEstadocivilService extends BaseService
{
    /**
     * Specify Repository class name
     *
     * @return string
     */
    public function repository()
    {
        return SfmEstadocivilRepository::class;
    }

    /**
     * Specify Validator class name
     *
     * @return string
     */
    public function validator()
    {
        return SfmEstadocivilValidator::class;
    }

}