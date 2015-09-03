<?php

namespace ArqAdmin\Validators;


use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class SubgrupoValidator extends LaravelValidator
{
    protected $rules = [

        ValidatorInterface::RULE_CREATE => [
            'subgrupo_nome' => 'required|min:3|max:75|unique:subgrupo,subgrupo_nome'
        ],

        ValidatorInterface::RULE_UPDATE => [
            'subgrupo_nome' => 'sometimes|required|min:3|max:75|unique:subgrupo,subgrupo_nome'
        ]
    ];

}