<?php

namespace ArqAdmin\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Conservacao extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'conservacao';

    public $timestamps = false;

    protected $fillable = ['conservacao_estado'];


    public function documentos()
    {
        return $this->hasMany('ArqAdmin\Models\Documento');
    }
}
