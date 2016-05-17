<?php

namespace ArqAdmin\Entities;

use ArqAdmin\Traits\OverrideRevisionableTrait;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class DtTecnica extends Model implements Transformable
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
        'tecnica' => 'Técnica'
    ];

    protected $table = 'dt_tecnica';

    public $timestamps = false;

    protected $fillable = ['tecnica'];

    public function identifiableName()
    {
        return $this->tecnica;
    }

    public function desenhosTecnicos()
    {
        return $this->hasMany('ArqAdmin\Entities\DesenhoTecnico');
    }
}
