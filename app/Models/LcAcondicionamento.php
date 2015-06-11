<?php

namespace ArqAdmin\Models;

use Illuminate\Database\Eloquent\Model;

class LcAcondicionamento extends Model {

    protected $table = 'lc_acondicionamento';

    public $timestamps = false;

    protected $fillable = ['acondicionamento'];


    public function documentos()
    {
        return $this->hasMany('ArqAdmin\Models\Documento');
    }

    public function registrosSepultamento()
    {
        return $this->hasMany('ArqAdmin\Models\RegistroSepultamento');
    }
}
