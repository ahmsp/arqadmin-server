<?php

namespace ArqAdmin\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use ArqAdmin\Repositories\GrupoRepository;
use ArqAdmin\Entities\Grupo;

/**
 * Class GrupoRepositoryEloquent
 * @package namespace ArqAdmin\Repositories;
 */
class GrupoRepositoryEloquent extends BaseRepository implements GrupoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Grupo::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
