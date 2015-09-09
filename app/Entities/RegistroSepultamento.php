<?php

namespace ArqAdmin\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class RegistroSepultamento extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'registro_sepultamento';

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
        'ano',
        'notas',
        'lc_sala_id',
        'lc_movel_id',
        'lc_movel_num',
        'lc_compartimento_id',
        'lc_compartimento_num',
        'lc_acondicionamento_id',
        'lc_acondicionamento_num',
        'lc_pagina',
        'sfm_cartorio_id',
        'sfm_cemiterio_id',
        'sfm_nome',
        'sfm_nacionalidade_id',
        'sfm_naturalidade_id',
        'sfm_idade',
        'sfm_estadocivil_id',
        'sfm_conjuge',
        'sfm_pai',
        'sfm_mae',
        'sfm_data_morte',
        'sfm_causamortis_id',
        'sfm_sepult_localizacao'
    ];

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
        return $this->belongsTo('ArqAdmin\Entities\Conservacao', 'conservacao_id');
    }

    public function sfmCartorio()
    {
        return $this->belongsTo('ArqAdmin\Entities\SfmCartorio', 'sfm_cartorio_id');
    }

    public function sfmCemiterio()
    {
        return $this->belongsTo('ArqAdmin\Entities\SfmCemiterio', 'sfm_cemiterio_id');
    }

    public function smfNacionalidade()
    {
        return $this->belongsTo('ArqAdmin\Entities\SfmNacionalidade', 'sfm_nacionalidade_id');
    }

    public function sfmNaturalidade()
    {
        return $this->belongsTo('ArqAdmin\Entities\SfmNaturalidade', 'sfm_naturalidade_id');
    }

    public function sfmEstadoscivil()
    {
        return $this->belongsTo('ArqAdmin\Entities\SfmEstadocivil', 'sfm_estadocivil_id');
    }

    public function sfmCausasMortis()
    {
        return $this->belongsTo('ArqAdmin\Entities\SfmCausaMortis', 'sfm_causamortis_id');
    }
}
