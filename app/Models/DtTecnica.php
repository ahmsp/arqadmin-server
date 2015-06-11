<?php

namespace ArqAdmin\Models;

use Illuminate\Database\Eloquent\Model;

class DtTecnica extends Model {

    protected $table = 'dt_tecnica';

    public $timestamps = false;

    protected $fillable = ['tecnica'];


    public function desenhosTecnicos()
    {
        return $this->hasMany('ArqAdmin\Models\DesenhoTecnico');
    }
}
