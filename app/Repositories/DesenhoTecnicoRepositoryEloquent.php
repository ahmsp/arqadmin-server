<?php

namespace ArqAdmin\Repositories;

use ArqAdmin\Entities\DesenhoTecnico;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class DesenhoTecnicoRepositoryEloquent
 * @package namespace ArqAdmin\Repositories;
 */
class DesenhoTecnicoRepositoryEloquent extends BaseRepository implements DesenhoTecnicoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return DesenhoTecnico::class;
    }

//    /**
//     * Boot up the repository, pushing criteria
//     */
//    public function boot()
//    {
//        $this->pushCriteria(app(RequestCriteria::class));
//    }

    public function findAllWhere(array $params = null)
    {
        $data = $this->model
//            ->select('desenho_tecnico.*')
            ->with('dtTipo', 'dtSuporte', 'dtEscala', 'dtTecnica', 'dtConservacao', 'documento');

        if (isset($params['filter'])) {
            $filters = json_decode($params['filter'], true);

            foreach ($filters as $filter) {
                if (isset($filter['property']) && $filter['property'] === 'documento_id') {
                    $data->where('documento_id', $filter['value']);
                    break;
                }
            }

        }

        $result = $data->paginate(100);

//dd($data->toSql());
//dd($result);

        return $result;
    }
}
