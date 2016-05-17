<?php

namespace ArqAdmin\Entities;

use ArqAdmin\Traits\OverrideRevisionableTrait;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Acervo extends Model implements Transformable
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
        'acervo_nome' => 'Acervo'
    ];

    protected $table = 'acervo';

    public $timestamps = false;

    protected $fillable = [
        'acervo_nome', 'descricao', 'fundo_id', 'subfundo_id', 'grupo_id',
        'subgrupo_id', 'serie_id', 'subserie_id', 'dossie_id'];

    public function identifiableName()
    {
        return $this->acervo_nome;
    }
}
