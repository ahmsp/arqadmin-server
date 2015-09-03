<?php

namespace ArqAdmin\Services;


use ArqAdmin\Repositories\GrupoRepository;
use ArqAdmin\Validators\GrupoValidator;

class GrupoService extends BaseService
{
    /**
     * Specify Repository class name
     *
     * @return string
     */
    public function repository()
    {
        return GrupoRepository::class;
    }

    /**
     * Specify Validator class name
     *
     * @return string
     */
    public function validator()
    {
        return GrupoValidator::class;
    }

}