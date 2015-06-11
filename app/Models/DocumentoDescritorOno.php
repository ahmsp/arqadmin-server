<?php

namespace ArqAdmin\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentoDescritorOno extends Model {

    protected $table = 'documento_descritor_ono';

    public $timestamps = false;

    protected $fillable = ['documento_id', 'descritor_ono_id'];

    protected $guarded = [];
}
