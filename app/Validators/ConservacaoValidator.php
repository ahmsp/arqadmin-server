<?php

namespace ArqAdmin\Validators;


use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class ConservacaoValidator extends LaravelValidator
{
    protected $rules = [

        ValidatorInterface::RULE_CREATE => [
            'conservacao_estado' => 'required|min:3|max:75|unique:conservacao,conservacao_estado'
        ],

        ValidatorInterface::RULE_UPDATE => [
            'conservacao_estado' => 'sometimes|required|min:3|max:75|unique:conservacao,conservacao_estado'
        ]
    ];

}