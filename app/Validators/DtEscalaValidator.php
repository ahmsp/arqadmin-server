<?php

namespace ArqAdmin\Validators;


use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class DtescalaValidator extends LaravelValidator
{
    protected $rules = [

        ValidatorInterface::RULE_CREATE => [
            'escala' => 'required|min:3|max:25|unique:dt_escala,escala'
        ],

        ValidatorInterface::RULE_UPDATE => [
            'escala' => 'sometimes|required|min:3|max:25|unique:dt_escala,escala'
        ]
    ];

}