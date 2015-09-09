<?php

namespace ArqAdmin\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class DtSuporte extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'dt_suporte';

    public $timestamps = false;

    protected $fillable = ['suporte'];


    public function desenhosTecnicos()
    {
        return $this->hasMany('ArqAdmin\Entities\DesenhoTecnico');
    }
}
