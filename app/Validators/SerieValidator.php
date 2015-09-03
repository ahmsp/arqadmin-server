<?php

namespace ArqAdmin\Validators;


use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class SerieValidator extends LaravelValidator
{
    protected $rules = [

        ValidatorInterface::RULE_CREATE => [
            'serie_nome' => 'required|min:3|max:75|unique:serie,serie_nome'
        ],

        ValidatorInterface::RULE_UPDATE => [
            'serie_nome' => 'sometimes|required|min:3|max:75|unique:serie,serie_nome'
        ]
    ];

}