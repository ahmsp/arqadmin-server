<?php

namespace ArqAdmin\Services;


use ArqAdmin\Repositories\FtCampoRepository;
use ArqAdmin\Validators\FtCampoValidator;

class FtCampoService extends BaseService
{
    /**
     * Specify Repository class name
     *
     * @return string
     */
    public function repository()
    {
        return FtCampoRepository::class;
    }

    /**
     * Specify Validator class name
     *
     * @return string
     */
    public function validator()
    {
        return FtCampoValidator::class;
    }

}