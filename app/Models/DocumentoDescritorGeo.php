<?php

namespace ArqAdmin\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentoDescritorGeo extends Model {

    protected $table = 'documento_descritor_geo';

    public $timestamps = false;

    protected $fillable = ['documento_id', 'descritor_geo_id'];

    protected $guarded = [];
}
