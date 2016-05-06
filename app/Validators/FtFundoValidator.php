<?php

namespace ArqAdmin\Validators;


use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class FtFundoValidator extends LaravelValidator
{
    protected $rules = [

        ValidatorInterface::RULE_CREATE => [
            'fundo' => 'required|min:3|max:245|unique:ft_fundo,fundo'
        ],

        ValidatorInterface::RULE_UPDATE => [
            'fundo' => 'sometimes|required|min:3|max:245|unique:ft_fundo,fundo'
        ]
    ];

}