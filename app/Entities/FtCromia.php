<?php

namespace ArqAdmin\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class FtCromia extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'ft_cromia';

    public $timestamps = false;

    protected $fillable = ['cromia'];


    public function fotografias()
    {
        return $this->hasMany('ArqAdmin\Entities\Fotografia');
    }

}
