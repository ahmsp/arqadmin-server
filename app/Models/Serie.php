<?php

namespace ArqAdmin\Models;

use Illuminate\Database\Eloquent\Model;

class Serie extends Model {

	protected $table = 'serie';

    public $timestamps = false;

    protected $fillable = ['fundo_id', 'subfundo_id', 'grupo_id', 'subgrupo_id', 'serie_nome'];


    public function documentos()
    {
        return $this->hasMany('ArqAdmin\Models\Documento');
    }

    public function registrosSepultamento()
    {
        return $this->hasMany('ArqAdmin\Models\RegistroSepultamento');
    }
}
