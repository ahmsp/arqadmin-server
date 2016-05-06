<?php

namespace ArqAdmin\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class FtSerie extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'ft_serie';

    public $timestamps = false;

    protected $fillable = ['serie'];


    public function fotografias()
    {
        return $this->hasMany('ArqAdmin\Entities\Fotografia');
    }

}
