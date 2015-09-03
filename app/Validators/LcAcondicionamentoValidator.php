<?php

namespace ArqAdmin\Validators;


use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class LcAcondicionamentoValidator extends LaravelValidator
{
    protected $rules = [

        ValidatorInterface::RULE_CREATE => [
            'acondicionamento' => 'required|min:3|max:45|unique:lc_acondicionamento,acondicionamento'
        ],

        ValidatorInterface::RULE_UPDATE => [
            'acondicionamento' => 'sometimes|required|min:3|max:45|unique:lc_acondicionamento,acondicionamento'
        ]
    ];

}