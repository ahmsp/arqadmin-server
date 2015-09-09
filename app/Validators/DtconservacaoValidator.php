<?php

namespace ArqAdmin\Validators;


use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class DtConservacaoValidator extends LaravelValidator
{
    protected $rules = [

        ValidatorInterface::RULE_CREATE => [
            'conservacao' => 'required|min:3|max:15|unique:dt_conservacao,conservacao'
        ],

        ValidatorInterface::RULE_UPDATE => [
            'conservacao' => 'sometimes|required|min:3|max:15|unique:dt_conservacao,conservacao'
        ]
    ];

}