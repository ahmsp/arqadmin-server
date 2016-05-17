<?php

namespace ArqAdmin\Entities;

use ArqAdmin\Traits\OverrideRevisionableTrait;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Conservacao extends Model implements Transformable
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
        'conservacao_estado' => 'Conservação'
    ];
    
    protected $table = 'conservacao';

    public $timestamps = false;

    protected $fillable = ['conservacao_estado'];

    public function identifiableName()
    {
        return $this->conservacao_estado;
    }

    public function documentos()
    {
        return $this->hasMany('ArqAdmin\Entities\Documento');
    }
}
