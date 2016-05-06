<?php

namespace ArqAdmin\Validators;


use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class FtCategoriaValidator extends LaravelValidator
{
    protected $rules = [

        ValidatorInterface::RULE_CREATE => [
            'categoria' => 'required|min:3|max:245|unique:ft_categoria,categoria'
        ],

        ValidatorInterface::RULE_UPDATE => [
            'categoria' => 'sometimes|required|min:3|max:245|unique:ft_categoria,categoria'
        ]
    ];

}