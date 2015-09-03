<?php

namespace ArqAdmin\Validators;


use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class EspeciedocumentalValidator extends LaravelValidator
{
    protected $rules = [

        ValidatorInterface::RULE_CREATE => [
            'especiedocumental_nome' => 'required|min:3|max:145|unique:especiedocumental,especiedocumental_nome'
        ],

        ValidatorInterface::RULE_UPDATE => [
            'especiedocumental_nome' => 'sometimes|required|min:3|max:145|unique:especiedocumental,especiedocumental_nome'
        ]
    ];

}