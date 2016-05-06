<?php

namespace ArqAdmin\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class FtCampo extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'ft_campo';

    public $timestamps = false;

    protected $fillable = ['campo'];


    public function fotografias()
    {
        return $this->hasMany('ArqAdmin\Entities\Fotografia');
    }

}
