<?php

namespace ArqAdmin\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class DesenhoTecnico extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;

    protected $table = 'desenho_tecnico';

    public $timestamps = false;

    protected $fillable = [
        'documento_id',
        'acervo_tipo',
        'notacao',
        'prancha_num',
        'original_num',
        'desenho_data',
        'descricao',
        'desenhista',
        'original',
        'copia',
        'dt_tipo_id',
        'dimensao',
        'dt_suporte_id',
        'dt_escala_id',
        'dt_tecnica_id',
        'notas',
        'dt_conservacao_id',
        'arquivo_nome',
        'arquivo_original'
    ];

    protected $guarded = [];

    public function documento()
    {
        return $this->belongsTo('ArqAdmin\Entities\Documento');
    }

    public function dtTipo()
    {
        return $this->belongsTo('ArqAdmin\Entities\DtTipo');
    }

    public function dtSuporte()
    {
        return $this->belongsTo('ArqAdmin\Entities\DtSuporte');
    }

    public function dtEscala()
    {
        return $this->belongsTo('ArqAdmin\Entities\DtEscala');
    }

    public function dtTecnica()
    {
        return $this->belongsTo('ArqAdmin\Entities\DtTecnica');
    }

    public function dtConservacao()
    {
        return $this->belongsTo('ArqAdmin\Entities\DtConservacao');
    }
}
