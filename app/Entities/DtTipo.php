<?php

namespace ArqAdmin\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class DtTipo extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'dt_tipo';

    public $timestamps = false;

    protected $fillable = ['tipo'];


    public function desenhosTecnicos()
    {
        return $this->hasMany('ArqAdmin\Entities\DesenhoTecnico');
    }
}
