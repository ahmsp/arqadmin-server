<?php

namespace ArqAdmin\Repositories;

use ArqAdmin\Entities\Fotografia;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class FotografiaRepositoryEloquent
 * @package namespace ArqAdmin\Repositories;
 */
class FotografiaRepositoryEloquent extends BaseRepository implements FotografiaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Fotografia::class;
    }

    /**
     * @param array|null $params
     * @return mixed
     */
    public function findAllWhere(array $params = null)
    {
        $model = $this->model
            ->select('fotografia.*')
            ->with('ftFundo', 'ftGrupo', 'ftSerie', 'ftTipologia', 'ftCromia', 'ftCategoria', 'ftCampo', 'ftAmbiente');

        $mapFields = $this->mapFields();

        if (isset($params['search_all'])) {
            $searchFields = [
                'autoria',
                'bairro',
                'assunto_geral',
                'titulo',
                'identificacao',
                'assunto_1',
                'assunto_2',
                'assunto_3',
                'texto_inscricao'
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

        if (isset($params['sort'])) {
            $sorters = json_decode($params['sort'], true); // Decode the filter

            foreach ($sorters as $sort) {
                $sortProperty = $sort['property'];

                if ($mapFields[$sortProperty]['entity'] !== 'Fotografia') {

                    $sortColumn = $mapFields[$sortProperty]['column'];
                    $sortEntityName = $mapFields[$sortProperty]['entity'];
                    $sortEntityRoot = '\ArqAdmin\Entities\\' . $sortEntityName;
                    $ent = new $sortEntityRoot;
                    $sortTableName = $ent->getTable();

                    $model->leftJoin($sortTableName, $sortTableName . '.id', '=', 'fotografia.' . $sortTableName . '_id')
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
        if ('Fotografia' === $param['model']) {
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
            'ft_fundo_id' => [
                'entity' => 'Fotografia',
                'column' => 'ft_fundo_id',
                'type' => 'number',
            ],
            'ft_fundo_nome' => [
                'entity' => 'FtFundo',
                'column' => 'ft_fundo_nome',
                'type' => 'string',
            ],
            'ft_grupo_id' => [
                'entity' => 'Fotografia',
                'column' => 'ft_grupo_id',
                'type' => 'number',
            ],
            'ft_grupo_nome' => [
                'entity' => 'FtGrupo',
                'column' => 'ft_grupo_nome',
                'type' => 'string',
            ],
            'ft_serie_id' => [
                'entity' => 'Fotografia',
                'column' => 'ft_serie_id',
                'type' => 'number',
            ],
            'ft_serie_nome' => [
                'entity' => 'FtSerie',
                'column' => 'ft_serie_nome',
                'type' => 'string',
            ],
            'ft_tipologia_id' => [
                'entity' => 'Fotografia',
                'column' => 'ft_tipologia_id',
                'type' => 'number',
            ],
            'ft_tipologia_nome' => [
                'entity' => 'FtTipologia',
                'column' => 'ft_tipologia_nome',
                'type' => 'string',
            ],
            'data_imagem' => [
                'entity' => 'Fotografia',
                'column' => 'data_imagem',
                'type' => 'string',
            ],
            'autoria' => [
                'entity' => 'Fotografia',
                'column' => 'autoria',
                'type' => 'string',
            ],
            'imagem_identificacao' => [
                'entity' => 'Fotografia',
                'column' => 'imagem_identificacao',
                'type' => 'string',
            ],
            'bairro' => [
                'entity' => 'Fotografia',
                'column' => 'bairro',
                'type' => 'string',
            ],
            'assunto_geral' => [
                'entity' => 'Fotografia',
                'column' => 'assunto_geral',
                'type' => 'string',
            ],
            'titulo' => [
                'entity' => 'Fotografia',
                'column' => 'titulo',
                'type' => 'string',
            ],
            'identificacao' => [
                'entity' => 'Fotografia',
                'column' => 'identificacao',
                'type' => 'string',
            ],
            'assunto_1' => [
                'entity' => 'Fotografia',
                'column' => 'assunto_1',
                'type' => 'string',
            ],
            'assunto_2' => [
                'entity' => 'Fotografia',
                'column' => 'assunto_2',
                'type' => 'string',
            ],
            'assunto_3' => [
                'entity' => 'Fotografia',
                'column' => 'assunto_3',
                'type' => 'string',
            ],
            'registro' => [
                'entity' => 'Fotografia',
                'column' => 'registro',
                'type' => 'string',
            ],
            'ft_cromia_id' => [
                'entity' => 'Fotografia',
                'column' => 'ft_cromia_id',
                'type' => 'number',
            ],
            'ft_cromia_nome' => [
                'entity' => 'FtCromia',
                'column' => 'ft_cromia_nome',
                'type' => 'string',
            ],
            'formato' => [
                'entity' => 'Fotografia',
                'column' => 'formato',
                'type' => 'string',
            ],
            'ft_categoria_id' => [
                'entity' => 'Fotografia',
                'column' => 'ft_categoria_id',
                'type' => 'number',
            ],
            'ft_categoria_nome' => [
                'entity' => 'FtCategoria',
                'column' => 'ft_categoria_nome',
                'type' => 'string',
            ],
            'ft_campo_id' => [
                'entity' => 'Fotografia',
                'column' => 'ft_campo_id',
                'type' => 'number',
            ],
            'ft_campo_nome' => [
                'entity' => 'FtCampo',
                'column' => 'ft_campo_nome',
                'type' => 'string',
            ],
            'tipo' => [
                'entity' => 'Fotografia',
                'column' => 'tipo',
                'type' => 'stringr',
            ],
            'ft_ambiente_id' => [
                'entity' => 'Fotografia',
                'column' => 'ft_ambiente_id',
                'type' => 'number',
            ],
            'ft_ambiente_nome' => [
                'entity' => 'FtAmbiente',
                'column' => 'ft_ambiente_nome',
                'type' => 'string',
            ],
            'enquadramento' => [
                'entity' => 'Fotografia',
                'column' => 'enquadramento',
                'type' => 'string',
            ],
            'inscricao' => [
                'entity' => 'Fotografia',
                'column' => 'inscricao',
                'type' => 'string',
            ],
            'texto_inscricao' => [
                'entity' => 'Fotografia',
                'column' => 'texto_inscricao',
                'type' => 'string',
            ],
            'localizacao' => [
                'entity' => 'Fotografia',
                'column' => 'localizacao',
                'type' => 'string',
            ],
            'conservacao' => [
                'entity' => 'Fotografia',
                'column' => 'conservacao',
                'type' => 'string',
            ],
            'procedencia' => [
                'entity' => 'Fotografia',
                'column' => 'procedencia',
                'type' => 'string',
            ],
            'origem' => [
                'entity' => 'Fotografia',
                'column' => 'origem',
                'type' => 'string',
            ],
            'revisao' => [
                'entity' => 'Fotografia',
                'column' => 'revisao',
                'type' => 'string',
            ],
            'imagem_publica' => [
                'entity' => 'Fotografia',
                'column' => 'imagem_publica',
                'type' => 'string',
            ],
            'imagem_original' => [
                'entity' => 'Fotografia',
                'column' => 'imagem_original',
                'type' => 'string',
            ],
        ];
    }
}
