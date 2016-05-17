<?php

namespace ArqAdmin\Entities;

use ArqAdmin\Traits\OverrideRevisionableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class DesenhoTecnico extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;
    use OverrideRevisionableTrait;

    protected $revisionEnabled = true;
    protected $revisionCreationsEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit = 500;
    protected $revisionNullString = 'nenhum';
    protected $revisionUnknownString = 'desconhecido';

    protected $revisionFormattedFieldNames = [
        'documento_id' => 'Documento ID',
        'acervo_tipo' => 'Acervo Tipo',
        'notacao' => 'Notação',
        'prancha_num' => 'Prancha nº',
        'original_num' => 'Original nº',
        'desenho_data' => 'Desenho Data',
        'descricao' => 'Descrição',
        'desenhista' => 'Desenhista',
        'original' => 'Original',
        'copia' => 'Cópia',
        'dt_tipo_id' => 'Tipo',
        'dimensao' => 'Dimensão',
        'dt_suporte_id' => 'Suporte',
        'dt_escala_id' => 'Escala',
        'dt_tecnica_id' => 'Técnica',
        'notas' => 'Notas',
        'dt_conservacao_id' => 'Conservação',
        'arquivo_original' => 'Nome do Arquivo',
    ];

    protected $revisionFormattedFields = [
        'original'  => 'boolean:Não|Sim',
        'copia'  => 'boolean:Não|Sim',
    ];

    protected $dontKeepRevisionOf = [
        'arquivo_nome'
    ];

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
        'arquivo_original',
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
