<?php

namespace ArqAdmin\Models;

use Illuminate\Database\Eloquent\Model;

class DtSuporte extends Model {

    protected $table = 'dt_suporte';

    public $timestamps = false;

    protected $fillable = ['suporte'];


    public function desenhosTecnicos()
    {
        return $this->hasMany('ArqAdmin\Models\DesenhoTecnico');
    }
}
