<?php

namespace ArqAdmin\Validators;


use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class SubfundoValidator extends LaravelValidator
{
    protected $rules = [

        ValidatorInterface::RULE_CREATE => [
            'subfundo_nome' => 'required|min:3|max:75|unique:subfundo,subfundo_nome'
        ],

        ValidatorInterface::RULE_UPDATE => [
            'subfundo_nome' => 'sometimes|required|min:3|max:75|unique:subfundo,subfundo_nome'
        ]
    ];

}