<?php

namespace ArqAdmin\Entities;

use ArqAdmin\Traits\OverrideRevisionableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Fotografia extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;
    use OverrideRevisionableTrait;

    protected $table = 'fotografia';

    public $timestamps = false;

    protected $revisionEnabled = true;
    protected $revisionCreationsEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit = 500;
    protected $revisionNullString = 'nenhum';
    protected $revisionUnknownString = 'desconhecido';

    protected $revisionFormattedFieldNames = [
        'ft_fundo_id' => 'Fundo',
        'ft_grupo_id' => 'Grupo',
        'ft_serie_id' => 'Série',
        'ft_tipologia_id' => 'Tipologia',
        'data_imagem' => 'Data',
        'autoria' => 'Autoria',
        'imagem_identificacao' => 'Identificação',
        'bairro' => 'Bairro',
        'assunto_geral' => 'Assunto Geral',
        'titulo' => 'Título',
        'identificacao' => 'Identificação',
        'assunto_1' => 'Assunto 1',
        'assunto_2' => 'Assunto 2',
        'assunto_3' => 'Assunto 3',
        'registro' => 'Registro',
        'ft_cromia_id' => 'Cromia',
        'formato' => 'Formato',
        'ft_categoria_id' => 'Categoria',
        'ft_campo_id' => 'Campo',
        'tipo' => 'Tipo',
        'ft_ambiente_id' => 'Ambiente',
        'enquadramento' => 'Enquadramento',
        'inscricao' => 'Inscrição',
        'texto_inscricao' => 'Texto Inscrição',
        'localizacao' => 'Localização',
        'conservacao' => 'Conservação',
        'procedencia' => 'Procedência',
        'origem' => 'Origem',
        'revisao' => 'Revisão',
        'imagem_original' => 'Imagem Original',
    ];

    protected $dontKeepRevisionOf = array(
        'imagem_publica'
    );

    protected $fillable = [
        'ft_fundo_id',
        'ft_grupo_id',
        'ft_serie_id',
        'ft_tipologia_id',
        'data_imagem',
        'autoria',
        'imagem_identificacao',
        'bairro',
        'assunto_geral',
        'titulo',
        'identificacao',
        'assunto_1',
        'assunto_2',
        'assunto_3',
        'registro',
        'ft_cromia_id',
        'formato',
        'ft_categoria_id',
        'ft_campo_id',
        'tipo',
        'ft_ambiente_id',
        'enquadramento',
        'inscricao',
        'texto_inscricao',
        'localizacao',
        'conservacao',
        'procedencia',
        'origem',
        'revisao',
        'imagem_publica',
        'imagem_original',
    ];
    
    public function ftFundo()
    {
        return $this->belongsTo('ArqAdmin\Entities\FtFundo', 'ft_fundo_id');
    }

    public function ftGrupo()
    {
        return $this->belongsTo('ArqAdmin\Entities\FtGrupo', 'ft_grupo_id');
    }

    public function ftSerie()
    {
        return $this->belongsTo('ArqAdmin\Entities\FtSerie', 'ft_serie_id');
    }

    public function ftTipologia()
    {
        return $this->belongsTo('ArqAdmin\Entities\FtTipologia', 'ft_tipologia_id');
    }

    public function ftCromia()
    {
        return $this->belongsTo('ArqAdmin\Entities\FtCromia', 'ft_cromia_id');
    }

    public function ftCategoria()
    {
        return $this->belongsTo('ArqAdmin\Entities\FtCategoria', 'ft_categoria_id');
    }

    public function ftCampo()
    {
        return $this->belongsTo('ArqAdmin\Entities\FtCampo', 'ft_campo_id');
    }

    public function ftAmbiente()
    {
        return $this->belongsTo('ArqAdmin\Entities\FtAmbiente', 'ft_ambiente_id');
    }
}
