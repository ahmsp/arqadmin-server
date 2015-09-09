<?php

namespace ArqAdmin\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Documento extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'documento';

    public $timestamps = true;

    protected $fillable = [
        'fundo_id',
        'subfundo_id',
        'grupo_id',
        'subgrupo_id',
        'serie_id',
        'subserie_id',
        'dossie_id',
        'especiedocumental_id',
        'notacao_preexistente',
        'notacao',
        'ano',
        'data_doc',
        'processo_num',
        'quantidade_doc',
        'conservacao_id',
        'interessado',
        'assunto',
        'notas',
        'lc_sala_id',
        'lc_movel_id',
        'lc_movel_num',
        'lc_compartimento_id',
        'lc_compartimento_num',
        'lc_acondicionamento_id',
        'lc_acondicionamento_num',
        'lc_pagina',
        'dt_uso_id',
        'dt_endereco',
        'dt_end_complemento',
        'dt_endereco_atual',
        'dt_endatual_complemento',
        'dt_proprietario',
        'dt_autor',
        'dt_construtor',
        'dt_notas'
    ];

//    protected $hidden = ['dt_construtor'];

    protected $guarded = [];


    public function fundo()
    {
        return $this->belongsTo('ArqAdmin\Entities\Fundo', 'fundo_id');
    }

    public function subfundo()
    {
        return $this->belongsTo('ArqAdmin\Entities\Subfundo', 'subfundo_id');
    }

    public function grupo()
    {
        return $this->belongsTo('ArqAdmin\Entities\Grupo', 'grupo_id');
    }

    public function subgrupo()
    {
        return $this->belongsTo('ArqAdmin\Entities\Subgrupo', 'subgrupo_id');
    }

    public function serie()
    {
        return $this->belongsTo('ArqAdmin\Entities\Serie', 'serie_id');
    }

    public function subserie()
    {
        return $this->belongsTo('ArqAdmin\Entities\Subserie', 'subserie_id');
    }

    public function dossie()
    {
        return $this->belongsTo('ArqAdmin\Entities\Dossie', 'dossie_id');
    }

    public function especieDocumental()
    {
        return $this->belongsTo('ArqAdmin\Entities\Especiedocumental', 'especiedocumental_id');
    }

    public function lcSala()
    {
        return $this->belongsTo('ArqAdmin\Entities\LcSala', 'lc_sala_id');
    }

    public function lcMovel()
    {
        return $this->belongsTo('ArqAdmin\Entities\LcMovel', 'lc_movel_id');
    }

    public function lcCompartimento()
    {
        return $this->belongsTo('ArqAdmin\Entities\LcCompartimento', 'lc_compartimento_id');
    }

    public function lcAcondicionamento()
    {
        return $this->belongsTo('ArqAdmin\Entities\LcAcondicionamento', 'lc_acondicionamento_id');
    }

    public function conservacao()
    {
        return $this->belongsTo('\ArqAdmin\Entities\Conservacao', 'conservacao_id');
    }

    public function dtUso()
    {
        return $this->belongsTo('ArqAdmin\Entities\DtUso', 'dt_uso_id');
    }

    public function desenhosTecnicos()
    {
        return $this->hasMany('ArqAdmin\Entities\DesenhoTecnico');
    }

    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }

    public function scopeStatistic($query)
    {
        return $query->select(DB::raw('count(*) as qtd, ano'))
            ->whereBetween('ano', [1000, 2000])
            ->groupBy('ano')
            ->having('qtd', '>', 3)
            ->orderBy('ano', 'asc')
            ->get();
    }
}
