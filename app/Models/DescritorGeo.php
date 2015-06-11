<?php

namespace ArqAdmin\Models;

use Illuminate\Database\Eloquent\Model;

class DescritorGeo extends Model {

    protected $table = 'descritor_geo';

    public $timestamps = false;

    protected $fillable = ['descritor'];

    protected $guarded = [];
}
