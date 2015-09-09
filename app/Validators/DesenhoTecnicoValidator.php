<?php

namespace ArqAdmin\Validators;


use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class DesenhoTecnicoValidator extends LaravelValidator
{
    protected $rules = [

        ValidatorInterface::RULE_CREATE => [
            'descricao' => 'required|min:3  '
        ],

        ValidatorInterface::RULE_UPDATE => [
            'descricao' => 'required|min:3'
        ]
    ];

}