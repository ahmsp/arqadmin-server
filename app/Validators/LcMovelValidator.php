<?php

namespace ArqAdmin\Validators;


use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class LcMovelValidator extends LaravelValidator
{
    protected $rules = [

        ValidatorInterface::RULE_CREATE => [
            'movel' => 'required|min:3|max:45|unique:lc_movel,movel'
        ],

        ValidatorInterface::RULE_UPDATE => [
            'movel' => 'sometimes|required|min:3|max:45|unique:lc_movel,movel'
        ]
    ];

}