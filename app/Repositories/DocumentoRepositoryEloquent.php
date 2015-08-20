<?php

namespace ArqAdmin\Repositories;


use ArqAdmin\Models\Documento;
use ArqAdmin\Repositories\Contracts\DocumentoRepositoryInterface;

class DocumentoRepositoryEloquent implements DocumentoRepositoryInterface
{
    protected $documento;

    public function __construct(Documento $documento)
    {
        $this->documento = $documento;
    }

    public function find($id)
    {
        $result = $this->documento->find($id);
        return $result;
    }

    public function findAll(array $params = null)
    {
        $docs = $this->documento
            ->with('fundo', 'subfundo', 'grupo', 'subgrupo', 'serie', 'subserie',
                'dossie', 'especieDocumental', 'conservacao', 'lcSala', 'lcMovel',
                'lcCompartimento', 'lcAcondicionamento', 'dtUso', 'desenhosTecnicos');

        $docs->select('documento.*');

        $mapFilterFields = $this->mapFilterFields();

        if (isset($params['filter'])) {
            $filters = json_decode($params['filter'], true); // Decode the filter
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

        if (isset($params['com_imagem'])) {
            $docs->whereHas('DesenhosTecnicos', function ($query) {
                $query->havingRaw('count(id) > 0');
            });
        }

        if (isset($params['sort'])) {

            $sorters = json_decode($params['sort'], true); // Decode the filter

            foreach ($sorters as $sort) {

                if ('_id' === substr($sort['property'], -3)) {

                    $sortParamColumn = $sort['property'];
                    $sortRealColumn = $mapFilterFields[$sortParamColumn]['sort'];
                    $sortDirection = $sort['direction'];
                    $sortEntityName = $mapFilterFields[$sortRealColumn]['entity'];

                    $sortEntityRoot = '\ArqAdmin\Models\\' . $sortEntityName;
                    $ent = new $sortEntityRoot;
                    $sortTableName = $ent->getTable();

                    $docs->leftJoin($sortTableName, $sortTableName . '.id', '=', 'documento.' . $sortParamColumn)
                         ->orderBy($sortTableName . '.' . $sortRealColumn, $sortDirection);

                } else {
                    $docs->orderBy($mapFilterFields[$sort['property']]['column'],  $sort['direction']);
                };
            }
        } else {
            $docs->orderBy('id', 'DESC');
        }

        $limit = (isset($params['limit'])) ? $params['limit'] : '50';

//dd($docs->toSql());

        $result = $docs->paginate($limit);
//dd($result);
        return $result;
    }

    public function findFilter(array $params = null)
    {
        $docs = $this->documento
            ->leftJoin('fundo', 'documento.fundo_id', '=', 'fundo.id')
            ->leftJoin('subfundo', 'documento.subfundo_id', '=', 'subfundo.id')
            ->leftJoin('grupo', 'documento.grupo_id', '=', 'grupo.id')
            ->leftJoin('subgrupo', 'documento.subgrupo_id', '=', 'subgrupo.id')
            ->leftJoin('serie', 'documento.serie_id', '=', 'serie.id')
            ->leftJoin('subserie', 'documento.subserie_id', '=', 'subserie.id')
            ->leftJoin('dossie', 'documento.dossie_id', '=', 'dossie.id')
            ->leftJoin('especiedocumental', 'documento.especiedocumental_id', '=', 'especiedocumental.id')
            ->leftJoin('conservacao', 'documento.conservacao_id', '=', 'conservacao.id')
            ->leftJoin('lc_sala', 'documento.lc_sala_id', '=', 'lc_sala.id')
            ->leftJoin('lc_movel', 'documento.lc_movel_id', '=', 'lc_movel.id')
            ->leftJoin('lc_compartimento', 'documento.lc_compartimento_id', '=', 'lc_compartimento.id')
            ->leftJoin('lc_acondicionamento', 'documento.lc_acondicionamento_id', '=', 'lc_acondicionamento.id')
            ->leftJoin('dt_uso', 'documento.dt_uso_id', '=', 'dt_uso.id')
            //->leftJoin('desenhosTecnicos', 'documento._id', '=', '.id')

            ->select('documento.*', 'fundo.fundo_nome', 'subfundo.subfundo_nome', 'grupo.grupo_nome',
                'subgrupo.subgrupo_nome', 'serie.serie_nome', 'subserie.subserie_nome', 'dossie.dossie_nome',
                'especiedocumental.especiedocumental_nome', 'conservacao.conservacao_estado', 'lc_sala.sala',
                'lc_movel.movel', 'lc_compartimento.compartimento', 'lc_acondicionamento.acondicionamento',
                'dt_uso.uso');

        $limit = (isset($params['limit'])) ? $params['limit'] : '50';

//dd($docs->toSql());

        $result = $docs->paginate($limit);

        return $result;
    }

    public function parseFilter(array $filters)
    {
        $mapFilterFields = $this->mapFilterFields();

        foreach ($filters as $filter) {

            if (!isset($filter['property']) && !array_key_exists($filter['property'], $mapFilterFields)) {
                continue;
            }

            $field = $mapFilterFields[$filter['property']];
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
                case 'gt':
                    $operator = ">";
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


    public function fetchAuxiliarTable($modelName)
    {
        $models = [
            'Acervo',
            'Conservacao',
            'LcAcondicionamento',
            'LcCompartimento',
            'LcMovel',
            'LcSala',
            'Subserie',
            'Dossie',
            'DtUso',
            'Especiedocumental',
            'Fundo',
            'Grupo',
            'Serie',
            'Subfundo',
            'Subgrupo',
        ];

        // check if $modelName is allowed
        if (!in_array($modelName, $models)) {
            return false;
        }

        $model = '\\ArqAdmin\\Models\\' . $modelName;

        $data = $model::all();

        $result = [
            'total' => count($data),
            'data' => $data
        ];

        return $result;
    }

    public function mapFilterFields()
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
                'sort' => 'fundo_nome',
            ],
            'fundo_nome' => [
                'entity' => 'Fundo',
                'column' => 'fundo_nome',
                'type' => 'string',
            ],
            'subfundo_id' => [
                'entity' => 'Documento',
                'column' => 'subfundo_id',
                'type' => '=',
                'sort' => 'subfundo_nome',
            ],
            'subfundo_nome' => [
                'entity' => 'Subfundo',
                'column' => 'subfundo_nome',
                'type' => 'string',
            ],
            'grupo_id' => [
                'entity' => 'Documento',
                'column' => 'grupo_id',
                'type' => 'number',
                'sort' => 'grupo_nome',
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
                'sort' => 'subgrupo_nome',
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
                'sort' => 'serie_nome',
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
                'sort' => 'subserie_nome',
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
                'sort' => 'dossie_nome',
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
                'sort' => 'especiedocumental_nome',
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
                'sort' => 'conservacao_estado',
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
                'sort' => 'sala',
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
                'sort' => 'movel',
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
                'sort' => 'compartimento',
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
                'sort' => 'acondicionamento',
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
                'sort' => 'uso',
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