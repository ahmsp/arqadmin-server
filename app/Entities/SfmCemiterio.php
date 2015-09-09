<?php

namespace ArqAdmin\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class SfmCemiterio extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'sfm_cemiterio';

    public $timestamps = false;

    protected $fillable = ['cemiterio'];


    public function registrosSepultamento()
    {
        return $this->hasMany('ArqAdmin\Entities\RegistroSepultamento');
    }
}
