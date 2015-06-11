<?php

namespace ArqAdmin\Models;

use Illuminate\Database\Eloquent\Model;

class LcSala extends Model {

    protected $table = 'lc_sala';

    public $timestamps = false;

    protected $fillable = ['sala'];


    public function documentos()
    {
        return $this->hasMany('ArqAdmin\Models\Documento');
    }

    public function registrosSepultamento()
    {
        return $this->hasMany('ArqAdmin\Models\RegistroSepultamento');
    }
}
