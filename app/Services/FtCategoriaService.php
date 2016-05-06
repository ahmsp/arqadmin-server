<?php

namespace ArqAdmin\Services;


use ArqAdmin\Repositories\FtCategoriaRepository;
use ArqAdmin\Validators\FtCategoriaValidator;

class FtCategoriaService extends BaseService
{
    /**
     * Specify Repository class name
     *
     * @return string
     */
    public function repository()
    {
        return FtCategoriaRepository::class;
    }

    /**
     * Specify Validator class name
     *
     * @return string
     */
    public function validator()
    {
        return FtCategoriaValidator::class;
    }

}