<?php

namespace ArqAdmin\Validators;


use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class RegistroSepultamentoValidator extends LaravelValidator
{
    protected $rules = [

        ValidatorInterface::RULE_CREATE => [
            'sfm_nome' => 'required|min:3|max:145',
            'lc_acondicionamento_num' => 'required|max:15',
            'lc_pagina' => 'required|max:15'
        ],

        ValidatorInterface::RULE_UPDATE => [
            'sfm_nome' => 'sometimes|required|min:3|max:145',
            'lc_acondicionamento_num' => 'sometimes|required|max:15',
            'lc_pagina' => 'sometimes|required|max:15'
        ]
    ];
}