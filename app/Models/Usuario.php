<?php

namespace ArqAdmin\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model {

    protected $table = 'usuario';

    public $timestamps = false;

    protected $fillable = ['usuario', 'papeis', 'nome', 'email'];
}
