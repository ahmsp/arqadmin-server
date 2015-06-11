<?php

namespace ArqAdmin\Models;

use Illuminate\Database\Eloquent\Model;

class SfmCartorio extends Model {

    protected $table = 'sfm_cartorio';

    public $timestamps = false;

    protected $fillable = ['cartorio'];


    public function registrosSepultamento()
    {
        return $this->hasMany('ArqAdmin\Models\RegistroSepultamento');
    }
}
