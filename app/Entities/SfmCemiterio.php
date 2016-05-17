<?php

namespace ArqAdmin\Entities;

use ArqAdmin\Traits\OverrideRevisionableTrait;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class SfmCemiterio extends Model implements Transformable
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
        'cemiterio' => 'Cemitério'
    ];

    protected $table = 'sfm_cemiterio';

    public $timestamps = false;

    protected $fillable = ['cemiterio'];

    public function identifiableName()
    {
        return $this->cemiterio;
    }

    public function registrosSepultamento()
    {
        return $this->hasMany('ArqAdmin\Entities\RegistroSepultamento');
    }
}
