<?php

namespace ArqAdmin\Validators;


use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class DossieValidator extends LaravelValidator
{
    protected $rules = [

        ValidatorInterface::RULE_CREATE => [
            'dossie_nome' => 'required|min:3|max:75|unique:dossie,dossie_nome'
        ],

        ValidatorInterface::RULE_UPDATE => [
            'dossie_nome' => 'sometimes|required|min:3|max:75|unique:dossie,dossie_nome'
        ]
    ];

}