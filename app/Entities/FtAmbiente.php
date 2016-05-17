<?php

namespace ArqAdmin\Entities;

use ArqAdmin\Traits\OverrideRevisionableTrait;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class FtAmbiente extends Model implements Transformable
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
        'ambiente' => 'Ambiente'
    ];

    protected $table = 'ft_ambiente';

    public $timestamps = false;

    protected $fillable = ['ambiente'];

    public function identifiableName()
    {
        return $this->ambiente;
    }

    public function fotografias()
    {
        return $this->hasMany('ArqAdmin\Entities\Fotografia');
    }
}
