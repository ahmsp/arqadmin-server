<?php

namespace ArqAdmin\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class FtTipologia extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'ft_tipologia';

    public $timestamps = false;

    protected $fillable = ['tipologia'];


    public function fotografias()
    {
        return $this->hasMany('ArqAdmin\Entities\Fotografia');
    }

}
