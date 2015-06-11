<?php

namespace ArqAdmin\Models;

use Illuminate\Database\Eloquent\Model;

class DescritorOno extends Model {

    protected $table = 'descritor_ono';

    public $timestamps = false;

    protected $fillable = ['descritor'];

    protected $guarded = [];
}
