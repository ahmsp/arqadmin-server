<?php

namespace ArqAdmin\Entities;

use ArqAdmin\Traits\OverrideRevisionableTrait;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class FtCromia extends Model implements Transformable
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
        'cromia' => 'Cromia'
    ];

    protected $table = 'ft_cromia';

    public $timestamps = false;

    protected $fillable = ['cromia'];

    public function identifiableName()
    {
        return $this->cromia;
    }

    public function fotografias()
    {
        return $this->hasMany('ArqAdmin\Entities\Fotografia');
    }

}
