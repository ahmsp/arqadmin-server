<?php

namespace ArqAdmin\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use ArqAdmin\Repositories\DtEscalaRepository;
use ArqAdmin\Entities\DtEscala;

/**
 * Class DtEscalaRepositoryEloquent
 * @package namespace ArqAdmin\Repositories;
 */
class DtEscalaRepositoryEloquent extends BaseRepository implements DtEscalaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return DtEscala::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
