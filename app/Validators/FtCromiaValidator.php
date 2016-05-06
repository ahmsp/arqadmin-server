<?php

namespace ArqAdmin\Validators;


use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class FtCromiaValidator extends LaravelValidator
{
    protected $rules = [

        ValidatorInterface::RULE_CREATE => [
            'cromia' => 'required|min:3|max:245|unique:ft_cromia,cromia'
        ],

        ValidatorInterface::RULE_UPDATE => [
            'cromia' => 'sometimes|required|min:3|max:245|unique:ft_cromia,cromia'
        ]
    ];

}