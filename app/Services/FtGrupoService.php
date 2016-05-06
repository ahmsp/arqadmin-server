<?php

namespace ArqAdmin\Services;


use ArqAdmin\Repositories\FtGrupoRepository;
use ArqAdmin\Validators\FtGrupoValidator;

class FtGrupoService extends BaseService
{
    /**
     * Specify Repository class name
     *
     * @return string
     */
    public function repository()
    {
        return FtGrupoRepository::class;
    }

    /**
     * Specify Validator class name
     *
     * @return string
     */
    public function validator()
    {
        return FtGrupoValidator::class;
    }

}