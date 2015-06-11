<?php

namespace ArqAdmin\Models;

use Illuminate\Database\Eloquent\Model;

class DtTipo extends Model {

    protected $table = 'dt_tipo';

    public $timestamps = false;

    protected $fillable = ['tipo'];


    public function desenhosTecnicos()
    {
        return $this->hasMany('ArqAdmin\Models\DesenhoTecnico');
    }
}
