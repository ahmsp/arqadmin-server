<?php

namespace ArqAdmin\Validators;


use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class SfmNacionalidadeValidator extends LaravelValidator
{
    protected $rules = [

        ValidatorInterface::RULE_CREATE => [
            'nacionalidade' => 'required|min:3|max:45|unique:sfm_nacionalidade,nacionalidade'
        ],

        ValidatorInterface::RULE_UPDATE => [
            'nacionalidade' => 'sometimes|required|min:3|max:45|unique:sfm_nacionalidade,nacionalidade'
        ]
    ];

}