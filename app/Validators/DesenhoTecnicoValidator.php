<?php

namespace ArqAdmin\Validators;


use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class DesenhoTecnicoValidator extends LaravelValidator
{
    protected $rules = [

        ValidatorInterface::RULE_CREATE => [
            'acervo_tipo' => 'required|in:cartografico,textual',
            'descricao' => 'required|min:3',
            'arquivo_original' => 'required|unique:desenho_tecnico,arquivo_original'
        ],

        ValidatorInterface::RULE_UPDATE => [
            'acervo_tipo' => 'sometimes|required|in:cartografico,textual',
            'descricao' => 'sometimes|required|min:3',
        ]
    ];

}