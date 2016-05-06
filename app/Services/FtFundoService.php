<?php

namespace ArqAdmin\Services;


use ArqAdmin\Repositories\FtFundoRepository;
use ArqAdmin\Validators\FtFundoValidator;

class FtFundoService extends BaseService
{
    /**
     * Specify Repository class name
     *
     * @return string
     */
    public function repository()
    {
        return FtFundoRepository::class;
    }

    /**
     * Specify Validator class name
     *
     * @return string
     */
    public function validator()
    {
        return FtFundoValidator::class;
    }

}