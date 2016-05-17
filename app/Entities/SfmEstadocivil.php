<?php

namespace ArqAdmin\Entities;

use ArqAdmin\Traits\OverrideRevisionableTrait;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class SfmEstadocivil extends Model implements Transformable
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
        'estadocivil' => 'Estado Civil'
    ];

    protected $table = 'sfm_estadocivil';

    public $timestamps = false;

    protected $fillable = ['estadocivil'];

    public function identifiableName()
    {
        return $this->estadocivil;
    }

    public function registrosSepultamento()
    {
        return $this->hasMany('ArqAdmin\Entities\RegistroSepultamento');
    }
}
