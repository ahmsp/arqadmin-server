<?php

namespace ArqAdmin\Repositories;

use ArqAdmin\Entities\RegistroSepultamento;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class RegistroSepultamentoRepositoryEloquent
 * @package namespace ArqAdmin\Repositories;
 */
class RegistroSepultamentoRepositoryEloquent extends BaseRepository implements RegistroSepultamentoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return RegistroSepultamento::class;
    }

    public function findAllWhere(array $params = null)
    {
        $model = $this->model
            ->select('registro_sepultamento.*')
            ->with('lcSala', 'lcMovel', 'lcCompartimento', 'lcAcondicionamento',
                'conservacao', 'sfmCartorio', 'sfmCemiterio', 'sfmNacionalidade', 'sfmNaturalidade',
                'sfmEstadocivil', 'sfmCausamortis');

        if (isset($params['filter'])) {
            $filters = $params['filter'];
            if (is_string($filters)) {
                $filters = json_decode($filters, true);
            }
        }

        if (isset($params['search_all'])) {
            $searchFields = [
                'notas',
                'sfm_cartorio_cartorio',
                'sfm_cemiterio_cemiterio',
                'sfm_nome',
                'sfm_nacionalidade_nacionalidade',
                'sfm_naturalidade_naturalidade',
                'sfm_conjuge',
                'sfm_pai',
                'sfm_mae',
                'sfm_causamortis_causamortis',
            ];

            $filters = isset($filters) ? $filters : [];
            foreach ($searchFields as $field) {
                array_push($filters, [
                    'property' => $field,
                    'value' => $params['search_all'],
                    'operator' => 'like',
                    'logical_operator' => 'or'
                ]);
            }
        }

        $filterParams = (isset($filters)) ? $this->parseFilter($filters) : null;

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

        if (isset($params['sort'])) {
            $sorters = json_decode($params['sort'], true); // Decode the filter
            $mapFields = $this->mapFields();

            foreach ($sorters as $sort) {
                $sortProperty = $sort['property'];

                if ($mapFields[$sortProperty]['entity'] !== 'RegistroSepultamento') {

                    $sortColumn = $mapFields[$sortProperty]['column'];
                    $sortEntityName = $mapFields[$sortProperty]['entity'];
                    $sortEntityRoot = '\ArqAdmin\Entities\\' . $sortEntityName;
                    $ent = new $sortEntityRoot;
                    $sortTableName = $ent->getTable();

                    $model->leftJoin(
                        $sortTableName, $sortTableName . '.id', '=', 'registro_sepultamento.' . $sortTableName . '_id')
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

//        dd($model->toSql());
//        dd($result);

        return $result;
    }

    public function buildWhere($model, $param)
    {
        if ('RegistroSepultamento' === $param['model']) {
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
                'entity' => 'RegistroSepultamento',
                'column' => 'id',
                'type' => 'number',
            ],
            'ano' => [
                'entity' => 'RegistroSepultamento',
                'column' => 'ano',
                'type' => 'number',
            ],
            'ano_ini' => [
                'entity' => 'RegistroSepultamento',
                'column' => 'ano',
                'type' => 'number',
            ],
            'ano_fim' => [
                'entity' => 'RegistroSepultamento',
                'column' => 'ano',
                'type' => 'number',
            ],
            'notas' => [
                'entity' => 'RegistroSepultamento',
                'column' => 'notas',
                'type' => 'string',
            ],
            'lc_sala_id' => [
                'entity' => 'RegistroSepultamento',
                'column' => 'lc_sala_id',
                'type' => 'number',
            ],
            'lc_sala_sala' => [
                'entity' => 'LcSala',
                'column' => 'sala',
                'type' => 'string',
            ],
            'lc_movel_id' => [
                'entity' => 'RegistroSepultamento',
                'column' => 'lc_movel_id',
                'type' => 'number',
            ],
            'lc_movel_movel' => [
                'entity' => 'LcMovel',
                'column' => 'movel',
                'type' => 'string',
            ],
            'lc_movel_num' => [
                'entity' => 'RegistroSepultamento',
                'column' => 'lc_movel_num',
                'type' => 'string',
            ],
            'lc_compartimento_id' => [
                'entity' => 'RegistroSepultamento',
                'column' => 'lc_compartimento_id',
                'type' => 'number',
            ],
            'lc_compartimento_compartimento' => [
                'entity' => 'LcCompartimento',
                'column' => 'compartimento',
                'type' => 'string',
            ],
            'lc_compartimento_num' => [
                'entity' => 'RegistroSepultamento',
                'column' => 'lc_compartimento_num',
                'type' => 'string',
            ],
            'lc_acondicionamento_id' => [
                'entity' => 'RegistroSepultamento',
                'column' => 'lc_acondicionamento_id',
                'type' => 'number',
            ],
            'lc_acondicionamento_acondicionamento' => [
                'entity' => 'LcAcondicionamento',
                'column' => 'acondicionamento',
                'type' => 'string',
            ],
            'lc_acondicionamento_num' => [
                'entity' => 'RegistroSepultamento',
                'column' => 'lc_acondicionamento_num',
                'type' => 'string',
            ],
            'lc_pagina' => [
                'entity' => 'RegistroSepultamento',
                'column' => 'lc_pagina',
                'type' => 'string',
            ],
            'sfm_cartorio_id' => [
                'entity' => 'RegistroSepultamento',
                'column' => 'sfm_cartorio_id',
                'type' => 'number',
            ],
            'sfm_cartorio_cartorio' => [
                'entity' => 'SfmCartorio',
                'column' => 'cartorio',
                'type' => 'string',
            ],
            'sfm_cemiterio_id' => [
                'entity' => 'RegistroSepultamento',
                'column' => 'sfm_cemiterio_id',
                'type' => 'number',
            ],
            'sfm_cemiterio_cemiterio' => [
                'entity' => 'SfmCemiterio',
                'column' => 'cemiterio',
                'type' => 'string',
            ],
            'sfm_nome' => [
                'entity' => 'RegistroSepultamento',
                'column' => 'sfm_nome',
                'type' => 'string',
            ],
            'sfm_nacionalidade_id' => [
                'entity' => 'RegistroSepultamento',
                'column' => 'sfm_nacionalidade_id',
                'type' => 'number',
            ],
            'sfm_nacionalidade_nacionalidade' => [
                'entity' => 'SfmNacionalidade',
                'column' => 'nacionalidade',
                'type' => 'string',
            ],
            'sfm_naturalidade_id' => [
                'entity' => 'RegistroSepultamento',
                'column' => 'sfm_naturalidade_id',
                'type' => 'number',
            ],
            'sfm_naturalidade_naturalidade' => [
                'entity' => 'SfmNaturalidade',
                'column' => 'naturalidade',
                'type' => 'string',
            ],
            'sfm_idade' => [
                'entity' => 'RegistroSepultamento',
                'column' => 'sfm_idade',
                'type' => 'string',
            ],
            'sfm_estadocivil_id' => [
                'entity' => 'RegistroSepultamento',
                'column' => 'sfm_estadocivil_id',
                'type' => 'number',
            ],
            'sfm_estadocivil_estadocivil' => [
                'entity' => 'SfmEstadocivil',
                'column' => 'estadocivil',
                'type' => 'string',
            ],
            'sfm_conjuge' => [
                'entity' => 'RegistroSepultamento',
                'column' => 'sfm_conjuge',
                'type' => 'string',
            ],
            'sfm_pai' => [
                'entity' => 'RegistroSepultamento',
                'column' => 'sfm_pai',
                'type' => 'string',
            ],
            'sfm_mae' => [
                'entity' => 'RegistroSepultamento',
                'column' => 'sfm_mae',
                'type' => 'string',
            ],
            'sfm_data_morte' => [
                'entity' => 'RegistroSepultamento',
                'column' => 'sfm_data_morte',
                'type' => 'string',
            ],
            'sfm_causamortis_id' => [
                'entity' => 'RegistroSepultamento',
                'column' => 'sfm_causamortis_id',
                'type' => 'number',
            ],
            'sfm_causamortis_causamortis' => [
                'entity' => 'SfmCausamortis',
                'column' => 'causamortis',
                'type' => 'string',
            ],
            'sfm_sepult_localizacao' => [
                'entity' => 'RegistroSepultamento',
                'column' => 'sfm_sepult_localizacao',
                'type' => 'string',
            ],
        ];
    }

}
