<?php

namespace ArqAdmin\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class FtFundo extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'ft_fundo';

    public $timestamps = false;

    protected $fillable = ['fundo'];


    public function fotografias()
    {
        return $this->hasMany('ArqAdmin\Entities\Fotografia');
    }
}
