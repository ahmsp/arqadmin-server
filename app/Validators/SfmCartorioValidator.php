<?php

namespace ArqAdmin\Validators;


use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class SfmCartorioValidator extends LaravelValidator
{
    protected $rules = [

        ValidatorInterface::RULE_CREATE => [
            'cartorio' => 'required|min:3|max:45|unique:sfm_cartorio,cartorio'
        ],

        ValidatorInterface::RULE_UPDATE => [
            'cartorio' => 'sometimes|required|min:3|max:45|unique:sfm_cartorio,cartorio'
        ]
    ];

}