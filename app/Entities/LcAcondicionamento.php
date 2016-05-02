<?php

namespace ArqAdmin\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class LcAcondicionamento extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'lc_acondicionamento';

    public $timestamps = false;

    protected $fillable = ['acondicionamento'];


    public function documentos()
    {
        return $this->hasMany('ArqAdmin\Entities\Documento');
    }

    public function registrosSepultamento()
    {
        return $this->hasMany('ArqAdmin\Entities\RegistroSepultamento');
    }
}
