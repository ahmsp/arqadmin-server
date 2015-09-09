<?php

namespace ArqAdmin\Services;


use ArqAdmin\Repositories\SfmCausamortisRepository;
use ArqAdmin\Validators\SfmCausamortisValidator;

class SfmCausamortisService extends BaseService
{
    /**
     * Specify Repository class name
     *
     * @return string
     */
    public function repository()
    {
        return SfmCausamortisRepository::class;
    }

    /**
     * Specify Validator class name
     *
     * @return string
     */
    public function validator()
    {
        return SfmCausamortisValidator::class;
    }

}