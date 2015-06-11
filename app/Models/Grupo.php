<?php

namespace ArqAdmin\Models;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model {

	protected $table = 'grupo';

    public $timestamps = false;

    protected $fillable = ['fundo_id', 'subfundo_id', 'grupo_nome'];


    public function documentos()
    {
        return $this->hasMany('ArqAdmin\Models\Documento');
    }

    public function registrosSepultamento()
    {
        return $this->hasMany('ArqAdmin\Models\RegistroSepultamento');
    }
}
