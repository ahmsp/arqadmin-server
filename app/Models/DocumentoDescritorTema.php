<?php

namespace ArqAdmin\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentoDescritorTema extends Model {

    protected $table = 'documento_descritor_tema';

    public $timestamps = false;

    protected $fillable = ['documento_id', 'descritor_tema_id'];

    protected $guarded = [];
}
