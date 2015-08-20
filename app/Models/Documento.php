<?php

namespace ArqAdmin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Documento extends Model
{
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
        return $this->belongsTo('ArqAdmin\Models\Fundo', 'fundo_id');
    }

    public function subfundo()
    {
        return $this->belongsTo('ArqAdmin\Models\Subfundo', 'subfundo_id');
    }

    public function grupo()
    {
        return $this->belongsTo('ArqAdmin\Models\Grupo', 'grupo_id');
    }

    public function subgrupo()
    {
        return $this->belongsTo('ArqAdmin\Models\Subgrupo', 'subgrupo_id');
    }

    public function serie()
    {
        return $this->belongsTo('ArqAdmin\Models\Serie', 'serie_id');
    }

    public function subserie()
    {
        return $this->belongsTo('ArqAdmin\Models\Subserie', 'subserie_id');
    }

    public function dossie()
    {
        return $this->belongsTo('ArqAdmin\Models\Dossie', 'dossie_id');
    }

    public function especieDocumental()
    {
        return $this->belongsTo('ArqAdmin\Models\Especiedocumental', 'especiedocumental_id');
    }

    public function lcSala()
    {
        return $this->belongsTo('ArqAdmin\Models\LcSala', 'lc_sala_id');
    }

    public function lcMovel()
    {
        return $this->belongsTo('ArqAdmin\Models\LcMovel', 'lc_movel_id');
    }

    public function lcCompartimento()
    {
        return $this->belongsTo('ArqAdmin\Models\LcCompartimento', 'lc_compartimento_id');
    }

    public function lcAcondicionamento()
    {
        return $this->belongsTo('ArqAdmin\Models\LcAcondicionamento', 'lc_acondicionamento_id');
    }

    public function conservacao()
    {
//        return $this->belongsTo('ArqAdmin\Models\Conservacao', 'conservacao_id');
        return $this->belongsTo(Conservacao::class, 'conservacao_id');
    }

    public function dtUso()
    {
        return $this->belongsTo('ArqAdmin\Models\Dtuso', 'dt_uso_id');
    }

    public function desenhosTecnicos()
    {
        return $this->hasMany('ArqAdmin\Models\DesenhoTecnico');
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
