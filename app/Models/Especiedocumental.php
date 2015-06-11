<?php

namespace ArqAdmin\Models;

use Illuminate\Database\Eloquent\Model;

class Especiedocumental extends Model {

    protected $table = 'especiedocumental';

    public $timestamps = false;

    protected $fillable = ['especiedocumental_nome'];


    public function documentos()
    {
        return $this->hasMany('ArqAdmin\Models\Documento');
    }

    public function registrosSepultamento()
    {
        return $this->hasMany('ArqAdmin\Models\RegistroSepultamento');
    }
}
