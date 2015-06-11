<?php

namespace ArqAdmin\Models;

use Illuminate\Database\Eloquent\Model;

class RegistroSepultamento extends Model {

	protected $table = 'registro_sepultamento';

    public $timestamps = true;

    protected $fillable = ['fundo_id', 'subfundo_id', 'grupo_id', 'subgrupo_id', 'serie_id', 'subserie_id', 'dossie_id', 'especiedocumental_id', 'ano', 'notas', 'lc_sala_id', 'lc_movel_id', 'lc_movel_num', 'lc_compartimento_id', 'lc_compartimento_num', 'lc_acondicionamento_id', 'lc_acondicionamento_num', 'lc_pagina', 'sfm_cartorio_id', 'sfm_cemiterio_id', 'sfm_nome', 'sfm_nacionalidade_id', 'sfm_naturalidade_id', 'sfm_idade', 'sfm_estadocivil_id', 'sfm_conjuge', 'sfm_pai', 'sfm_mae', 'sfm_data_morte', 'sfm_causamortis_id', 'sfm_sepult_localizacao'];

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

    public function sfmCartorios()
    {
        return $this->belongsTo('ArqAdmin\Models\Conservacao', 'sfm_cartorio_id');
    }

    public function sfmCemiterios()
    {
        return $this->belongsTo('ArqAdmin\Models\Conservacao', 'sfm_cemiterio_id');
    }

    public function smfNacionalidades()
    {
        return $this->belongsTo('ArqAdmin\Models\Conservacao', 'sfm_nacionalidade_id');
    }

    public function sfmNaturalidades()
    {
        return $this->belongsTo('ArqAdmin\Models\Conservacao', 'sfm_naturalidade_id');
    }

    public function sfmEstadoscivis()
    {
        return $this->belongsTo('ArqAdmin\Models\Conservacao', 'sfm_estadocivil_id');
    }

    public function sfmCausasMortis()
    {
        return $this->belongsTo('ArqAdmin\Models\Conservacao', 'sfm_causamortis_id');
    }
}
