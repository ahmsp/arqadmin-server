<?php

namespace ArqAdmin\Models;

use Illuminate\Database\Eloquent\Model;

class DtEscala extends Model {

    protected $table = 'dt_escala';

    public $timestamps = false;

    protected $fillable = ['escala'];


    public function desenhosTecnicos()
    {
        return $this->hasMany('ArqAdmin\Models\DesenhoTecnico');
    }
}
