<?php

namespace ArqAdmin\Models;

use Illuminate\Database\Eloquent\Model;

class DtUso extends Model {

    protected $table = 'dt_uso';

    public $timestamps = false;

    protected $fillable = ['uso'];


    public function documentos()
    {
        return $this->hasMany('ArqAdmin\Models\Documento');
    }
}
