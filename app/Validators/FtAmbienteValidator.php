<?php

namespace ArqAdmin\Validators;


use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class FtAmbienteValidator extends LaravelValidator
{
    protected $rules = [

        ValidatorInterface::RULE_CREATE => [
            'ambiente' => 'required|min:3|max:245|unique:ft_ambiente,ambiente'
        ],

        ValidatorInterface::RULE_UPDATE => [
            'ambiente' => 'sometimes|required|min:3|max:245|unique:ft_ambiente,ambiente'
        ]
    ];

}