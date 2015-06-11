<?php

namespace ArqAdmin\Models;

use Illuminate\Database\Eloquent\Model;

class Auditoria extends Model {

    protected $table = 'auditoria';

    public $timestamps = false;

    protected $fillable = ['eventoid', 'objeto_tabela', 'identificador', 'campo', 'valor_antigo', 'valor_novo', 'operacao', 'operacao_data', 'usuario_ident', 'hostname', 'sessaoid'];
}
