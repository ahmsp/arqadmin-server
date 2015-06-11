<?php

namespace ArqAdmin\Models;

use Illuminate\Database\Eloquent\Model;

class DtConservacao extends Model {

    protected $table = 'dt_conservacao';

    public $timestamps = false;

    protected $fillable = ['conservacao'];


    public function desenhosTecnicos()
    {
        return $this->hasMany('ArqAdmin\Models\DesenhoTecnico');
    }
}
