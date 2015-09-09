<?php

namespace ArqAdmin\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class DtTecnica extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'dt_tecnica';

    public $timestamps = false;

    protected $fillable = ['tecnica'];


    public function desenhosTecnicos()
    {
        return $this->hasMany('ArqAdmin\Entities\DesenhoTecnico');
    }
}
