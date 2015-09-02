<?php

namespace ArqAdmin\Validators;


use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class FundoValidator extends LaravelValidator
{
    protected $rules = [

        ValidatorInterface::RULE_CREATE => [
            'fundo_nome' => 'required|min:3|max:75|unique:fundo,fundo_nome'
        ],

        ValidatorInterface::RULE_UPDATE => [
            'fundo_nome' => 'sometimes|required|min:3|max:75|unique:fundo,fundo_nome'
        ]
    ];

}