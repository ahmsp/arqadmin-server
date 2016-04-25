<?php

namespace ArqAdmin\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use ArqAdmin\Repositories\DocumentoRepository;
use ArqAdmin\Entities\Documento;

/**
 * Class DocumentoRepositoryEloquent
 * @package namespace ArqAdmin\Repositories;
 */
class DocumentoRepositoryEloquent extends BaseRepository implements DocumentoRepository
{
    /**
     * @var array
     */
//    protected $fieldSearchable = [
//        'instituicao' => 'like',
//        'divisao' => 'like',
//        'subdivisao' => 'like',
//        'area' => 'like',
//        'nome' => 'like',
//        'email',
//        'telefone' => 'like',
//        'ramal' => 'like',
//    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Documento::class;
    }

//    /**
//     * Boot up the repository, pushing criteria
//     */
//    public function boot()
//    {
//        $this->pushCriteria(app(RequestCriteria::class));
//    }

    /**
     * @param array|null $params
     * @return mixed
     */
    public function findAllWhere(array $params = null)
    {
        $docs = $this->model
            ->select('documento.*')
            ->with('fundo', 'subfundo', 'grupo', 'subgrupo', 'serie', 'subserie',
                'dossie', 'especieDocumental', 'conservacao', 'lcSala', 'lcMovel',
                'lcCompartimento', 'lcAcondicionamento', 'dtUso', 'desenhosTecnicos',
                'desenhosTecnicos.dtTipo', 'desenhosTecnicos.dtSuporte', 'desenhosTecnicos.dtEscala',
                'desenhosTecnicos.dtTecnica', 'desenhosTecnicos.dtConservacao');

        $mapFields = $this->mapFields();

        if (isset($params['filter'])) {
            $filters = json_decode($params['filter'], true);
            if ($filters) {
                $filterParams = $this->parseFilter($filters);
            }
        }

        if (isset($filterParams)) {

            foreach ($filterParams as $param) {

                if ('Documento' === $param['model']) {
                    if ('in' === $param['operator']) {
                        $docs->whereIn($param['column'], $param['value']);
                    } else {
                        $docs->where($param['column'], $param['operator'], $param['value']);
                    }
                } else {
                    $docs->whereHas($param['model'], function ($query) use ($param) {
                        if ('in' === $param['operator']) {
                            $query->whereIn($param['column'], $param['value']);
                        } else {
                            $query->where($param['column'], $param['operator'], $param['value']);
                        }
                    });
                }
            }
        }

        if (isset($filters)) {

            foreach ($filters as $filter) {

                if (isset($filter['property']) && $filter['property'] == 'com_imagem') {
                    $docs->whereHas('DesenhosTecnicos', function ($query) {
                        $query->havingRaw('count(id) > 0');
                    });
                    break;
                }
            }

        }

        if (isset($params['sort'])) {

            $sorters = json_decode($params['sort'], true); // Decode the filter

            foreach ($sorters as $sort) {

                $sortProperty = $sort['property'];

                if ($mapFields[$sortProperty]['entity'] !== 'Documento') {

                    $sortColumn = $mapFields[$sortProperty]['column'];
                    $sortEntityName = $mapFields[$sortProperty]['entity'];
                    $sortEntityRoot = '\ArqAdmin\Entities\\' . $sortEntityName;
                    $ent = new $sortEntityRoot;
                    $sortTableName = $ent->getTable();

                    $docs->leftJoin($sortTableName, $sortTableName . '.id', '=', 'documento.' . $sortTableName . '_id')
                        ->orderBy($sortTableName . '.' . $sortColumn, $sort['direction']);

                } else {
                    $docs->orderBy($mapFields[$sort['property']]['column'], $sort['direction']);
                };
            }
        } else {
            $docs->orderBy('id', 'DESC');
        }

        $limit = (isset($params['limit'])) ? $params['limit'] : '50';

        $result = $docs->paginate($limit);

//dd($docs->toSql());
//dd($result);

        return $result;
    }

    public function parseFilter(array $filters)
    {
        $mapFields = $this->mapFields();
        $params = [];

        foreach ($filters as $filter) {

            if (!isset($filter['property']) || !array_key_exists($filter['property'], $mapFields)) {
                continue;
            }

            $field = $mapFields[$filter['property']];
            $model = $field['entity'];
            $column = $field['column'];

            $value = (isset($filter['value'])) ? $filter['value'] : '';

            if (is_array($value)) {
                $value = array_map('trim', preg_replace("/\s\s+/", ' ', $value));
            } else {
                $value = trim(preg_replace("/\s\s+/", ' ', $value));
            }

            switch ($filter['operator']) {
                case 'lt':
                    $operator = "<";
                    break;
                case 'lte':
                    $operator = "<=";
                    break;
                case 'gt':
                    $operator = ">";
                    break;
                case 'gte':
                    $operator = ">=";
                    break;
                case 'eq':
                    $operator = "=";
                    break;
                case 'in':
                    $operator = "in";
                    break;
                case '=': // boolean (ExtJS 5)
                    $operator = "=";
                    $value = (true === $value) ? '1' : '0';
                    break;
                case 'like':
                default:
                    $operator = "like";
                    $value = '%' . $value . '%';
                    break;
            }

            $params[] = [
                'model' => $model,
                'column' => $column,
                'operator' => $operator,
                'value' => $value
            ];
        }

        return $params;
    }

    public function mapFields()
    {
        return [
            'id' => [
                'entity' => 'Documento',
                'column' => 'id',
                'type' => 'number',
            ],
            'fundo_id' => [
                'entity' => 'Documento',
                'column' => 'fundo_id',
                'type' => 'number',
            ],
            'fundo_nome' => [
                'entity' => 'Fundo',
                'column' => 'fundo_nome',
                'type' => 'string',
            ],
            'subfundo_id' => [
                'entity' => 'Documento',
                'column' => 'subfundo_id',
                'type' => 'number',
            ],
            'subfundo_nome' => [
                'entity' => 'Subfundo',
                'column' => 'subfundo_nome',
                'type' => 'string',
            ],
            'grupo_id' => [
                'entity' => 'Documento',
                'column' => 'grupo_id',
                'type' => 'number'
            ],
            'grupo_nome' => [
                'entity' => 'Grupo',
                'column' => 'grupo_nome',
                'type' => 'string',
            ],
            'subgrupo_id' => [
                'entity' => 'Documento',
                'column' => 'subgrupo_id',
                'type' => 'number',
            ],
            'subgrupo_nome' => [
                'entity' => 'Subgrupo',
                'column' => 'subgrupo_nome',
                'type' => 'string',
            ],
            'serie_id' => [
                'entity' => 'Documento',
                'column' => 'serie_id',
                'type' => 'number',
            ],
            'serie_nome' => [
                'entity' => 'Serie',
                'column' => 'serie_nome',
                'type' => 'string',
            ],
            'subserie_id' => [
                'entity' => 'Documento',
                'column' => 'subserie_id',
                'type' => 'number',
            ],
            'subserie_nome' => [
                'entity' => 'Subserie',
                'column' => 'subserie_nome',
                'type' => 'string',
            ],
            'dossie_id' => [
                'entity' => 'Documento',
                'column' => 'dossie_id',
                'type' => 'number',
            ],
            'dossie_nome' => [
                'entity' => 'Dossie',
                'column' => 'dossie_nome',
                'type' => 'string',
            ],
            'especiedocumental_id' => [
                'entity' => 'Documento',
                'column' => 'especiedocumental_id',
                'type' => 'number',
            ],
            'especiedocumental_nome' => [
                'entity' => 'Especiedocumental',
                'column' => 'especiedocumental_nome',
                'type' => 'string',
            ],
            'notacao_preexistente' => [
                'entity' => 'Documento',
                'column' => 'notacao_preexistente',
                'type' => 'string',
            ],
            'notacao' => [
                'entity' => 'Documento',
                'column' => 'notacao',
                'type' => 'string',
            ],
            'ano' => [
                'entity' => 'Documento',
                'column' => 'ano',
                'type' => 'number',
            ],
            'ano_ini' => [
                'entity' => 'Documento',
                'column' => 'ano',
                'type' => 'number',
            ],
            'ano_fim' => [
                'entity' => 'Documento',
                'column' => 'ano',
                'type' => 'number',
            ],
            'data_doc' => [
                'entity' => 'Documento',
                'column' => 'data_doc',
                'type' => 'string',
            ],
            'processo_num' => [
                'entity' => 'Documento',
                'column' => 'processo_num',
                'type' => 'string',
            ],
            'quantidade_doc' => [
                'entity' => 'Documento',
                'column' => 'quantidade_doc',
                'type' => 'number',
            ],
            'conservacao_id' => [
                'entity' => 'Documento',
                'column' => 'conservacao_id',
                'type' => 'number',
            ],
            'conservacao_estado' => [
                'entity' => 'Conservacao',
                'column' => 'conservacao_estado',
                'type' => 'string',
            ],
            'interessado' => [
                'entity' => 'Documento',
                'column' => 'interessado',
                'type' => 'string',
            ],
            'assunto' => [
                'entity' => 'Documento',
                'column' => 'assunto',
                'type' => 'string',
            ],
            'notas' => [
                'entity' => 'Documento',
                'column' => 'notas',
                'type' => 'string',
            ],
            'lc_sala_id' => [
                'entity' => 'Documento',
                'column' => 'lc_sala_id',
                'type' => 'number',
            ],
            'lc_sala_sala' => [
                'entity' => 'LcSala',
                'column' => 'sala',
                'type' => 'string',
            ],
            'lc_movel_id' => [
                'entity' => 'Documento',
                'column' => 'lc_movel_id',
                'type' => 'number',
            ],
            'lc_movel_movel' => [
                'entity' => 'LcMovel',
                'column' => 'movel',
                'type' => 'string',
            ],
            'lc_movel_num' => [
                'entity' => 'Documento',
                'column' => 'lc_movel_num',
                'type' => 'string',
            ],
            'lc_compartimento_id' => [
                'entity' => 'Documento',
                'column' => 'lc_compartimento_id',
                'type' => 'number',
            ],
            'lc_compartimento_compartimento' => [
                'entity' => 'LcCompartimento',
                'column' => 'compartimento',
                'type' => 'string',
            ],
            'lc_compartimento_num' => [
                'entity' => 'Documento',
                'column' => 'lc_compartimento_num',
                'type' => 'string',
            ],
            'lc_acondicionamento_id' => [
                'entity' => 'Documento',
                'column' => 'lc_acondicionamento_id',
                'type' => 'number',
            ],
            'lc_acondicionamento_acondicionamento' => [
                'entity' => 'LcAcondicionamento',
                'column' => 'acondicionamento',
                'type' => 'string',
            ],
            'lc_acondicionamento_num' => [
                'entity' => 'Documento',
                'column' => 'lc_acondicionamento_num',
                'type' => 'string',
            ],
            'lc_pagina' => [
                'entity' => 'Documento',
                'column' => 'lc_pagina',
                'type' => 'string',
            ],
            'dt_uso_id' => [
                'entity' => 'Documento',
                'column' => 'dt_uso_id',
                'type' => 'number',
            ],
            'dt_uso_uso' => [
                'entity' => 'DtUso',
                'column' => 'uso',
                'type' => 'string',
            ],
            'dt_endereco' => [
                'entity' => 'Documento',
                'column' => 'dt_endereco',
                'type' => 'string',
            ],
            'dt_end_complemento' => [
                'entity' => 'Documento',
                'column' => 'dt_end_complemento',
                'type' => 'string',
            ],
            'dt_endereco_atual' => [
                'entity' => 'Documento',
                'column' => 'dt_endereco_atual',
                'type' => 'string',
            ],
            'dt_endatual_complemento' => [
                'entity' => 'Documento',
                'column' => 'dt_endatual_complemento',
                'type' => 'string',
            ],
            'dt_proprietario' => [
                'entity' => 'Documento',
                'column' => 'dt_proprietario',
                'type' => 'string',
            ],
            'dt_autor' => [
                'entity' => 'Documento',
                'column' => 'dt_autor',
                'type' => 'string',
            ],
            'dt_construtor' => [
                'entity' => 'Documento',
                'column' => 'dt_construtor',
                'type' => 'string',
            ],
            'dt_notas' => [
                'entity' => 'Documento',
                'column' => 'dt_notas',
                'type' => 'string'
            ],
        ];
    }
}
