<?php

namespace ArqAdmin\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Subfundo extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'subfundo';

    public $timestamps = false;

    protected $fillable = ['fundo_id', 'subfundo_nome'];


    public function documentos()
    {
        return $this->hasMany('ArqAdmin\Entities\Documento');
    }

    public function registrosSepultamento()
    {
        return $this->hasMany('ArqAdmin\Entities\RegistroSepultamento');
    }

}
