<?php

namespace ArqAdmin\Models;

use Illuminate\Database\Eloquent\Model;

class Subfundo extends Model {

	protected $table = 'subfundo';

    public $timestamps = false;

    protected $fillable = ['fundo_id', 'subfundo_nome'];


    public function documentos()
    {
        return $this->hasMany('ArqAdmin\Models\Documento');
    }

    public function registrosSepultamento()
    {
        return $this->hasMany('ArqAdmin\Models\RegistroSepultamento');
    }
}
