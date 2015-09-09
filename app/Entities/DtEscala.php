<?php

namespace ArqAdmin\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class DtEscala extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'dt_escala';

    public $timestamps = false;

    protected $fillable = ['escala'];


    public function desenhosTecnicos()
    {
        return $this->hasMany('ArqAdmin\Entities\DesenhoTecnico');
    }
}
