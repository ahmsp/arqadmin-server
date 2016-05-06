<?php

namespace ArqAdmin\Validators;


use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class FtSerieValidator extends LaravelValidator
{
    protected $rules = [

        ValidatorInterface::RULE_CREATE => [
            'serie' => 'required|min:3|max:245|unique:ft_serie,serie'
        ],

        ValidatorInterface::RULE_UPDATE => [
            'serie' => 'sometimes|required|min:3|max:245|unique:ft_serie,serie'
        ]
    ];

}