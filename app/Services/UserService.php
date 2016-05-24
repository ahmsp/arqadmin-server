<?php

namespace ArqAdmin\Services;


use ArqAdmin\Repositories\UserRepository;
use ArqAdmin\Validators\UserValidator;

class UserService extends BaseService
{
    /**
     * Specify Repository class name
     *
     * @return string
     */
    public function repository()
    {
        return UserRepository::class;
    }

    /**
     * Specify Validator class name
     *
     * @return string
     */
    public function validator()
    {
        return UserValidator::class;
    }

}