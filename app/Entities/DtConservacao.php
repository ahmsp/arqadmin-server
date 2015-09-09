<?php

namespace ArqAdmin\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class DtConservacao extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'dt_conservacao';

    public $timestamps = false;

    protected $fillable = ['conservacao'];


    public function desenhosTecnicos()
    {
        return $this->hasMany('ArqAdmin\Entities\DesenhoTecnico');
    }
}
