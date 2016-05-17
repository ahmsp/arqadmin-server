<?php

namespace ArqAdmin\Entities;

use ArqAdmin\Traits\OverrideRevisionableTrait;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class DtConservacao extends Model implements Transformable
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
        'conservacao' => 'Conservação'
    ];

    protected $table = 'dt_conservacao';

    public $timestamps = false;

    protected $fillable = ['conservacao'];

    public function identifiableName()
    {
        return $this->conservacao;
    }

    public function desenhosTecnicos()
    {
        return $this->hasMany('ArqAdmin\Entities\DesenhoTecnico');
    }
}
