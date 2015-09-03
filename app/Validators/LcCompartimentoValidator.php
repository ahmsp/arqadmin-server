<?php

namespace ArqAdmin\Validators;


use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class LcCompartimentoValidator extends LaravelValidator
{
    protected $rules = [

        ValidatorInterface::RULE_CREATE => [
            'compartimento' => 'required|min:3|max:45|unique:lc_compartimento,compartimento'
        ],

        ValidatorInterface::RULE_UPDATE => [
            'compartimento' => 'sometimes|required|min:3|max:45|unique:lc_compartimento,compartimento'
        ]
    ];

}