<?php

namespace ArqAdmin\Entities;

use ArqAdmin\Traits\OverrideRevisionableTrait;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class FtSerie extends Model implements Transformable
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
        'serie' => 'Série'
    ];

    protected $table = 'ft_serie';

    public $timestamps = false;

    protected $fillable = ['serie'];

    public function identifiableName()
    {
        return $this->serie;
    }

    public function fotografias()
    {
        return $this->hasMany('ArqAdmin\Entities\Fotografia');
    }

}
