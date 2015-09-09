<?php

namespace ArqAdmin\Validators;


use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class DtTipoValidator extends LaravelValidator
{
    protected $rules = [

        ValidatorInterface::RULE_CREATE => [
            'tipo' => 'required|min:3|max:40|unique:dt_tipo,tipo'
        ],

        ValidatorInterface::RULE_UPDATE => [
            'tipo' => 'sometimes|required|min:3|max:40|unique:dt_tipo,tipo'
        ]
    ];

}