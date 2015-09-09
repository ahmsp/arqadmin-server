<?php

namespace ArqAdmin\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use ArqAdmin\Repositories\DesenhoTecnicoRepository;
use ArqAdmin\Entities\DesenhoTecnico;

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

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function findAllWhere()
    {
        $data = $this->model
            ->with('dtTipo', 'dtSuporte', 'dtEscala', 'dtTecnica', 'dtConservacao', 'documento')
            ->paginate(100);

        return $data;
    }
}