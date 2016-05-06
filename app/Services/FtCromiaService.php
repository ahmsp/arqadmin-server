<?php

namespace ArqAdmin\Services;


use ArqAdmin\Repositories\FtCromiaRepository;
use ArqAdmin\Validators\FtCromiaValidator;

class FtCromiaService extends BaseService
{
    /**
     * Specify Repository class name
     *
     * @return string
     */
    public function repository()
    {
        return FtCromiaRepository::class;
    }

    /**
     * Specify Validator class name
     *
     * @return string
     */
    public function validator()
    {
        return FtCromiaValidator::class;
    }

}