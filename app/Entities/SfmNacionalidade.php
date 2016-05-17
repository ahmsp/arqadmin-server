<?php

namespace ArqAdmin\Entities;

use ArqAdmin\Traits\OverrideRevisionableTrait;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class SfmNacionalidade extends Model implements Transformable
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
        'nacionalidade' => 'Nacionalidade'
    ];

    protected $table = 'sfm_nacionalidade';

    public $timestamps = false;

    protected $fillable = ['nacionalidade'];

    public function identifiableName()
    {
        return $this->nacionalidade;
    }

    public function registrosSepultamento()
    {
        return $this->hasMany('ArqAdmin\Entities\RegistroSepultamento');
    }
}
