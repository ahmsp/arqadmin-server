<?php

namespace ArqAdmin\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Acervo extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'acervo';

    public $timestamps = false;

    protected $fillable = ['acervo_nome', 'descricao', 'fundo_id', 'subfundo_id', 'grupo_id', 'subgrupo_id', 'serie_id', 'subserie_id', 'dossie_id'];

}
