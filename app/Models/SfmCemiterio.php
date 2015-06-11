<?php

namespace ArqAdmin\Models;

use Illuminate\Database\Eloquent\Model;

class SfmCemiterio extends Model {

    protected $table = 'sfm_cemiterio';

    public $timestamps = false;

    protected $fillable = ['cemiterio'];


    public function registrosSepultamento()
    {
        return $this->hasMany('ArqAdmin\Models\RegistroSepultamento');
    }
}
