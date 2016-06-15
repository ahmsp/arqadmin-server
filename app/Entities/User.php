<?php

namespace ArqAdmin\Entities;

use ArqAdmin\Traits\OverrideRevisionableTrait;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;
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
        'roles' => 'Permissões'
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
    protected $fillable = ['name', 'username', 'email', 'password', 'roles', 'adldap_type'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];


    /**
     * Get the user's roles.
     *
     * @param  string $value
     * @return array
     */
    public function getRolesAttribute($value)
    {
        return array_filter(explode(',', $value));
    }

    /**
     * Set the user's roles.
     *
     * @param  mixed $value
     * @return string
     */
    public function setRolesAttribute($value)
    {
        $roles = (is_string($value)) ? json_decode($value) : $value;

        if (null === $roles) {
            $roles = $value;
        }

        $this->attributes['roles'] = (is_array($roles)) ? implode(',', $roles) : $roles;
    }

    /**
     * Set the user's password.
     *
     * @param  string $value
     * @return string
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}
