<?php

namespace ArqAdmin\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class SfmCartorio extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'sfm_cartorio';

    public $timestamps = false;

    protected $fillable = ['cartorio'];


    public function registrosSepultamento()
    {
        return $this->hasMany('ArqAdmin\Entities\RegistroSepultamento');
    }
}
