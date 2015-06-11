<?php

namespace ArqAdmin\Models;

use Illuminate\Database\Eloquent\Model;

class Conservacao extends Model
{
    protected $table = 'conservacao';

    public $timestamps = false;

    protected $fillable = ['conservacao_estado'];


    public function documentos()
    {
        return $this->hasMany('ArqAdmin\Models\Documento');
    }
}
