<?php

namespace ArqAdmin\Models;

use Illuminate\Database\Eloquent\Model;

class LcMovel extends Model {

    protected $table = 'lc_movel';

    public $timestamps = false;

    protected $fillable = ['movel'];


    public function documentos()
    {
        return $this->hasMany('ArqAdmin\Models\Documento');
    }

    public function registrosSepultamento()
    {
        return $this->hasMany('ArqAdmin\Models\RegistroSepultamento');
    }
}
