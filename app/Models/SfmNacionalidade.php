<?php

namespace ArqAdmin\Models;

use Illuminate\Database\Eloquent\Model;

class SfmNacionalidade extends Model {

    protected $table = 'sfm_nacionalidade';

    public $timestamps = false;

    protected $fillable = ['nacionalidade'];


    public function registrosSepultamento()
    {
        return $this->hasMany('ArqAdmin\Models\RegistroSepultamento');
    }
}
