<?php

namespace ArqAdmin\Validators;


use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class AcervoValidator extends LaravelValidator
{
    protected $rules = [

        ValidatorInterface::RULE_CREATE => [
            'acervo_nome' => 'required|min:3|max:45|unique:acervo,acervo_nome',
            'descricao' => 'max:255'
        ],

        ValidatorInterface::RULE_UPDATE => [
            'acervo_nome' => 'sometimes|required|min:3|max:45|unique:acervo,acervo_nome',
            'descricao' => 'max:255'
        ]
    ];

}