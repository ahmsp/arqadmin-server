<?php

namespace ArqAdmin\Models;

use Illuminate\Database\Eloquent\Model;

class LcCompartimento extends Model {

    protected $table = 'lc_compartimento';

    ublic $timestamps = false;

    protected $fillable = ['compartimento'];


    public function documentos()
    {
        return $this->hasMany('ArqAdmin\Models\Documento');
    }

    public function registrosSepultamento()
    {
        return $this->hasMany('ArqAdmin\Models\RegistroSepultamento');
    }
}
