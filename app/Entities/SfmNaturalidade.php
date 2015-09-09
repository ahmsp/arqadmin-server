<?php

namespace ArqAdmin\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class SfmNaturalidade extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'sfm_naturalidade';

    public $timestamps = false;

    protected $fillable = ['naturalidade'];


    public function registrosSepultamento()
    {
        return $this->hasMany('ArqAdmin\Entities\RegistroSepultamento');
    }
}
