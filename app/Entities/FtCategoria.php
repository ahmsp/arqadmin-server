<?php

namespace ArqAdmin\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class FtCategoria extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'ft_categoria';

    public $timestamps = false;

    protected $fillable = ['categoria'];


    public function fotografias()
    {
        return $this->hasMany('ArqAdmin\Entities\Fotografia');
    }
}
