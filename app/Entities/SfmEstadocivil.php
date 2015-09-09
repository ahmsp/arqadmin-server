<?php

namespace ArqAdmin\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class SfmEstadocivil extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'sfm_estadocivil';

    public $timestamps = false;

    protected $fillable = ['estadocivil'];


    public function registrosSepultamento()
    {
        return $this->hasMany('ArqAdmin\Entities\RegistroSepultamento');
    }
}
