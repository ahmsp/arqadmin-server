<?php

namespace ArqAdmin\Validators;


use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class FtCampoValidator extends LaravelValidator
{
    protected $rules = [

        ValidatorInterface::RULE_CREATE => [
            'campo' => 'required|min:3|max:245|unique:ft_campo,campo'
        ],

        ValidatorInterface::RULE_UPDATE => [
            'campo' => 'sometimes|required|min:3|max:245|unique:ft_campo,campo'
        ]
    ];

}