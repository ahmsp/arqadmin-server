<?php

namespace ArqAdmin\Entities;

use ArqAdmin\Traits\OverrideRevisionableTrait;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Dossie extends Model implements Transformable
{
    use TransformableTrait;
    use OverrideRevisionableTrait;

    protected $revisionEnabled = true;
    protected $revisionCreationsEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit = 500;
    protected $revisionNullString = 'nenhum';
    protected $revisionUnknownString = 'desconhecido';
    protected $revisionFormattedFieldNames = [
        'dossie_nome' => 'Dossiê'
    ];

    protected $table = 'dossie';

    public $timestamps = false;

    protected $fillable = [
        'fundo_id', 'subfundo_id', 'grupo_id', 'subgrupo_id',
        'serie_id', 'subserie_id', 'dossie_nome'
    ];

    public function identifiableName()
    {
        return $this->dossie_nome;
    }

    public function documentos()
    {
        return $this->hasMany('ArqAdmin\Entities\Documento');
    }

    public function registrosSepultamento()
    {
        return $this->hasMany('ArqAdmin\Entities\RegistroSepultamento');
    }
}
