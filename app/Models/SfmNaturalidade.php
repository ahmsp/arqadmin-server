<?php

namespace ArqAdmin\Models;

use Illuminate\Database\Eloquent\Model;

class SfmNaturalidade extends Model {

    protected $table = 'sfm_naturalidade';

    public $timestamps = false;

    protected $fillable = ['naturalidade'];


    public function registrosSepultamento()
    {
        return $this->hasMany('ArqAdmin\Models\RegistroSepultamento');
    }
}
