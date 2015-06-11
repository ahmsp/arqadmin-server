<?php

namespace ArqAdmin\Models;

use Illuminate\Database\Eloquent\Model;

class Fundo extends Model
{
    protected $table = 'fundo';

    public $timestamps = false;

    protected $fillable = ['fundo_nome'];


    public function documentos()
    {
        return $this->hasMany('ArqAdmin\Models\Documento');
    }

    public function registrosSepultamento()
    {
        return $this->hasMany('ArqAdmin\Models\RegistroSepultamento');
    }
}
