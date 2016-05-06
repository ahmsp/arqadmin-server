<?php

namespace ArqAdmin\Services;


use ArqAdmin\Repositories\FtTipologiaRepository;
use ArqAdmin\Validators\FtTipologiaValidator;

class FtTipologiaService extends BaseService
{
    /**
     * Specify Repository class name
     *
     * @return string
     */
    public function repository()
    {
        return FtTipologiaRepository::class;
    }

    /**
     * Specify Validator class name
     *
     * @return string
     */
    public function validator()
    {
        return FtTipologiaValidator::class;
    }

}