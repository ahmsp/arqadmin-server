<?php

namespace ArqAdmin\Validators;


use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class DtSuporteValidator extends LaravelValidator
{
    protected $rules = [

        ValidatorInterface::RULE_CREATE => [
            'suporte' => 'required|min:3|max:45|unique:dt_suporte,suporte'
        ],

        ValidatorInterface::RULE_UPDATE => [
            'suporte' => 'sometimes|required|min:3|max:45|unique:dt_suporte,suporte'
        ]
    ];

}