<?php

namespace ArqAdmin\Validators;


use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class LcSalaValidator extends LaravelValidator
{
    protected $rules = [

        ValidatorInterface::RULE_CREATE => [
            'sala' => 'required|min:3|max:45|unique:lc_sala,sala'
        ],

        ValidatorInterface::RULE_UPDATE => [
            'sala' => 'sometimes|required|min:3|max:45|unique:lc_sala,sala'
        ]
    ];

}