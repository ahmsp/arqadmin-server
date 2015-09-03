<?php

namespace ArqAdmin\Validators;


use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class GrupoValidator extends LaravelValidator
{
    protected $rules = [

        ValidatorInterface::RULE_CREATE => [
            'grupo_nome' => 'required|min:3|max:75|unique:grupo,grupo_nome'
        ],

        ValidatorInterface::RULE_UPDATE => [
            'grupo_nome' => 'sometimes|required|min:3|max:75|unique:grupo,grupo_nome'
        ]
    ];

}