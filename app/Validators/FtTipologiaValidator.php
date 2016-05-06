<?php

namespace ArqAdmin\Validators;


use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class FtTipologiaValidator extends LaravelValidator
{
    protected $rules = [

        ValidatorInterface::RULE_CREATE => [
            'tipologia' => 'required|min:3|max:245|unique:ft_tipologia,tipologia'
        ],

        ValidatorInterface::RULE_UPDATE => [
            'tipologia' => 'sometimes|required|min:3|max:245|unique:ft_tipologia,tipologia'
        ]
    ];

}