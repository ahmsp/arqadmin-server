<?php

namespace ArqAdmin\Validators;


use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class SubserieValidator extends LaravelValidator
{
    protected $rules = [

        ValidatorInterface::RULE_CREATE => [
            'subserie_nome' => 'required|min:3|max:75|unique:subserie,subserie_nome'
        ],

        ValidatorInterface::RULE_UPDATE => [
            'subserie_nome' => 'sometimes|required|min:3|max:75|unique:subserie,subserie_nome'
        ]
    ];

}