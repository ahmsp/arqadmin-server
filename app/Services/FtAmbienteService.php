<?php

namespace ArqAdmin\Services;


use ArqAdmin\Repositories\FtAmbienteRepository;
use ArqAdmin\Validators\FtAmbienteValidator;

class FtAmbienteService extends BaseService
{
    /**
     * Specify Repository class name
     *
     * @return string
     */
    public function repository()
    {
        return FtAmbienteRepository::class;
    }

    /**
     * Specify Validator class name
     *
     * @return string
     */
    public function validator()
    {
        return FtAmbienteValidator::class;
    }

}