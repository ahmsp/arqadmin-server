<?php

namespace ArqAdmin\Entities;

use ArqAdmin\Traits\OverrideRevisionableTrait;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class FtCampo extends Model implements Transformable
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
        'campo' => 'Campo'
    ];

    protected $table = 'ft_campo';

    public $timestamps = false;

    protected $fillable = ['campo'];

    public function identifiableName()
    {
        return $this->campo;
    }

    public function fotografias()
    {
        return $this->hasMany('ArqAdmin\Entities\Fotografia');
    }

}
