<?php

namespace ArqAdmin\Entities;

use ArqAdmin\Traits\OverrideRevisionableTrait;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class DtUso extends Model implements Transformable
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
        'uso' => 'Uso'
    ];

    protected $table = 'dt_uso';

    public $timestamps = false;

    protected $fillable = ['uso'];

    public function identifiableName()
    {
        return $this->uso;
    }

    public function documentos()
    {
        return $this->hasMany('ArqAdmin\Entities\Documento');
    }
}
