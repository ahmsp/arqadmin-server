<?php

namespace ArqAdmin\Models;

use Illuminate\Database\Eloquent\Model;

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

    protected $guarded = [];


    public function fundos()
    {
        return $this->belongsTo('ArqAdmin\Models\Fundo', 'fundo_id');
    }

    public function subfundos()
    {
        return $this->belongsTo('ArqAdmin\Models\Subfundo', 'subfundo_id');
    }

    public function grupos()
    {
        return $this->belongsTo('ArqAdmin\Models\Grupo', 'grupo_id');
    }

    public function subgrupos()
    {
        return $this->belongsTo('ArqAdmin\Models\Subgrupo', 'subgrupo_id');
    }

    public function series()
    {
        return $this->belongsTo('ArqAdmin\Models\Serie', 'serie_id');
    }

    public function subseries()
    {
        return $this->belongsTo('ArqAdmin\Models\Subserie', 'subserie_id');
    }

    public function dossies()
    {
        return $this->belongsTo('ArqAdmin\Models\Dossie', 'dossie_id');
    }

    public function EspeciesDocumental()
    {
        return $this->belongsTo('ArqAdmin\Models\Especiedocumental', 'especiedocumental_id');
    }

    public function lcSalas()
    {
        return $this->belongsTo('ArqAdmin\Models\LcSala', 'lc_sala_id');
    }

    public function lcMoveis()
    {
        return $this->belongsTo('ArqAdmin\Models\LcMovel', 'lc_movel_id');
    }

    public function lcCompartimentos()
    {
        return $this->belongsTo('ArqAdmin\Models\LcCompartimento', 'lc_compartimento_id');
    }

    public function lcAcondicionamentos()
    {
        return $this->belongsTo('ArqAdmin\Models\LcAcondicionamento', 'lc_acondicionamento_id');
    }

    public function conservacoes()
    {
        return $this->belongsTo('ArqAdmin\Models\Conservacao', 'conservacao_id');
    }

    public function dtUsos()
    {
        return $this->belongsTo('ArqAdmin\Models\Dtuso', 'dt_uso_id');
    }

}
