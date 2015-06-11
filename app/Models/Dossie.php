<?php

namespace ArqAdmin\Models;

use Illuminate\Database\Eloquent\Model;

class Dossie extends Model {

    protected $table = 'dossie';

    public $timestamps = false;

    protected $fillable = ['fundo_id', 'subfundo_id', 'grupo_id', 'subgrupo_id', 'serie_id', 'subserie_id', 'dossie_nome'];


    public function documentos()
    {
        return $this->hasMany('ArqAdmin\Models\Documento');
    }

    public function registrosSepultamento()
    {
        return $this->hasMany('ArqAdmin\Models\RegistroSepultamento');
    }
}
