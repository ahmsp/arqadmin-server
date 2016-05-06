<?php

namespace ArqAdmin\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class FtGrupo extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'ft_grupo';

    public $timestamps = false;

    protected $fillable = ['grupo'];


    public function fotografias()
    {
        return $this->hasMany('ArqAdmin\Entities\Fotografia');
    }

}
