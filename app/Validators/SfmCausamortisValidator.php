<?php

namespace ArqAdmin\Validators;


use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class SfmCausamortisValidator extends LaravelValidator
{
    protected $rules = [

        ValidatorInterface::RULE_CREATE => [
            'causamortis' => 'required|min:3|max:75|unique:sfm_causamortis,causamortis'
        ],

        ValidatorInterface::RULE_UPDATE => [
            'causamortis' => 'sometimes|required|min:3|max:75|unique:sfm_causamortis,causamortis'
        ]
    ];

}