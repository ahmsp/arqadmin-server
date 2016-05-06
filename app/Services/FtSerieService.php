<?php

namespace ArqAdmin\Services;


use ArqAdmin\Repositories\FtSerieRepository;
use ArqAdmin\Validators\FtSerieValidator;

class FtSerieService extends BaseService
{
    /**
     * Specify Repository class name
     *
     * @return string
     */
    public function repository()
    {
        return FtSerieRepository::class;
    }

    /**
     * Specify Validator class name
     *
     * @return string
     */
    public function validator()
    {
        return FtSerieValidator::class;
    }

}