<?php

namespace ArqAdmin\Validators;


use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class UserValidator extends LaravelValidator
{
    protected $rules = [

        ValidatorInterface::RULE_CREATE => [
            'name' => 'required|min:3|max:255',
            'username' => 'required|regex:/^c\d{6}$/|unique:users,username',
//            'username' => 'required|min:7|max:7|unique:users,username',
            'email' => 'required|max:255|unique:users,email',
            'password' => 'required|min:6|max:60',
        ],

        ValidatorInterface::RULE_UPDATE => [
            'name' => 'sometimes|required|min:3|max:255',
            'username' => 'sometimes|required|min:7|max:7|unique:users,username',
            'email' => 'sometimes|required|max:255|unique:users,email',
            'password' => 'sometimes|required|min:6|max:60',
        ]
    ];

}