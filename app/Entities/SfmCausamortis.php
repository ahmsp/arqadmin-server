<?php

namespace ArqAdmin\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class SfmCausamortis extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'sfm_causamortis';

    public $timestamps = false;

    protected $fillable = ['causamortis'];


    public function registrosSepultamento()
    {
        return $this->hasMany('ArqAdmin\Entities\RegistroSepultamento');
    }
}
