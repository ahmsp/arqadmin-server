<?php

namespace ArqAdmin\Validators;


use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class FtGrupoValidator extends LaravelValidator
{
    protected $rules = [

        ValidatorInterface::RULE_CREATE => [
            'grupo' => 'required|min:3|max:245|unique:ft_grupo,grupo'
        ],

        ValidatorInterface::RULE_UPDATE => [
            'grupo' => 'sometimes|required|min:3|max:245|unique:ft_grupo,grupo'
        ]
    ];

}