<?php

namespace ArqAdmin\Validators;


use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class SfmNaturalidadeValidator extends LaravelValidator
{
    protected $rules = [

        ValidatorInterface::RULE_CREATE => [
            'naturalidade' => 'required|min:3|max:45|unique:sfm_naturalidade,naturalidade'
        ],

        ValidatorInterface::RULE_UPDATE => [
            'naturalidade' => 'sometimes|required|min:3|max:45|unique:sfm_naturalidade,naturalidade'
        ]
    ];

}