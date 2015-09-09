<?php

namespace ArqAdmin\Validators;


use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class SfmEstadocivilValidator extends LaravelValidator
{
    protected $rules = [

        ValidatorInterface::RULE_CREATE => [
            'estadocivil' => 'required|min:3|max:45|unique:sfm_estadocivil,estadocivil'
        ],

        ValidatorInterface::RULE_UPDATE => [
            'estadocivil' => 'sometimes|required|min:3|max:45|unique:sfm_estadocivil,estadocivil'
        ]
    ];

}