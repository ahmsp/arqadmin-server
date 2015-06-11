<?php

namespace ArqAdmin\Models;

use Illuminate\Database\Eloquent\Model;

class DescritorTema extends Model {

    protected $table = 'descritor_tema';

    public $timestamps = false;

    protected $fillable = ['descritor'];

    protected $guarded = [];
}
