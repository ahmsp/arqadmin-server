<?php

namespace ArqAdmin\Services;


use ArqAdmin\Repositories\SerieRepository;
use ArqAdmin\Validators\SerieValidator;

class SerieService extends BaseService
{
    /**
     * Specify Repository class name
     *
     * @return string
     */
    public function repository()
    {
        return SerieRepository::class;
    }

    /**
     * Specify Validator class name
     *
     * @return string
     */
    public function validator()
    {
        return SerieValidator::class;
    }

}