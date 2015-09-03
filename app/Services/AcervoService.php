<?php

namespace ArqAdmin\Services;


use ArqAdmin\Repositories\AcervoRepository;
use ArqAdmin\Validators\AcervoValidator;

class AcervoService extends BaseService
{
    /**
     * Specify Repository class name
     *
     * @return string
     */
    public function repository()
    {
        return AcervoRepository::class;
    }

    /**
     * Specify Validator class name
     *
     * @return string
     */
    public function validator()
    {
        return AcervoValidator::class;
    }

}