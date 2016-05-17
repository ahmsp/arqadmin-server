<?php

namespace ArqAdmin\Entities;

use ArqAdmin\Traits\OverrideRevisionableTrait;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class FtFundo extends Model implements Transformable
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
        'fundo' => 'Fundo'
    ];

    protected $table = 'ft_fundo';

    public $timestamps = false;

    protected $fillable = ['fundo'];

    public function identifiableName()
    {
        return $this->fundo;
    }

    public function fotografias()
    {
        return $this->hasMany('ArqAdmin\Entities\Fotografia');
    }
}
