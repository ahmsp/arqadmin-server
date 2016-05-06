<?php

namespace ArqAdmin\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class FtAmbiente extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'ft_ambiente';

    public $timestamps = false;

    protected $fillable = ['ambiente'];


    public function fotografias()
    {
        return $this->hasMany('ArqAdmin\Entities\Fotografia');
    }
}
