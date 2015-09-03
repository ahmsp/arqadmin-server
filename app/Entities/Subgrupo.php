<?php

namespace ArqAdmin\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Subgrupo extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'subgrupo';

    public $timestamps = false;

    protected $fillable = ['fundo_id', 'subfundo_id', 'grupo_id', 'subgrupo_nome'];


    public function documentos()
    {
        return $this->hasMany('ArqAdmin\Models\Documento');
    }

    public function registrosSepultamento()
    {
        return $this->hasMany('ArqAdmin\Models\RegistroSepultamento');
    }
}
