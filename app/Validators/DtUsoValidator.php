<?php

namespace ArqAdmin\Validators;


use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class DtUsoValidator extends LaravelValidator
{
    protected $rules = [

        ValidatorInterface::RULE_CREATE => [
            'uso' => 'required|min:3|max:75|unique:dt_uso,uso'
        ],

        ValidatorInterface::RULE_UPDATE => [
            'uso' => 'sometimes|required|min:3|max:75|unique:dt_uso,uso'
        ]
    ];

}