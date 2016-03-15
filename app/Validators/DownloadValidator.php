<?php

namespace ArqAdmin\Validators;


use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class DownloadValidator extends LaravelValidator
{
    protected $rules = [

        ValidatorInterface::RULE_CREATE => [
            'token' => 'required|min:12|max:12|unique:token,download_validation',
            'file_name' => 'required|max:245',
            'expiration_time' => 'required|date',
            'username' => 'required',
            'download_date' => 'date'
        ],

        ValidatorInterface::RULE_UPDATE => [
            'token' => 'required|min:12|max:12|unique:token,download_validation',
            'file_name' => 'required|max:245',
            'expiration_time' => 'required|date',
            'username' => 'required',
            'download_date' => 'date'
        ]
    ];
}