<?php

namespace ArqAdmin\Services;


use ArqAdmin\Repositories\LcMovelRepository;
use ArqAdmin\Validators\LcMovelValidator;

class LcMovelService extends BaseService
{
    /**
     * Specify Repository class name
     *
     * @return string
     */
    public function repository()
    {
        return LcMovelRepository::class;
    }

    /**
     * Specify Validator class name
     *
     * @return string
     */
    public function validator()
    {
        return LcMovelValidator::class;
    }

}