<?php

namespace ArqAdmin\Validators;


use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class DocumentoValidator extends LaravelValidator
{
    protected $rules = [

        ValidatorInterface::RULE_CREATE => [
            'ano' => 'integer|max:4',
            'quantidade_doc' => 'integer|max:4',
            'assunto' => 'required|min:3'
        ],

        ValidatorInterface::RULE_UPDATE => [
            'ano' => 'integer|max:4',
            'quantidade_doc' => 'integer|max:4',
            'assunto' => 'sometimes|required|min:3'
        ]
    ];

}