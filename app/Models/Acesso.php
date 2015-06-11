<?php

namespace ArqAdmin\Models;

use Illuminate\Database\Eloquent\Model;

class Acesso extends Model {

    protected $table = 'acesso';

    public $timestamps = false;

    protected $fillable = ['sessao', 'usuario_ident', 'maquina_ip', 'maquina_nome', 'dominio', 'inicio_sessao', 'ultima_atividade', 'fim_sessao'];

}
