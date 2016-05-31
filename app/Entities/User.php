<?php

namespace ArqAdmin\Entities;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use ArqAdmin\Traits\OverrideRevisionableTrait;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class User extends Model implements AuthenticatableContract, AuthorizableContract, Transformable
{
    use Authenticatable, Authorizable, TransformableTrait, OverrideRevisionableTrait, SoftDeletes;


    protected $revisionEnabled = true;
    protected $revisionCreationsEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit = 500;
    protected $revisionNullString = 'nenhum';
    protected $revisionUnknownString = 'desconhecido';
    protected $revisionFormattedFieldNames = [
        'name' => 'Nome',
        'username' => 'ID',
        'email' => 'E-mail',
    ];

    protected $dontKeepRevisionOf = [
        'password', 'remember'
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'username', 'email', 'password', 'roles'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];
}
