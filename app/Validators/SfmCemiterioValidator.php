<?php

namespace ArqAdmin\Validators;


use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class SfmCemiterioValidator extends LaravelValidator
{
    protected $rules = [

        ValidatorInterface::RULE_CREATE => [
            'cemiterio' => 'required|min:3|max:45|unique:sfm_cemiterio,cemiterio'
        ],

        ValidatorInterface::RULE_UPDATE => [
            'cemiterio' => 'sometimes|required|min:3|max:45|unique:sfm_cemiterio,cemiterio'
        ]
    ];

}