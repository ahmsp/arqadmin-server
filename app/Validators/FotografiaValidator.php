<?php

namespace ArqAdmin\Validators;


use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class FotografiaValidator extends LaravelValidator
{
    protected $rules = [

        ValidatorInterface::RULE_CREATE => [
            'identificacao' => 'required|min:3',
            'imagem_identificacao' => 'unique:fotografia,imagem_identificacao',
            'imagem_original' => 'unique:fotografia,imagem_original',
        ],

        ValidatorInterface::RULE_UPDATE => [
            'identificacao' => 'sometimes|required|min:3',
            'imagem_identificacao' => 'sometimes|unique:fotografia,imagem_identificacao',
            'imagem_original' => 'sometimes|unique:fotografia,imagem_original',
        ]
    ];

}