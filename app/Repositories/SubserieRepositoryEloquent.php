<?php

namespace ArqAdmin\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use ArqAdmin\Repositories\SubserieRepository;
use ArqAdmin\Entities\Subserie;

/**
 * Class SubserieRepositoryEloquent
 * @package namespace ArqAdmin\Repositories;
 */
class SubserieRepositoryEloquent extends BaseRepository implements SubserieRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Subserie::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
