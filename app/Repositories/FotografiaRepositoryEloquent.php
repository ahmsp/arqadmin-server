<?php

namespace ArqAdmin\Repositories;

use ArqAdmin\Entities\Fotografia;
use Conner\Likeable\Like;
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

        $model->with(['likable' => function($q){
            $q->where('user_id', auth()->user()->id);
        }]);

        
        if (isset($params['likes'])) {
            $model->whereLiked(auth()->user()->getAuthIdentifier())
                ->with('likeCounter'); // highly suggested to allow eager load
        }

        if (isset($params['filter']) && !isset($params['likes'])) {
            $filters = $params['filter'];
            if (is_string($filters)) {
                $filters = json_decode($filters, true);
            }
        }

        if (isset($params['search_all']) && !isset($params['likes'])) {
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

        if (isset($params['com_imagem']) && $params['com_imagem'] == 'true') {
            $model->whereNotNull('imagem_original');
        }

        if (isset($params['sort'])) {
            $sorters = json_decode($params['sort'], true); // Decode the filter
            $mapFields = $this->mapFields();

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

    public function countUserLikes()
    {
        return $this->model->whereLiked(auth()->id())->count();
    }

    /**
     * @param null $userId
     * @return mixed
     */
    public function findAllUserLikes($userId = null)
    {
        $id = $userId ?: auth()->id();

        $model = $this->model
            ->select('fotografia.*')
            ->with('ftFundo', 'ftGrupo', 'ftSerie', 'ftTipologia', 'ftCromia', 'ftCategoria', 'ftCampo', 'ftAmbiente');

        $model->whereLiked($id);
        $model->orderBy('id', 'DESC');

        return $model->get();
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

    public function like($id)
    {
        $model = $this->find($id);

        if ($model->liked()) {
            $model->unlike();
            $model->action = 'unlike';
        } else {
            $model->like();
            $model->action = 'like';
        }

        return $model;
    }

    /**
     * Delete likes related to the current record
     */
    public function removeUserLikes()
    {
        Like::where('likable_type', $this->model->getMorphClass())->where('user_id', auth()->id())->delete();
    }

    public function mapFields()
    {
        return [
            'id' => [
                'entity' => 'Fotografia',
                'column' => 'id',
                'type' => 'number',
            ],
            'ft_fundo_id' => [
                'entity' => 'Fotografia',
                'column' => 'ft_fundo_id',
                'type' => 'number',
            ],
            'fundo' => [
                'entity' => 'FtFundo',
                'column' => 'fundo',
                'type' => 'string',
            ],
            'ft_grupo_id' => [
                'entity' => 'Fotografia',
                'column' => 'ft_grupo_id',
                'type' => 'number',
            ],
            'grupo' => [
                'entity' => 'FtGrupo',
                'column' => 'grupo',
                'type' => 'string',
            ],
            'ft_serie_id' => [
                'entity' => 'Fotografia',
                'column' => 'ft_serie_id',
                'type' => 'number',
            ],
            'serie' => [
                'entity' => 'FtSerie',
                'column' => 'serie',
                'type' => 'string',
            ],
            'ft_tipologia_id' => [
                'entity' => 'Fotografia',
                'column' => 'ft_tipologia_id',
                'type' => 'number',
            ],
            'tipologia' => [
                'entity' => 'FtTipologia',
                'column' => 'tipologia',
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
            'cromia' => [
                'entity' => 'FtCromia',
                'column' => 'cromia',
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
            'categoria' => [
                'entity' => 'FtCategoria',
                'column' => 'categoria',
                'type' => 'string',
            ],
            'ft_campo_id' => [
                'entity' => 'Fotografia',
                'column' => 'ft_campo_id',
                'type' => 'number',
            ],
            'campo' => [
                'entity' => 'FtCampo',
                'column' => 'campo',
                'type' => 'string',
            ],
            'tipo' => [
                'entity' => 'Fotografia',
                'column' => 'tipo',
                'type' => 'string',
            ],
            'ft_ambiente_id' => [
                'entity' => 'Fotografia',
                'column' => 'ft_ambiente_id',
                'type' => 'number',
            ],
            'ambiente' => [
                'entity' => 'FtAmbiente',
                'column' => 'ambiente',
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
