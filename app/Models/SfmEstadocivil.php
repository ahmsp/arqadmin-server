<?php

namespace ArqAdmin\Models;

use Illuminate\Database\Eloquent\Model;

class SfmEstadocivil extends Model {

    protected $table = 'sfm_estadocivil';

    public $timestamps = false;

    protected $fillable = ['estadocivil'];


    public function registrosSepultamento()
    {
        return $this->hasMany('ArqAdmin\Models\RegistroSepultamento');
    }
}
