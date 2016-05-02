<?php

namespace ArqAdmin\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class DtUso extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'dt_uso';

    public $timestamps = false;

    protected $fillable = ['uso'];


    public function documentos()
    {
        return $this->hasMany('ArqAdmin\Entities\Documento');
    }
}
