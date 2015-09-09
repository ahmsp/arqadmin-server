<?php

namespace ArqAdmin\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class SfmNacionalidade extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'sfm_nacionalidade';

    public $timestamps = false;

    protected $fillable = ['nacionalidade'];


    public function registrosSepultamento()
    {
        return $this->hasMany('ArqAdmin\Entities\RegistroSepultamento');
    }
}
