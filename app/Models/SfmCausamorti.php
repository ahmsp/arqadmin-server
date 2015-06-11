<?php

namespace ArqAdmin\Models;

use Illuminate\Database\Eloquent\Model;

class SfmCausamortis extends Model {

    protected $table = 'sfm_causamortis';

    public $timestamps = false;

    protected $fillable = ['causamortis'];


    public function registrosSepultamento()
    {
        return $this->hasMany('ArqAdmin\Models\RegistroSepultamento');
    }
}
