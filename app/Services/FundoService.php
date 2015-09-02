<?php

namespace ArqAdmin\Services;


use ArqAdmin\Repositories\FundoRepository;
use ArqAdmin\Validators\FundoValidator;

class FundoService extends BaseService
{
    /**
     * Specify Repository class name
     *
     * @return string
     */
    public function repository()
    {
        return FundoRepository::class;
    }

    /**
     * Specify Validator class name
     *
     * @return string
     */
    public function validator()
    {
        return FundoValidator::class;
    }

}