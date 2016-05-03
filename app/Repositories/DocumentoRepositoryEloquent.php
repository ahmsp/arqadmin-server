<?php

namespace ArqAdmin\Repositories;

use ArqAdmin\Entities\Documento;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class DocumentoRepositoryEloquent
 * @package namespace ArqAdmin\Repositories;
 */
class DocumentoRepositoryEloquent extends BaseRepository implements DocumentoRepository
{
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
        $model = $this->model
            ->select('documento.*')
            ->with('fundo', 'subfundo', 'grupo', 'subgrupo', 'serie', 'subserie',
                'dossie', 'especieDocumental', 'conservacao', 'lcSala', 'lcMovel',
                'lcCompartimento', 'lcAcondicionamento', 'dtUso', 'desenhosTecnicos',
                'desenhosTecnicos.dtTipo', 'desenhosTecnicos.dtSuporte', 'desenhosTecnicos.dtEscala',
                'desenhosTecnicos.dtTecnica', 'desenhosTecnicos.dtConservacao');

        $mapFields = $this->mapFields();

        if (isset($params['search_all'])) {
            $searchFields = [
                'interessado',
                'assunto',
                'notas',
                'dt_endereco',
                'dt_end_complemento',
                'dt_endereco_atual',
                'dt_endatual_complemento',
                'dt_proprietario',
                'dt_autor',
                'dt_construtor',
                'dt_notas',
                'desenho_tecnico_descricao'
            ];

            $params['filter'] = [];
            foreach ($searchFields as $field) {
                $params['filter'][] = [
                    'property' => $field,
                    'value' => $params['search_all'],
                    'operator' => 'like',
                    'logical_operator' => 'or'
                ];
            }
        }

        if (isset($params['filter'])) {
            $filters = $params['filter'];
            if (is_string($filters)) {
                $filters = json_decode($filters, true);
            }
            $filterParams = $this->parseFilter($filters);
        }

        if (isset($filterParams) && isset($filterParams['and'])) {
            foreach ($filterParams['and'] as $param) {
                $this->buildWhere($model, $param);
            }
        }

        //group the WHERE clauses when logical operator is OR
        if (isset($filterParams) && isset($filterParams['or'])) {
            $model->where(function ($query) use ($filterParams) {
                foreach ($filterParams['or'] as $param) {
                    $this->buildWhere($query, $param);
                }
            });
        }

        if (isset($filters)) {
            foreach ($filters as $filter) {
                if (isset($filter['property']) && $filter['property'] == 'com_imagem') {
                    $model->whereHas('DesenhosTecnicos', function ($query) {
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

                    $model->leftJoin($sortTableName, $sortTableName . '.id', '=', 'documento.' . $sortTableName . '_id')
                        ->orderBy($sortTableName . '.' . $sortColumn, $sort['direction']);

                } else {
                    $model->orderBy($mapFields[$sort['property']]['column'], $sort['direction']);
                };
            }
        } else {
            $model->orderBy('id', 'DESC');
        }

        $limit = (isset($params['limit'])) ? $params['limit'] : '50';

        $result = $model->paginate($limit);

//dd($model->toSql());
//dd($result);

        return $result;
    }

    public function buildWhere($model, $param)
    {
        if ('Documento' === $param['model']) {
            if ('in' === $param['operator']) {
                return $model->whereIn($param['column'], $param['value'], $param['boolean'], $param['not']);
            } else {
                return $model->where($param['column'], $param['operator'], $param['value'], $param['boolean']);
            }
        } else {
            if ($param['boolean'] === 'or') {
                $model->orWhereHas($param['model'], function ($query) use ($param) {
                    $param['boolean'] = 'and';
                    $param['not'] = false;

                    if ('in' === $param['operator']) {
                        return $query->whereIn($param['column'], $param['value'], $param['boolean'], $param['not']);
                    } else {
                        return $query->where($param['column'], $param['operator'], $param['value'], $param['boolean']);
                    }
                });
            } else {
                $model->whereHas($param['model'], function ($query) use ($param) {
                    if ('in' === $param['operator']) {
                        return $query->whereIn($param['column'], $param['value'], $param['boolean'], $param['not']);
                    } else {
                        return $query->where($param['column'], $param['operator'], $param['value'], $param['boolean']);
                    }
                });
            }
        }

        return false;
    }

    public function parseFilter(array $filters)
    {
        $mapFields = $this->mapFields();
        $params = [];

        foreach ($filters as $filter) {

            if (!isset($filter['property']) || !array_key_exists($filter['property'], $mapFields)) {
                continue;
            }

            $boolean = 'and';
            $not = false;

            $field = $mapFields[$filter['property']];
            $model = $field['entity'];
            $column = $field['column'];
            $type = $field['type'];

            if (isset($filter['operator'])) {
                $filterOperator = $filter['operator'];
            } else {
                $filterOperator = ($type === 'number') ? 'eq' : 'like';
            }

            if (isset($filter['logical_operator'])) {
                if ($filter['logical_operator'] === 'or') {
                    $boolean = 'or';
                } elseif ($filter['logical_operator'] === 'not') {
                    $boolean = 'and';
                    $not = true;
                }
            }

            $value = (isset($filter['value'])) ? $filter['value'] : '';

            if (is_array($value)) {
                $value = array_map('trim', preg_replace("/\s\s+/", ' ', $value));
            } else {
                $value = trim(preg_replace("/\s\s+/", ' ', $value));
            }

            switch ($filterOperator) {
                case 'lt':
                    $operator = "<";
                    break;
                case 'neq':
                    $operator = "<>";
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
                    $operator = (!$not) ? "=" : "<>";
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
//                    $operator = "like";
                    $operator = (!$not) ? "like" : "not like";
                    $value = '%' . $value . '%';
                    break;
            }

            $params[] = [
                'model' => $model,
                'column' => $column,
                'operator' => $operator,
                'value' => $value,
                'boolean' => $boolean,
                'not' => $not
            ];
        }

        $collection = collect($params);

        $operatorsAnd = $collection->filter(function ($param) {
            return $param['boolean'] === 'and';
        })->all();

        $operatorsOr = $collection->filter(function ($param) {
            return $param['boolean'] === 'or';
        })->all();

        $params = [
            'and' => $operatorsAnd,
            'or' => $operatorsOr
        ];

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
            'desenho_tecnico_descricao' => [
                'entity' => 'DesenhosTecnicos',
                'column' => 'descricao',
                'type' => 'string',
            ],
        ];
    }
}
