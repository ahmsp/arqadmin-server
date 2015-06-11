<?php

namespace ArqAdmin\Models;

use Illuminate\Database\Eloquent\Model;

class DesenhoTecnico extends Model {

    protected $table = 'desenho_tecnico';

    public $timestamps = true;

    protected $fillable = ['documento_id', 'notacao', 'prancha_num', 'original_num', 'desenho_data', 'descricao', 'desenhista', 'original', 'copia', 'dt_tipo_id', 'dimensao', 'dt_suporte_id', 'dt_escala_id', 'dt_tecnica_id', 'notas', 'dt_conservacao_id', 'arquivo_nome'];

    protected $guarded = [];

    
}
