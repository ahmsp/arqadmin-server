<?php

namespace ArqAdmin\Entities;

use ArqAdmin\Traits\OverrideRevisionableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class RegistroSepultamento extends Model implements Transformable
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
        'fundo_id' => 'Fundo',
        'subfundo_id' => 'Sub-fundo',
        'grupo_id' => 'Grupo',
        'subgrupo_id' => 'Sub-grupo',
        'serie_id' => 'Série',
        'subserie_id' => 'Sub-série',
        'dossie_id' => 'Dossiê',
        'especiedocumental_id' => 'Especie Documental',
        'ano' => 'Ano',
        'notas' => 'Notas',
        'lc_sala_id' => 'Sala',
        'lc_movel_id' => 'Móvel',
        'lc_movel_num' => 'Móvel nº',
        'lc_compartimento_id' => 'Compartimento',
        'lc_compartimento_num' => 'Compartimento nº',
        'lc_acondicionamento_id' => 'Acondicionamento',
        'lc_acondicionamento_num' => 'Acondicionamento nº',
        'lc_pagina' => 'Página',
        'sfm_cartorio_id' => 'Cartório',
        'sfm_cemiterio_id' => 'Cemitério',
        'sfm_nome' => 'Nome',
        'sfm_nacionalidade_id' => 'Nacionalidade',
        'sfm_naturalidade_id' => 'Naturalidade',
        'sfm_idade' => 'Idade',
        'sfm_estadocivil_id' => 'Estado Civil',
        'sfm_conjuge' => 'Cônjuge',
        'sfm_pai' => 'Nome do Pai',
        'sfm_mae' => 'Nome da Mae',
        'sfm_data_morte' => 'Data Falecimento',
        'sfm_causamortis_id' => 'Causa-Mortis',
        'sfm_sepult_localizacao' => 'Sepultamento Localizacao',
    ];

    protected $table = 'registro_sepultamento';

    public $timestamps = false;

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

    // default values
    protected $attributes = [
        'fundo_id' => 3,
        'subfundo_id' => 20,
        'grupo_id' => 85,
        'subgrupo_id' => 28,
        'serie_id' => 248,
        'especiedocumental_id' => 5
    ];

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

    public function sfmNacionalidade()
    {
        return $this->belongsTo('ArqAdmin\Entities\SfmNacionalidade', 'sfm_nacionalidade_id');
    }

    public function sfmNaturalidade()
    {
        return $this->belongsTo('ArqAdmin\Entities\SfmNaturalidade', 'sfm_naturalidade_id');
    }

    public function sfmEstadocivil()
    {
        return $this->belongsTo('ArqAdmin\Entities\SfmEstadocivil', 'sfm_estadocivil_id');
    }

    public function sfmCausaMortis()
    {
        return $this->belongsTo('ArqAdmin\Entities\SfmCausaMortis', 'sfm_causamortis_id');
    }
}
