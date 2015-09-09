<?php

namespace ArqAdmin\Validators;


use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class DtTecnicaValidator extends LaravelValidator
{
    protected $rules = [

        ValidatorInterface::RULE_CREATE => [
            'tecnica' => 'required|min:3|max:45|unique:dt_tecnica,tecnica'
        ],

        ValidatorInterface::RULE_UPDATE => [
            'tecnica' => 'sometimes|required|min:3|max:45|unique:dt_tecnica,tecnica'
        ]
    ];

}