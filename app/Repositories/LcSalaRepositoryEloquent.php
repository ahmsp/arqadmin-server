<?php

namespace ArqAdmin\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use ArqAdmin\Repositories\LcSalaRepository;
use ArqAdmin\Entities\LcSala;

/**
 * Class LcSalaRepositoryEloquent
 * @package namespace ArqAdmin\Repositories;
 */
class LcSalaRepositoryEloquent extends BaseRepository implements LcSalaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return LcSala::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
