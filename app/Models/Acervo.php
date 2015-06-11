<?php

namespace ArqAdmin\Models;

use Illuminate\Database\Eloquent\Model;

class Acervo extends Model {

    protected $table = 'acervo';

    public $timestamps = false;

    protected $fillable = ['acervo_nome', 'descricao', 'fundo_id', 'subfundo_id', 'grupo_id', 'subgrupo_id', 'serie_id', 'subserie_id', 'dossie_id'];

}
